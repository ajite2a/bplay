<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\SongRequest;

class Payment extends Controller
{
    protected $songRequestModel;
    protected $razorpayKeyId;
    protected $razorpayKeySecret;

    public function __construct()
    {
        $this->songRequestModel = new SongRequest();
        $this->razorpayKeyId = getenv('RAZORPAY_KEY_ID') ?? 'your_razorpay_key_id';
        $this->razorpayKeySecret = getenv('RAZORPAY_KEY_SECRET') ?? 'your_razorpay_key_secret';
    }

    public function submit()
    {
        try {
            if (!$this->request->isAJAX() || strtoupper($this->request->getMethod()) !== 'POST') {
                echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
                return;
            }

            // Get form data
            $name = $this->request->getPost('name');
            $phone = $this->request->getPost('phone');
            $song_name = $this->request->getPost('song_name');
            $singer_name = $this->request->getPost('singer_name');
            $screenshot = $this->request->getFile('screenshot');

            // Validation
            if (!$name || !$phone || !$song_name) {
                echo json_encode(['status' => 'error', 'message' => 'Please fill all required fields']);
                return;
            }

            // Validate phone number
            if (!preg_match('/^[0-9]{10}$/', $phone)) {
                echo json_encode(['status' => 'error', 'message' => 'Invalid phone number']);
                return;
            }

            // Handle file upload
            $screenshotPath = null;
            if ($screenshot && $screenshot->isValid() && !$screenshot->hasMoved()) {
                if (!is_dir('uploads')) {
                    mkdir('uploads', 0777, true);
                }
                $newName = $screenshot->getRandomName();
                $screenshot->move('uploads', $newName);
                $screenshotPath = 'uploads/' . $newName;
            }

            // Insert into database
            $data = [
                'name' => $name,
                'phone' => $phone,
                'song_name' => $song_name,
                'singer_name' => $singer_name,
                'screenshot' => $screenshotPath,
                'status' => 'pending',
                'payment_status' => 'pending'
            ];

            // Disable validation and insert
            $this->songRequestModel->skipValidation(true);
            $inserted = $this->songRequestModel->insert($data);

            if (!$inserted) {
                $errors = $this->songRequestModel->errors();
                $errorMsg = !empty($errors) ? implode(', ', $errors) : 'Database error occurred';
                log_message('error', 'Insert failed - Data: ' . json_encode($data) . ' - Errors: ' . $errorMsg);
                echo json_encode(['status' => 'error', 'message' => 'Failed to save request: ' . $errorMsg]);
                return;
            }

            $requestId = $this->songRequestModel->insertID();
            
            if (!$requestId) {
                log_message('error', 'Could not retrieve insertID after successful insert');
                echo json_encode(['status' => 'error', 'message' => 'Failed to retrieve request ID']);
                return;
            }

            // Create Razorpay order
            $razorpayOrder = $this->createRazorpayOrder($requestId, 50000); // Amount in paise (500 INR)

            if ($razorpayOrder && isset($razorpayOrder['id'])) {
                // Update order id using model
                $this->songRequestModel->updateOrderId($requestId, $razorpayOrder['id']);

                echo json_encode([
                    'status' => 'success',
                    'id' => $requestId,
                    'order_id' => $razorpayOrder['id']
                ]);
                return;
            }

            echo json_encode(['status' => 'error', 'message' => 'Failed to create payment order']);
        } catch (\Exception $e) {
            log_message('error', 'Payment Submit Error: ' . $e->getMessage());
            echo json_encode(['status' => 'error', 'message' => 'Server error: ' . $e->getMessage()]);
        }
    }

    private function createRazorpayOrder($requestId, $amount)
    {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://api.razorpay.com/v1/orders');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERPWD, $this->razorpayKeyId . ':' . $this->razorpayKeySecret);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
                'amount' => $amount,
                'currency' => 'INR',
                'receipt' => 'receipt_' . $requestId,
                'notes' => [
                    'request_id' => $requestId
                ]
            ]));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($ch);
            $error = curl_error($ch);
            curl_close($ch);

            if ($error) {
                log_message('error', 'Razorpay CURL Error: ' . $error);
                return null;
            }

            return json_decode($response, true);
        } catch (\Exception $e) {
            log_message('error', 'Razorpay Order Creation Error: ' . $e->getMessage());
            return null;
        }
    }

    public function handleCallback()
    {
        try {
            if (strtoupper($this->request->getMethod()) !== 'POST') {
                echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
                return;
            }

            $razorpayPaymentId = $this->request->getPost('razorpay_payment_id');
            $razorpayOrderId = $this->request->getPost('razorpay_order_id');
            $razorpaySignature = $this->request->getPost('razorpay_signature');
            $requestId = $this->request->getPost('request_id');

            // Verify signature
            if ($this->verifyRazorpaySignature($razorpayOrderId, $razorpayPaymentId, $razorpaySignature)) {
                // Update payment status using model
                $this->songRequestModel->updatePaymentStatus($requestId, $razorpayPaymentId, $razorpaySignature);

                echo json_encode(['status' => 'success', 'message' => 'Payment verified successfully']);
                return;
            }

            echo json_encode(['status' => 'error', 'message' => 'Payment verification failed']);
        } catch (\Exception $e) {
            log_message('error', 'Payment Callback Error: ' . $e->getMessage());
            echo json_encode(['status' => 'error', 'message' => 'Server error: ' . $e->getMessage()]);
        }
    }

    private function verifyRazorpaySignature($orderId, $paymentId, $signature)
    {
        try {
            $expectedSignature = hash_hmac('sha256', $orderId . '|' . $paymentId, $this->razorpayKeySecret);
            return hash_equals($expectedSignature, $signature);
        } catch (\Exception $e) {
            log_message('error', 'Signature Verification Error: ' . $e->getMessage());
            return false;
        }
    }

    public function success()
    {
        $data['title'] = 'Payment Successful';
        return view('payment_success', $data);
    }

    public function failed()
    {
        $data['title'] = 'Payment Failed';
        return view('payment_failed', $data);
    }
}
