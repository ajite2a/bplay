<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\SongRequest;

class Admin extends Controller
{
    protected $songRequestModel;

    public function __construct()
    {
        $this->songRequestModel = new SongRequest();
    }

    /**
     * Display the admin dashboard with all song requests
     */
    public function dashboard()
    {
        // Get filter from request
        $filter = $this->request->getGet('filter') ?? 'all';
        
        // Get all requests based on filter
        switch ($filter) {
            case 'pending':
                $requests = $this->songRequestModel->where('status', 'pending')->findAll();
                break;
            case 'approved':
                $requests = $this->songRequestModel->where('status', 'approved')->findAll();
                break;
            case 'rejected':
                $requests = $this->songRequestModel->where('status', 'rejected')->findAll();
                break;
            case 'paid':
                $requests = $this->songRequestModel->where('payment_status', 'completed')->findAll();
                break;
            default:
                $requests = $this->songRequestModel->findAll();
        }

        $data = [
            'requests' => $requests,
            'filter' => $filter,
            'totalRequests' => $this->songRequestModel->countAll(),
            'pendingCount' => $this->songRequestModel->where('status', 'pending')->countAllResults(),
            'approvedCount' => $this->songRequestModel->where('status', 'approved')->countAllResults(),
            'paidCount' => $this->songRequestModel->where('payment_status', 'completed')->countAllResults(),
        ];

        return view('admin/dashboard', $data);
    }

    /**
     * Approve a song request
     */
    public function approveRequest($id)
    {
        if ($this->request->isAJAX() && strtoupper($this->request->getMethod()) === 'POST') {
            $result = $this->songRequestModel->update($id, [
                'status' => 'approved'
            ]);

            if ($result) {
                echo json_encode(['status' => 'success', 'message' => 'Request approved']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to approve request']);
            }
        }
    }

    /**
     * Reject a song request
     */
    public function rejectRequest($id)
    {
        if ($this->request->isAJAX() && strtoupper($this->request->getMethod()) === 'POST') {
            $reason = $this->request->getPost('reason') ?? '';
            
            $result = $this->songRequestModel->update($id, [
                'status' => 'rejected'
            ]);

            if ($result) {
                echo json_encode(['status' => 'success', 'message' => 'Request rejected']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to reject request']);
            }
        }
    }

    /**
     * View request details
     */
    public function viewRequest($id)
    {
        $request = $this->songRequestModel->find($id);

        if (!$request) {
            return redirect()->to('/admin/dashboard')->with('error', 'Request not found');
        }

        $data = [
            'request' => $request
        ];

        return view('admin/view_request', $data);
    }

    /**
     * Export requests to CSV
     */
    public function exportCsv()
    {
        $requests = $this->songRequestModel->findAll();

        $filename = 'song_requests_' . date('Y-m-d_His') . '.csv';
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);

        $output = fopen('php://output', 'w');

        // Add CSV headers
        fputcsv($output, ['ID', 'Name', 'Phone', 'Song Name', 'Singer Name', 'Status', 'Payment Status', 'Created Date']);

        // Add data
        foreach ($requests as $request) {
            fputcsv($output, [
                $request['id'],
                $request['name'],
                $request['phone'],
                $request['song_name'],
                $request['singer_name'],
                $request['status'],
                $request['payment_status'],
                $request['created_at']
            ]);
        }

        fclose($output);
        exit;
    }
}
