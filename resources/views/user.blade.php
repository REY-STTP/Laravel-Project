<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>User Dashboard - {{ config('app.name', 'Laravel') }}</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
    --sidebar-width: 280px;
    --primary-color: #6366f1;
    --primary-dark: #4f46e5;
    --secondary-color: #8b5cf6;
    --sidebar-bg: #1e293b;
    --sidebar-text: #cbd5e1;
    --sidebar-hover: #334155;
    --bg-main: #f8fafc;
    --text-primary: #0f172a;
    --text-secondary: #64748b;
    --card-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.1);
    --card-shadow-hover: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: var(--bg-main);
    overflow-x: hidden;
}

/* Sidebar */
.sidebar {
    position: fixed;
    left: 0;
    top: 0;
    width: var(--sidebar-width);
    height: 100vh;
    background: var(--sidebar-bg);
    z-index: 1000;
    transition: all 0.3s ease;
    overflow-y: auto;
}

.sidebar::-webkit-scrollbar {
    width: 6px;
}

.sidebar::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.05);
}

.sidebar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 3px;
}

.sidebar.collapsed {
    left: calc(-1 * var(--sidebar-width));
}

.sidebar-brand {
    padding: 25px 20px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
}

.sidebar-brand h4 {
    color: white;
    font-weight: 700;
    margin: 0;
    font-size: 20px;
    letter-spacing: -0.5px;
}

.sidebar-brand i {
    margin-right: 10px;
    font-size: 24px;
}

.sidebar-menu {
    list-style: none;
    padding: 20px 15px;
}

.sidebar-menu li {
    margin: 8px 0;
}

.sidebar-menu a {
    display: flex;
    align-items: center;
    padding: 14px 18px;
    color: var(--sidebar-text);
    text-decoration: none;
    transition: all 0.3s ease;
    border-radius: 10px;
    font-size: 15px;
    font-weight: 500;
}

.sidebar-menu a:hover {
    background: var(--sidebar-hover);
    color: white;
    transform: translateX(5px);
}

.sidebar-menu a.active {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
}

.sidebar-menu i {
    margin-right: 15px;
    width: 22px;
    text-align: center;
    font-size: 18px;
}

/* Main Content */
.main-content {
    margin-left: var(--sidebar-width);
    transition: all 0.3s ease;
    min-height: 100vh;
}

.main-content.expanded {
    margin-left: 0;
}

/* Navbar */
.navbar-custom {
    background: white;
    box-shadow: var(--card-shadow);
    padding: 18px 35px;
    border-radius: 0;
    backdrop-filter: blur(10px);
    background: rgba(255, 255, 255, 0.95);
    position: relative;
    z-index: 999;
}

.navbar-toggler {
    border: none;
    font-size: 24px;
    color: var(--text-primary);
    cursor: pointer;
    background: var(--bg-main);
    width: 45px;
    height: 45px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.navbar-toggler:hover {
    background: var(--primary-color);
    color: white;
    transform: rotate(90deg);
}

.navbar-user {
    display: flex;
    align-items: center;
    gap: 15px;
}

.user-avatar {
    width: 45px;
    height: 45px;
    border-radius: 12px;
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 16px;
    box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
}

.user-dropdown {
    position: relative;
    z-index: 1050;
}

.user-dropdown-toggle {
    display: flex;
    align-items: center;
    gap: 12px;
    cursor: pointer;
    padding: 8px 15px;
    border-radius: 12px;
    transition: all 0.3s ease;
    background: none;
    border: none;
}

.user-dropdown-toggle:hover {
    background: var(--bg-main);
}

.user-dropdown-menu {
    position: absolute;
    top: 100%;
    right: 0;
    margin-top: 15px;
    background: white;
    border-radius: 16px;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
    min-width: 240px;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.3s ease;
    z-index: 1100;
    border: 1px solid rgba(0, 0, 0, 0.05);
    pointer-events: none;
    display: none;
}

.user-dropdown-menu.show {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
    pointer-events: auto;
    display: block;
}

.user-dropdown-header {
    padding: 20px;
    border-bottom: 1px solid var(--bg-main);
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.05) 0%, rgba(139, 92, 246, 0.05) 100%);
    border-radius: 16px 16px 0 0;
}

.user-dropdown-name {
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 5px;
    font-size: 16px;
}

.user-dropdown-email {
    font-size: 13px;
    color: var(--text-secondary);
}

