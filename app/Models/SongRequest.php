<?php

namespace App\Models;

use CodeIgniter\Model;

class SongRequest extends Model
{
    protected $table            = 'song_requests';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name',
        'phone',
        'song_name',
        'singer_name',
        'screenshot',
        'razorpay_order_id',
        'razorpay_payment_id',
        'status',
        'payment_status',
        'created_at',
        'updated_at'
    ];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'name'        => 'required|string|max_length[100]',
        'phone'       => 'required|string|max_length[20]|regex_match[/^[0-9]{10}$/]',
        'song_name'   => 'required|string|max_length[200]',
        'singer_name' => 'string|max_length[200]',
        'screenshot'  => 'string|max_length[300]',
    ];

    protected $validationMessages = [
        'phone' => [
            'regex_match' => 'Phone number must be exactly 10 digits',
        ],
    ];

    protected $skipValidation       = true;
    protected $cleanValidationRules = true;

    /**
     * Create a new song request
     */
    public function createRequest($data)
    {
        return $this->insert($data);
    }

    /**
     * Get request by ID
     */
    public function getRequestById($id)
    {
        return $this->find($id);
    }

    /**
     * Update razorpay order ID
     */
    public function updateOrderId($id, $orderId)
    {
        return $this->update($id, [
            'razorpay_order_id' => $orderId
        ]);
    }

    /**
     * Update payment status after successful payment
     */
    public function updatePaymentStatus($id, $paymentId, $signature)
    {
        return $this->update($id, [
            'payment_status'      => 'completed',
            'razorpay_payment_id' => $paymentId,
            'status'              => 'pending'// Set to pending until admin approves
        ]);
    }

    /**
     * Get all pending requests
     */
    public function getPendingRequests()
    {
        return $this->where('status', 'pending')->findAll();
    }

    /**
     * Get all approved requests
     */
    public function getApprovedRequests()
    {
        return $this->where('status', 'approved')->findAll();
    }

    /**
     * Get request by razorpay order ID
     */
    public function getByRazorpayOrderId($orderId)
    {
        return $this->where('razorpay_order_id', $orderId)->first();
    }
}
