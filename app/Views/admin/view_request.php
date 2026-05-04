<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Details</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 2em;
        }

        .btn-back {
            background: white;
            color: #667eea;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
        }

        .btn-back:hover {
            background: #f0f0f0;
        }

        .content {
            padding: 30px;
        }

        .detail-section {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 1.3em;
            color: #333;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #667eea;
        }

        .detail-row {
            display: grid;
            grid-template-columns: 200px 1fr;
            gap: 30px;
            margin-bottom: 15px;
            align-items: start;
        }

        .detail-label {
            font-weight: 600;
            color: #555;
        }

        .detail-value {
            color: #333;
            word-break: break-word;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-approved {
            background: #d1fae5;
            color: #065f46;
        }

        .status-rejected {
            background: #fee2e2;
            color: #991b1b;
        }

        .payment-pending {
            background: #e0e7ff;
            color: #3730a3;
        }

        .payment-completed {
            background: #ccfbf1;
            color: #134e4a;
        }

        .screenshot-container {
            margin-top: 15px;
        }

        .screenshot-img {
            max-width: 400px;
            max-height: 400px;
            border-radius: 8px;
            border: 2px solid #ddd;
        }

        .no-screenshot {
            color: #999;
            font-style: italic;
        }

        .actions {
            display: flex;
            gap: 10px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #eee;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }

        .btn-approve {
            background: #10b981;
            color: white;
        }

        .btn-approve:hover {
            background: #059669;
        }

        .btn-reject {
            background: #ef4444;
            color: white;
        }

        .btn-reject:hover {
            background: #dc2626;
        }

        .btn-primary {
            background: #667eea;
            color: white;
        }

        .btn-primary:hover {
            background: #5568d3;
        }

        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .btn:disabled:hover {
            background-color: inherit;
        }

        .payment-notice {
            background: #fef3c7;
            border: 1px solid #fcd34d;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
            color: #92400e;
            font-weight: 500;
        }

        @media (max-width: 600px) {
            .header {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }

            .detail-row {
                grid-template-columns: 1fr;
            }

            .actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                text-align: center;
            }

            .screenshot-img {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Request #<?php echo $request['id']; ?></h1>
            <a href="/admin/dashboard" class="btn-back">← Back to Dashboard</a>
        </div>

        <div class="content">
            <!-- Personal Information -->
            <div class="detail-section">
                <div class="section-title">👤 Personal Information</div>
                <div class="detail-row">
                    <div class="detail-label">Name:</div>
                    <div class="detail-value"><?php echo htmlspecialchars($request['name']); ?></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Phone:</div>
                    <div class="detail-value"><?php echo htmlspecialchars($request['phone']); ?></div>
                </div>
            </div>

            <!-- Song Information -->
            <div class="detail-section">
                <div class="section-title">🎵 Song Information</div>
                <div class="detail-row">
                    <div class="detail-label">Song Name:</div>
                    <div class="detail-value"><?php echo htmlspecialchars($request['song_name']); ?></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Singer Name:</div>
                    <div class="detail-value"><?php echo htmlspecialchars($request['singer_name'] ?? '-'); ?></div>
                </div>
            </div>

            <!-- Status Information -->
            <div class="detail-section">
                <div class="section-title">📊 Status Information</div>
                <div class="detail-row">
                    <div class="detail-label">Request Status:</div>
                    <div class="detail-value">
                        <span class="status-badge status-<?php echo strtolower($request['status']); ?>">
                            <?php echo ucfirst($request['status']); ?>
                        </span>
                    </div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Payment Status:</div>
                    <div class="detail-value">
                        <span class="status-badge payment-<?php echo strtolower($request['payment_status']); ?>">
                            <?php echo ucfirst($request['payment_status']); ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Payment Information -->
            <div class="detail-section">
                <div class="section-title">💳 Payment Information</div>
                <div class="detail-row">
                    <div class="detail-label">Razorpay Order ID:</div>
                    <div class="detail-value"><?php echo htmlspecialchars($request['razorpay_order_id'] ?? '-'); ?></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Razorpay Payment ID:</div>
                    <div class="detail-value"><?php echo htmlspecialchars($request['razorpay_payment_id'] ?? '-'); ?></div>
                </div>
            </div>

            <!-- Screenshot -->
            <?php if ($request['screenshot']): ?>
                <div class="detail-section">
                    <div class="section-title">📸 Screenshot</div>
                    <div class="screenshot-container">
                        <img src="<?php echo htmlspecialchars($request['screenshot']); ?>" alt="Screenshot" class="screenshot-img">
                    </div>
                </div>
            <?php endif; ?>

            <!-- Timestamps -->
            <div class="detail-section">
                <div class="section-title">⏱️ Timestamps</div>
                <div class="detail-row">
                    <div class="detail-label">Created:</div>
                    <div class="detail-value"><?php echo date('M d, Y H:i:s', strtotime($request['created_at'])); ?></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Updated:</div>
                    <div class="detail-value"><?php echo date('M d, Y H:i:s', strtotime($request['updated_at'])); ?></div>
                </div>
            </div>

            <!-- Actions -->
            <?php if ($request['status'] === 'pending'): ?>
                <?php if ($request['payment_status'] !== 'completed'): ?>
                    <div class="payment-notice">
                        ⚠️ Payment must be completed before you can approve or reject this request.
                    </div>
                <?php endif; ?>
                <div class="actions">
                    <button class="btn btn-approve" onclick="approveRequest(<?php echo $request['id']; ?>)" <?php echo $request['payment_status'] !== 'completed' ? 'disabled' : ''; ?>>✓ Approve Request</button>
                    <button class="btn btn-reject" onclick="rejectRequest(<?php echo $request['id']; ?>)" <?php echo $request['payment_status'] !== 'completed' ? 'disabled' : ''; ?>>✕ Reject Request</button>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function approveRequest(id) {
            const button = event.target;
            if (button.disabled) {
                alert('Payment must be completed before approving');
                return;
            }
            if (confirm('Are you sure you want to approve this request?')) {
                fetch(`/admin/approve/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert(data.message);
                        window.location.href = '/admin/dashboard';
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred');
                });
            }
        }

        function rejectRequest(id) {
            const button = event.target;
            if (button.disabled) {
                alert('Payment must be completed before rejecting');
                return;
            }
            const reason = prompt('Enter reason for rejection:');
            if (reason !== null) {
                fetch(`/admin/reject/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ reason: reason })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert(data.message);
                        window.location.href = '/admin/dashboard';
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred');
                });
            }
        }
    </script>
</body>
</html>