.user-dropdown-body {
    padding: 10px;
}

.user-dropdown-item {
    display: flex;
    align-items: center;
    padding: 12px 15px;
    color: var(--text-primary);
    text-decoration: none;
    transition: all 0.3s ease;
    width: 100%;
    text-align: left;
    background: none;
    border: none;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 500;
}

.user-dropdown-item:hover {
    background: var(--bg-main);
    color: var(--primary-color);
    transform: translateX(5px);
}

.user-dropdown-item i {
    margin-right: 12px;
    width: 20px;
    font-size: 16px;
}

.user-dropdown-divider {
    height: 1px;
    background: var(--bg-main);
    margin: 10px 15px;
}

/* Dashboard Content */
.dashboard-content {
    padding: 35px;
}

.page-title {
    font-size: 32px;
    font-weight: 800;
    color: var(--text-primary);
    margin-bottom: 8px;
    letter-spacing: -0.5px;
}

.welcome-text {
    color: var(--text-secondary);
    margin-bottom: 30px;
    font-size: 16px;
}

/* Profile Card */
.profile-card {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    border-radius: 20px;
    padding: 35px;
    color: white;
    margin-bottom: 30px;
    box-shadow: 0 20px 50px rgba(99, 102, 241, 0.25);
    position: relative;
    overflow: hidden;
}

.profile-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    animation: pulse 8s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); opacity: 0.5; }
    50% { transform: scale(1.1); opacity: 0.8; }
}

.profile-card-content {
    display: flex;
    align-items: center;
    gap: 25px;
    position: relative;
    z-index: 1;
}

.profile-avatar {
    width: 90px;
    height: 90px;
    border-radius: 20px;
    background: rgba(255, 255, 255, 0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 36px;
    font-weight: 800;
    border: 3px solid rgba(255, 255, 255, 0.3);
    backdrop-filter: blur(10px);
}

.profile-info h3 {
    margin: 0 0 8px 0;
    font-size: 28px;
    font-weight: 800;
}

.profile-info p {
    margin: 5px 0;
    opacity: 0.95;
    font-size: 15px;
}

/* Stats Cards */
.stats-card {
    background: white;
    border-radius: 16px;
    padding: 28px;
    box-shadow: var(--card-shadow);
    margin-bottom: 25px;
    transition: all 0.4s ease;
    border: 1px solid rgba(0, 0, 0, 0.05);
    position: relative;
    overflow: hidden;
}

.stats-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    transform: scaleX(0);
    transition: transform 0.4s ease;
}

.stats-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--card-shadow-hover);
}

.stats-card:hover::before {
    transform: scaleX(1);
}

