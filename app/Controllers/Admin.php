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
        
        // Get date filter, default to today
        $dateFilter = $this->request->getGet('date') ?? date('Y-m-d');
        
        // Base query
        $query = $this->songRequestModel;
        
        // Apply status/payment filter
        switch ($filter) {
            case 'pending':
                $query = $query->where('status', 'pending');
                break;
            case 'approved':
                $query = $query->where('status', 'approved');
                break;
            case 'rejected':
                $query = $query->where('status', 'rejected');
                break;
            case 'paid':
                $query = $query->where('payment_status', 'completed');
                break;
        }
        
        // Apply date filter - filter by created_at date
        if ($dateFilter) {
            $query = $query->where('DATE(created_at)', $dateFilter);
        }
        
        $requests = $query->orderBy('created_at','desc')->findAll();

        $data = [
            'requests' => $requests,
            'filter' => $filter,
            'dateFilter' => $dateFilter,
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
        if (strtoupper($this->request->getMethod()) === 'POST') {
            try {
                $request = $this->songRequestModel->find($id);
                
                if (!$request) {
                    return $this->response
                        ->setStatusCode(404)
                        ->setHeader('Content-Type', 'application/json')
                        ->setJSON(['status' => 'error', 'message' => 'Request not found']);
                }
                
                if ($request['payment_status'] !== 'completed') {
                    return $this->response
                        ->setStatusCode(400)
                        ->setHeader('Content-Type', 'application/json')
                        ->setJSON(['status' => 'error', 'message' => 'Payment must be completed before approving']);
                }
                
                $result = $this->songRequestModel->update($id, [
                    'status' => 'approved'
                ]);

                return $this->response
                    ->setHeader('Content-Type', 'application/json')
                    ->setJSON(['status' => 'success', 'message' => 'Request approved']);
            } catch (\Exception $e) {
                return $this->response
                    ->setStatusCode(400)
                    ->setHeader('Content-Type', 'application/json')
                    ->setJSON(['status' => 'error', 'message' => 'Failed to approve request']);
            }
        }
        
        return $this->response
            ->setStatusCode(400)
            ->setHeader('Content-Type', 'application/json')
            ->setJSON(['status' => 'error', 'message' => 'Invalid request']);
    }

    /**
     * Reject a song request
     */
    public function rejectRequest($id)
    {
        if (strtoupper($this->request->getMethod()) === 'POST') {
            try {
                $request = $this->songRequestModel->find($id);
                
                if (!$request) {
                    return $this->response
                        ->setStatusCode(404)
                        ->setHeader('Content-Type', 'application/json')
                        ->setJSON(['status' => 'error', 'message' => 'Request not found']);
                }
                
                if ($request['payment_status'] !== 'completed') {
                    return $this->response
                        ->setStatusCode(400)
                        ->setHeader('Content-Type', 'application/json')
                        ->setJSON(['status' => 'error', 'message' => 'Payment must be completed before rejecting']);
                }
                
                $reason = $this->request->getPost('reason') ?? '';
                
                $result = $this->songRequestModel->update($id, [
                    'status' => 'rejected'
                ]);

                return $this->response
                    ->setHeader('Content-Type', 'application/json')
                    ->setJSON(['status' => 'success', 'message' => 'Request rejected']);
            } catch (\Exception $e) {
                return $this->response
                    ->setStatusCode(400)
                    ->setHeader('Content-Type', 'application/json')
                    ->setJSON(['status' => 'error', 'message' => 'Failed to reject request']);
            }
        }
        
        return $this->response
            ->setStatusCode(400)
            ->setHeader('Content-Type', 'application/json')
            ->setJSON(['status' => 'error', 'message' => 'Invalid request']);
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
