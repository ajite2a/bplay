<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Song Requests</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
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
            max-width: 1200px;
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

        .header-content {
            text-align: center;
            flex: 1;
        }

        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }

        .user-menu {
            position: relative;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5em;
        }

        .user-info {
            text-align: right;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .user-info p {
            margin: 0;
            font-size: 0.85em;
            opacity: 0.9;
        }

        .user-name {
            font-weight: 600;
        }

        .user-dropdown {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border-radius: 8px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            min-width: 200px;
            z-index: 1000;
            margin-top: 10px;
        }

        .user-dropdown.show {
            display: block;
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dropdown-item {
            padding: 12px 20px;
            color: #333;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: 0.3s;
            border-bottom: 1px solid #eee;
        }

        .dropdown-item:last-child {
            border-bottom: none;
        }

        .dropdown-item:hover {
            background: #f5f5f5;
            color: #667eea;
        }

        .dropdown-item i {
            width: 20px;
            text-align: center;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            padding: 30px;
            background: #f8f9fa;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-left: 4px solid #667eea;
        }

        .stat-card h3 {
            color: #666;
            font-size: 0.9em;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .stat-card .number {
            font-size: 2.5em;
            color: #667eea;
            font-weight: bold;
        }

        .controls {
            padding: 20px 30px;
            background: #f8f9fa;
            display: flex;
            gap: 15px;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .filter-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 10px 20px;
            border: 2px solid #ddd;
            background: white;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 500;
        }

        .filter-btn:hover {
            border-color: #667eea;
            color: #667eea;
        }

        .filter-btn.active {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .date-filter {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .date-filter label {
            font-weight: 600;
            color: #333;
        }

        .date-filter input {
            padding: 10px 15px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
        }

        .date-filter input:focus {
            outline: none;
            border-color: #667eea;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: #667eea;
            color: white;
        }

        .btn-primary:hover {
            background: #5568d3;
        }

        .btn-export {
            background: #10b981;
            color: white;
        }

        .btn-export:hover {
            background: #059669;
        }

        .table-wrapper {
            overflow-x: auto;
            padding: 20px 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #f3f4f6;
            border-bottom: 2px solid #e5e7eb;
        }

        th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #374151;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #e5e7eb;
        }

        tbody tr:hover {
            background: #f9fafb;
        }

        .status-badge {
            display: inline-block;
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.9em;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-pending {
            background: #ffc107;
            color: #000;
        }

        .status-approved {
            background: #28a745;
            color: #fff;
        }

        .status-rejected {
            background: #dc3545;
            color: #fff;
        }

        .payment-pending {
            background: #17a2b8;
            color: #fff;
        }

        .payment-completed {
            background: #20c997;
            color: #134e4a;
        }

        .action-cell {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .btn-small {
            padding: 6px 12px;
            font-size: 0.85em;
            border: none;
            border-radius: 4px;
            cursor: pointer;
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

        .btn-view {
            background: #3b82f6;
            color: white;
        }

        .btn-view:hover {
            background: #2563eb;
        }

        .text-muted {
            color: #999;
            font-weight: 500;
        }

        .screenshot-link {
            display: inline-block;
            border-radius: 4px;
            overflow: hidden;
        }

        .screenshot-link img {
            transition: transform 0.3s ease;
            display: block;
        }

        .screenshot-link:hover img {
            transform: scale(1.1);
        }

        .empty-state {
            text-align: center;
            padding: 60px 30px;
            color: #999;
        }

        .empty-state svg {
            width: 100px;
            height: 100px;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
        }

        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 8px;
            max-width: 400px;
            width: 90%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .modal-header {
            font-size: 1.5em;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: 500;
        }

        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: inherit;
            resize: vertical;
            min-height: 80px;
        }

        .modal-footer {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .btn-cancel {
            background: #ccc;
            color: #333;
        }

        .btn-cancel:hover {
            background: #bbb;
        }

        .alert {
            padding: 15px 30px;
            margin: 0;
            border-radius: 0;
            border: none;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border-bottom: 2px solid #28a745;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border-bottom: 2px solid #dc3545;
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 20px;
            }

            .header h1 {
                font-size: 1.8em;
            }

            .user-menu {
                width: 100%;
            }

            .user-dropdown {
                right: auto;
                left: 0;
                min-width: 180px;
            }

            .stats {
                grid-template-columns: 1fr;
            }

            .controls {
                flex-direction: column;
                align-items: flex-start;
            }

            .filter-buttons {
                width: 100%;
                justify-content: space-between;
            }

            .date-filter {
                width: 100%;
                flex-direction: column;
            }

            .date-filter input {
                width: 100%;
            }

            table {
                font-size: 0.9em;
            }

            th, td {
                padding: 10px;
            }

            .action-cell {
                flex-direction: column;
            }

            .btn-small {
                width: 100%;
            }

            .screenshot-link img {
                max-width: 40px !important;
                max-height: 40px !important;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="header-content">
                <h1>🎵 Admin Dashboard</h1>
                <p>Manage Song Requests</p>
            </div>
            
            <!-- User Menu -->
            <div class="user-menu" onclick="toggleUserMenu()">
                <div class="user-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="user-info">
                    <p class="user-name"><?= esc(session()->get('name') ?? 'Admin'); ?></p>
                    <p><?= esc(session()->get('role') ?? 'Administrator'); ?></p>
                </div>
                <i class="fas fa-chevron-down"></i>

                <!-- Dropdown Menu -->
                <div class="user-dropdown" id="userDropdown">
                    <a href="/admin/dashboard" class="dropdown-item">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-cog"></i>
                        <span>Settings</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-user-circle"></i>
                        <span>Profile</span>
                    </a>
                    <a href="/logout" class="dropdown-item" style="border-top: 1px solid #eee; color: #ef4444;">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="stats">
            <div class="stat-card">
                <h3>Total Requests</h3>
                <div class="number"><?= $totalRequests ?? 0; ?></div>
            </div>
            <div class="stat-card">
                <h3>Pending</h3>
                <div class="number" style="color: #f59e0b;"><?= $pendingCount ?? 0; ?></div>
            </div>
            <div class="stat-card">
                <h3>Approved</h3>
                <div class="number" style="color: #10b981;"><?= $approvedCount ?? 0; ?></div>
            </div>
            <div class="stat-card">
                <h3>Paid</h3>
                <div class="number" style="color: #8b5cf6;"><?= $paidCount ?? 0; ?></div>
            </div>
        </div>

        <!-- Controls -->
        <div class="controls">
            <div class="filter-buttons">
                <a href="?filter=all&date=<?= $dateFilter; ?>" class="filter-btn <?= $filter === 'all' ? 'active' : ''; ?>">All</a>
                <a href="?filter=pending&date=<?= $dateFilter; ?>" class="filter-btn <?= $filter === 'pending' ? 'active' : ''; ?>">Pending</a>
                <a href="?filter=approved&date=<?= $dateFilter; ?>" class="filter-btn <?= $filter === 'approved' ? 'active' : ''; ?>">Approved</a>
                <a href="?filter=paid&date=<?= $dateFilter; ?>" class="filter-btn <?= $filter === 'paid' ? 'active' : ''; ?>">Paid</a>
                <a href="?filter=rejected&date=<?= $dateFilter; ?>" class="filter-btn <?= $filter === 'rejected' ? 'active' : ''; ?>">Rejected</a>
            </div>
            <div class="date-filter">
                <label for="dateInput">📅 Date:</label>
                <input type="date" id="dateInput" name="date" value="<?= $dateFilter; ?>" onchange="filterByDate()">
            </div>
            <div class="action-buttons">
                <a href="/admin/export-csv" class="btn btn-export">📥 Export CSV</a>
            </div>
        </div>

        <!-- Table -->
        <div class="table-wrapper">
            <?php if (empty($requests)): ?>
                <div class="empty-state">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M8 12l2 2 4-4"></path>
                    </svg>
                    <h3>No requests found</h3>
                    <p>There are no song requests matching the selected filter.</p>
                </div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Song</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th>Screenshot</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($requests as $req): ?>
                            <tr>
                                <td><?= $req['id']; ?></td>
                                <td>
                                    <div style="line-height: 1.6;">
                                        <strong style="color: #27ae60; display: block;">👤 <?= esc($req['name']); ?></strong>
                                        <span style="color: #3498db; font-size: 0.9em; display: block;">📱 <?= esc($req['phone']); ?></span>
                                    </div>
                                </td>
                                <td>
                                    <div style="line-height: 1.6;">
                                        <strong style="color: #667eea; display: block;">🎵 <?= esc($req['song_name']); ?></strong>
                                        <span style="color: #e67e22; font-size: 0.9em; display: block;">👤 <?= esc($req['singer_name'] ?? '-'); ?></span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-<?= $req['status'] === 'pending' ? 'warning' : ($req['status'] === 'approved' ? 'success' : 'danger'); ?>">
                                        <?= ucfirst($req['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-<?= $req['payment_status'] === 'completed' ? 'success' : 'info'; ?>">
                                        <?= ucfirst($req['payment_status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($req['screenshot']): ?>
                                        <a href="<?= base_url(esc($req['screenshot'])); ?>" target="_blank" class="screenshot-link">
                                            <img src="<?= base_url(esc($req['screenshot'])); ?>" alt="Screenshot" style="max-width: 50px; max-height: 50px; border-radius: 4px; cursor: pointer; object-fit: cover;">
                                        </a>
                                    <?php else: ?>
                                        <span style="color: #999; font-size: 0.9em;">N/A</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= date('M d, Y H:i', strtotime($req['created_at'])); ?></td>
                                <td>
                                    <div class="action-cell">
                                        <a href="/admin/view/<?= $req['id']; ?>" class="btn-small btn-view">View</a>
                                        <?php if ($req['status'] === 'pending' && $req['payment_status'] === 'completed'): ?>
                                            <button class="btn-small btn-approve" onclick="openApproveModal(<?= $req['id']; ?>)">Approve</button>
                                            <button class="btn-small btn-reject" onclick="openRejectModal(<?= $req['id']; ?>)">Reject</button>
                                        <?php elseif ($req['status'] === 'pending'): ?>
                                            <span class="text-muted" style="font-size: 0.85em; display: inline-block; padding: 5px 10px;">Awaiting Payment</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

    <!-- Approve Modal -->
    <div class="modal" id="approveModal">
        <div class="modal-content">
            <div class="modal-header">Approve Request</div>
            <p>Are you sure you want to approve this request?</p>
            <div class="modal-footer">
                <button type="button" class="btn btn-cancel" onclick="closeApproveModal()">Cancel</button>
                <button type="button" class="btn btn-approve" onclick="confirmApprove()">Approve</button>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div class="modal" id="rejectModal">
        <div class="modal-content">
            <div class="modal-header">Reject Request</div>
            <form id="rejectForm">
                <div class="form-group">
                    <label for="reason">Reason for Rejection</label>
                    <textarea id="reason" name="reason" placeholder="Enter reason..." required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-cancel" onclick="closeRejectModal()">Cancel</button>
                    <button type="submit" class="btn btn-reject">Reject Request</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let currentRejectId = null;
        let currentApproveId = null;

        function filterByDate() {
            const dateInput = document.getElementById('dateInput').value;
            const currentFilter = '<?= $filter; ?>';
            window.location.href = `?filter=${currentFilter}&date=${dateInput}`;
        }

        function openRejectModal(id) {
            currentRejectId = id;
            document.getElementById('rejectModal').classList.add('show');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.remove('show');
            document.getElementById('rejectForm').reset();
            currentRejectId = null;
        }

        function openApproveModal(id) {
            currentApproveId = id;
            document.getElementById('approveModal').classList.add('show');
        }

        function closeApproveModal() {
            document.getElementById('approveModal').classList.remove('show');
            currentApproveId = null;
        }

        function confirmApprove() {
            if (currentApproveId) {
                fetch(`/admin/approve/${currentApproveId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        showAlert(data.message, 'success');
                        closeApproveModal();
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        showAlert(data.message, 'error');
                    }
                })
                .catch(error => {
                    showAlert('An error occurred', 'error');
                    console.error('Error:', error);
                });
            }
        }

        document.getElementById('rejectForm').addEventListener('submit', function(e) {
            e.preventDefault();
            rejectRequest(currentRejectId);
        });

        function approveRequest(id) {
            openApproveModal(id);
        }

        function rejectRequest(id) {
            const reason = document.getElementById('reason').value;

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
                    showAlert(data.message, 'success');
                    closeRejectModal();
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showAlert(data.message, 'error');
                }
            })
            .catch(error => {
                showAlert('An error occurred', 'error');
                console.error('Error:', error);
            });
        }

        function showAlert(message, type) {
            const alert = document.createElement('div');
            alert.className = `alert alert-${type}`;
            alert.textContent = message;
            document.querySelector('.container').insertBefore(alert, document.querySelector('.header'));
            
            setTimeout(() => alert.remove(), 4000);
        }

        // Toggle user menu dropdown
        function toggleUserMenu() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('show');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const userMenu = document.querySelector('.user-menu');
            const dropdown = document.getElementById('userDropdown');
            
            if (!userMenu.contains(event.target)) {
                dropdown.classList.remove('show');
            }
        });

        // Close modal when clicking outside
        window.addEventListener('click', function(event) {
            const rejectModal = document.getElementById('rejectModal');
            const approveModal = document.getElementById('approveModal');
            
            if (event.target === rejectModal) {
                closeRejectModal();
            }
            if (event.target === approveModal) {
                closeApproveModal();
            }
        });
    </script>
    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