.stats-card-icon {
    width: 65px;
    height: 65px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    color: white;
    margin-bottom: 18px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

.stats-card-icon.bg-primary { 
    background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
}
.stats-card-icon.bg-success { 
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
}
.stats-card-icon.bg-warning { 
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
}
.stats-card-icon.bg-danger { 
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
}

.stats-card-title {
    color: var(--text-secondary);
    font-size: 14px;
    margin-bottom: 8px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.stats-card-value {
    font-size: 32px;
    font-weight: 800;
    color: var(--text-primary);
    letter-spacing: -1px;
}

/* Activity Card */
.activity-card {
    background: white;
    border-radius: 16px;
    padding: 28px;
    box-shadow: var(--card-shadow);
    margin-bottom: 25px;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.activity-card-header {
    margin-bottom: 25px;
    padding-bottom: 18px;
    border-bottom: 2px solid var(--bg-main);
}

.activity-card-title {
    font-size: 20px;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0;
}

.activity-item {
    display: flex;
    align-items: flex-start;
    gap: 18px;
    padding: 18px 0;
    border-bottom: 1px solid var(--bg-main);
    transition: all 0.3s ease;
}

.activity-item:last-child {
    border-bottom: none;
}

.activity-item:hover {
    transform: translateX(5px);
}

.activity-icon {
    width: 45px;
    height: 45px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    flex-shrink: 0;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
}

.activity-content h6 {
    margin: 0 0 6px 0;
    font-size: 15px;
    font-weight: 700;
    color: var(--text-primary);
}

.activity-content p {
    margin: 0;
    font-size: 14px;
    color: var(--text-secondary);
    line-height: 1.6;
}

.activity-time {
    font-size: 12px;
    color: var(--text-secondary);
    margin-top: 6px;
    font-weight: 500;
}

/* Quick Actions */
.quick-actions {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.quick-action-btn {
    background: white;
    border-radius: 16px;
    padding: 25px;
    text-align: center;
    text-decoration: none;
    color: var(--text-primary);
    box-shadow: var(--card-shadow);
    transition: all 0.4s ease;
    border: 1px solid rgba(0, 0, 0, 0.05);
    position: relative;
    overflow: hidden;
}

.quick-action-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(99, 102, 241, 0.1), transparent);
    transition: left 0.5s ease;
}

.quick-action-btn:hover::before {
    left: 100%;
}

.quick-action-btn:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: var(--card-shadow-hover);
    border-color: var(--primary-color);
}

.quick-action-btn i {
    font-size: 36px;
    margin-bottom: 12px;
    display: block;
    transition: all 0.3s ease;
}

.quick-action-btn:hover i {
    transform: scale(1.1) rotate(5deg);
}

.quick-action-btn span {
    font-size: 15px;
    font-weight: 600;
}

/* Table */
.table-card {
    background: white;
    border-radius: 16px;
    padding: 28px;
    box-shadow: var(--card-shadow);
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.table-card-header {
    margin-bottom: 20px;
}

.table {
    margin-bottom: 0;
}

.table thead th {
    border-bottom: 2px solid var(--bg-main);
    font-weight: 700;
    color: var(--text-primary);
    text-transform: uppercase;
    font-size: 12px;
    letter-spacing: 0.5px;
    padding: 15px 12px;
}

.table tbody td {
    padding: 15px 12px;
    vertical-align: middle;
    color: var(--text-primary);
    font-weight: 500;
}

.badge-success {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    color: #065f46;
    padding: 8px 14px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 12px;
    display: inline-block;
}

.badge-warning {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    color: #92400e;
    padding: 8px 14px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 12px;
    display: inline-block;
}

.badge-primary {
    background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
    color: #3730a3;
    padding: 8px 14px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 12px;
    display: inline-block;
}

/* Responsive */
@media (max-width: 768px) {
    .sidebar {
        left: calc(-1 * var(--sidebar-width));
    }
    
    .sidebar.show {
        left: 0;
    }
    
    .main-content {
        margin-left: 0;
    }
    
    .dashboard-content {
        padding: 20px;
    }
    
    .profile-card-content {
        flex-direction: column;
        text-align: center;
    }
    
    .quick-actions {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .page-title {
        font-size: 26px;
    }
    
    .stats-card-value {
        font-size: 28px;
    }
}
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <h4><i class="fas fa-cube"></i> {{ config('app.name', 'MyApp') }}</h4>
        </div>
        <ul class="sidebar-menu">
            <li><a href="#" class="active"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="#"><i class="fas fa-user"></i> My Profile</a></li>
            <li><a href="#"><i class="fas fa-shopping-bag"></i> My Orders</a></li>
            <li><a href="#"><i class="fas fa-heart"></i> Wishlist</a></li>
            <li><a href="#"><i class="fas fa-bell"></i> Notifications</a></li>
            <li><a href="#"><i class="fas fa-cog"></i> Settings</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Navbar -->
        <nav class="navbar-custom">
            <div class="d-flex justify-content-between align-items-center w-100">
                <button class="navbar-toggler" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="navbar-user">
                    <div class="user-dropdown">
                        <button class="user-dropdown-toggle" id="userDropdownToggle">
                            <span class="text-muted d-none d-md-inline">{{ Auth::user()->name }}</span>
                            <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
                        </button>
                        <div class="user-dropdown-menu" id="userDropdownMenu">
                            <div class="user-dropdown-header">
                                <div class="user-dropdown-name">{{ Auth::user()->name }}</div>
                                <div class="user-dropdown-email">{{ Auth::user()->email }}</div>
                            </div>
                            <div class="user-dropdown-body">
                                <a href="#" class="user-dropdown-item">
                                    <i class="fas fa-user"></i> My Profile
                                </a>
                                <a href="#" class="user-dropdown-item">
                                    <i class="fas fa-cog"></i> Settings
                                </a>
                                <div class="user-dropdown-divider"></div>
                                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                                    @csrf
                                    <button type="submit" class="user-dropdown-item">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Dashboard Content -->
        <div class="dashboard-content">
            <h1 class="page-title">Dashboard</h1>
            <p class="welcome-text">Welcome back, {{ Auth::user()->name }}! Here's what's happening with your account today.</p>

            <!-- Profile Card -->
            <div class="profile-card">
                <div class="profile-card-content">
                    <div class="profile-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
                    <div class="profile-info">
                        <h3>{{ Auth::user()->name }}</h3>
                        <p><i class="fas fa-envelope me-2"></i>{{ Auth::user()->email }}</p>
                        <p><i class="fas fa-calendar me-2"></i>Member since {{ Auth::user()->created_at->format('F Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions">
                <a href="#" class="quick-action-btn">
                    <i class="fas fa-shopping-cart" style="color: #6777ef;"></i>
                    <span>New Order</span>
                </a>
                <a href="#" class="quick-action-btn">
                    <i class="fas fa-box" style="color: #47c363;"></i>
                    <span>Track Order</span>
                </a>
                <a href="#" class="quick-action-btn">
                    <i class="fas fa-history" style="color: #ffa426;"></i>
                    <span>Order History</span>
                </a>
                <a href="#" class="quick-action-btn">
                    <i class="fas fa-headset" style="color: #fc544b;"></i>
                    <span>Support</span>
                </a>
            </div>

            <!-- Stats Cards -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="stats-card">
                        <div class="stats-card-icon bg-primary">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <div class="stats-card-title">Total Orders</div>
                        <div class="stats-card-value">30</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stats-card">
                        <div class="stats-card-icon bg-success">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stats-card-title">Completed</div>
                        <div class="stats-card-value">22</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stats-card">
                        <div class="stats-card-icon bg-warning">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stats-card-title">Pending</div>
                        <div class="stats-card-value">6</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stats-card">
                        <div class="stats-card-icon bg-danger">
                            <i class="fas fa-heart"></i>
                        </div>
                        <div class="stats-card-title">Wishlist</div>
                        <div class="stats-card-value">18</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Recent Activity -->
                <div class="col-lg-6">
                    <div class="activity-card">
                        <div class="activity-card-header">
                            <h5 class="activity-card-title">Recent Activity</h5>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon" style="background: #47c363;">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="activity-content">
                                <h6>Order Delivered</h6>
                                <p>Your order #1231 has been delivered successfully</p>
                                <div class="activity-time">30 minutes ago</div>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon" style="background: #6777ef;">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <div class="activity-content">
                                <h6>New Order Placed</h6>
                                <p>Order #1232 has been placed and is being processed</p>
                                <div class="activity-time">1 hours ago</div>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon" style="background: #ffa426;">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="activity-content">
                                <h6>Review Submitted</h6>
                                <p>Thank you for reviewing your recent purchase</p>
                                <div class="activity-time">7 day ago</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="col-lg-6">
                    <div class="table-card">
                        <div class="table-card-header">
                            <h5 class="activity-card-title">Recent Orders</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>#1233</td>
                                        <td>Nov 27, 2025</td>
                                        <td><span class="badge-primary">Processing</span></td>
                                        <td>$65.00</td>
                                    </tr>
                                    <tr>
                                        <td>#1232</td>
                                        <td>Nov 26, 2025</td>
                                        <td><span class="badge-success">Delivered</span></td>
                                        <td>$79.25</td>
                                    </tr>
                                    <tr>
                                        <td>#1231</td>
                                        <td>Nov 25, 2025</td>
                                        <td><span class="badge-warning">Pending</span></td>
                                        <td>$35.00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Sidebar Toggle
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        
        sidebarToggle.addEventListener('click', function() {
            if (window.innerWidth > 768) {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
            } else {
                sidebar.classList.toggle('show');
            }
        });

        // User Dropdown Toggle
        const userDropdownToggle = document.getElementById('userDropdownToggle');
        const userDropdownMenu = document.getElementById('userDropdownMenu');
        
        userDropdownToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            userDropdownMenu.classList.toggle('show');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!userDropdownToggle.contains(e.target) && !userDropdownMenu.contains(e.target)) {
                userDropdownMenu.classList.remove('show');
            }
        });

        // Close sidebar on mobile when clicking outside
        document.addEventListener('click', function(e) {
            if (window.innerWidth <= 768) {
                if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                    sidebar.classList.remove('show');
                }
            }
        });
    </script>
</body>
</html>