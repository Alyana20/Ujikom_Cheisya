<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard Vendor - Toko Alert Kesehatan</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-color: #1a73e8;
            --primary-light: #6c8ef5;
            --secondary-color: #34a853;
            --warning-color: #fbbc05;
            --danger-color: #ea4335;
            --dark-color: #1f2937;
            --light-color: #f8fafc;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Figtree', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #333;
        }

        .dashboard-container {
            min-height: 100vh;
            padding: 20px;
        }

        .dashboard-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            overflow: hidden;
            max-width: 1200px;
            margin: 0 auto;
        }

        .dashboard-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            color: white;
            padding: 30px;
            position: relative;
        }

        .welcome-section {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            margin-bottom: 15px;
        }

        .logout-btn {
            position: absolute;
            top: 20px;
            right: 30px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .logout-btn i {
            font-size: 16px;
        }

        .user-avatar {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            border: 3px solid rgba(255, 255, 255, 0.3);
        }

        .welcome-text h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .welcome-text p {
            opacity: 0.9;
            font-size: 16px;
        }

        .vendor-badge {
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            display: inline-block;
            margin-top: 10px;
        }

        .dashboard-content {
            padding: 40px;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            display: flex;
            align-items: center;
            gap: 20px;
            transition: all 0.3s ease;
            border-left: 4px solid var(--primary-color);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .stat-card.products {
            border-left-color: var(--primary-color);
        }

        .stat-card.orders {
            border-left-color: var(--secondary-color);
        }

        .stat-card.sales {
            border-left-color: var(--warning-color);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
        }

        .stat-icon.products {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
        }

        .stat-icon.orders {
            background: linear-gradient(135deg, var(--secondary-color) 0%, #4caf50 100%);
        }

        .stat-icon.sales {
            background: linear-gradient(135deg, var(--warning-color) 0%, #ff9800 100%);
        }

        .stat-content h3 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 5px;
            color: var(--dark-color);
        }

        .stat-content p {
            color: #666;
            font-size: 14px;
            font-weight: 500;
        }

        /* Quick Actions */
        .quick-actions {
            margin-bottom: 40px;
        }

        .section-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title i {
            color: var(--primary-color);
        }

        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .action-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            text-decoration: none;
            color: inherit;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            text-align: center;
        }

        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            border-color: var(--primary-color);
            color: inherit;
        }

        .action-card.disabled {
            opacity: 0.6;
            cursor: not-allowed;
            position: relative;
            overflow: hidden;
        }

        .action-card.disabled:hover {
            transform: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            border-color: transparent;
        }

        .coming-soon {
            position: absolute;
            top: 10px;
            right: -30px;
            background: var(--warning-color);
            color: white;
            padding: 4px 30px;
            font-size: 12px;
            font-weight: 600;
            transform: rotate(45deg);
        }

        .action-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 28px;
            color: white;
        }

        .action-card.products .action-icon {
            background: linear-gradient(135deg, var(--secondary-color) 0%, #4caf50 100%);
        }

        .action-card.orders .action-icon {
            background: linear-gradient(135deg, #9c27b0 0%, #e91e63 100%);
        }

        .action-card.settings .action-icon {
            background: linear-gradient(135deg, #ff9800 0%, #ff5722 100%);
        }

        .action-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 10px;
            color: var(--dark-color);
        }

        .action-description {
            color: #666;
            font-size: 14px;
            line-height: 1.5;
        }

        /* Recent Activity */
        .recent-activity {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .activity-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .activity-item {
            display: flex;
            align-items: center;
            padding: 15px;
            background: #f8fafc;
            border-radius: 10px;
            transition: all 0.3s;
        }

        .activity-item:hover {
            background: #eef2f7;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 16px;
            color: white;
        }

        .activity-icon.store {
            background: var(--primary-color);
        }

        .activity-icon.product {
            background: var(--secondary-color);
        }

        .activity-icon.order {
            background: #9c27b0;
        }

        .activity-icon.user {
            background: var(--warning-color);
        }

        .activity-content {
            flex: 1;
        }

        .activity-text {
            font-size: 14px;
            margin-bottom: 5px;
            color: var(--dark-color);
        }

        .activity-time {
            font-size: 12px;
            color: #666;
        }

        /* Floating Shapes */
        .floating-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }

        .shape {
            position: absolute;
            opacity: 0.1;
            border-radius: 50%;
            background: white;
        }

        .shape-1 {
            width: 150px;
            height: 150px;
            top: 10%;
            left: 5%;
            animation: float 25s infinite linear;
        }

        .shape-2 {
            width: 100px;
            height: 100px;
            top: 60%;
            right: 10%;
            animation: float 20s infinite linear reverse;
        }

        @keyframes float {
            0% {
                transform: translate(0, 0) rotate(0deg);
            }

            100% {
                transform: translate(100px, 50px) rotate(360deg);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .dashboard-content {
                padding: 25px;
            }

            .welcome-section {
                flex-direction: column;
                text-align: center;
            }

            .logout-btn {
                position: static;
                margin: 15px auto 0;
                width: fit-content;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .actions-grid {
                grid-template-columns: 1fr;
            }

            .stat-card {
                padding: 20px;
            }

            .action-card {
                padding: 25px;
            }
        }

        @media (max-width: 480px) {
            .dashboard-header {
                padding: 20px;
            }

            .dashboard-content {
                padding: 20px;
            }

            .user-avatar {
                width: 60px;
                height: 60px;
                font-size: 24px;
            }

            .welcome-text h1 {
                font-size: 24px;
            }

            .logout-btn {
                font-size: 12px;
                padding: 8px 16px;
            }
        }
    </style>
</head>

<body>
    <div class="floating-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
    </div>

    <div class="dashboard-container">
        <div class="dashboard-card">
            <!-- Header -->
            <div class="dashboard-header">
                <!-- Logout Button -->
                <form action="{{ route('vendor.logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-btn" onclick="return confirm('Apakah Anda yakin ingin logout?')">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </button>
                </form>

                <div class="welcome-section">
                    <div class="user-avatar">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div class="welcome-text">
                        <h1>Selamat datang, {{ Auth::user()->name }}!</h1>
                        <p>Kelola toko dan produk Anda dengan mudah</p>
                        <div class="vendor-badge">
                            <i class="fas fa-store"></i> Status: Aktif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="dashboard-content">
                <!-- Stats Grid -->
                <div class="stats-grid">
                    <div class="stat-card products">
                        <div class="stat-icon products">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="stat-content">
                            <h3>0</h3>
                            <p>Total Produk</p>
                        </div>
                    </div>
                    <div class="stat-card orders">
                        <div class="stat-icon orders">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="stat-content">
                            <h3>0</h3>
                            <p>Pesanan Masuk</p>
                        </div>
                    </div>
                    <div class="stat-card sales">
                        <div class="stat-icon sales">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="stat-content">
                            <h3>Rp 0</h3>
                            <p>Total Penjualan</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="quick-actions">
                    <h2 class="section-title">
                        <i class="fas fa-bolt"></i>
                        Aksi Cepat
                    </h2>
                    <div class="actions-grid">
                        <a href="{{ route('vendor.products.index') }}" class="action-card products">
                            <div class="action-icon">
                                <i class="fas fa-boxes"></i>
                            </div>
                            <div class="action-title">Kelola Produk</div>
                            <div class="action-description">
                                Tambah, edit, dan kelola katalog produk Anda
                            </div>
                        </a>

                        <a href="{{ route('vendor.orders.index') }}" class="action-card orders">
                            <div class="action-icon">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                            <div class="action-title">Lihat Pesanan</div>
                            <div class="action-description">
                                Kelola pesanan dan proses pengiriman produk
                            </div>
                        </a>

                        <a href="{{ route('vendor.profile.index') }}" class="action-card settings">
                            <div class="action-icon">
                                <i class="fas fa-user-circle"></i>
                            </div>
                            <div class="action-title">Profil Vendor</div>
                            <div class="action-description">
                                Kelola profil personal dan informasi toko Anda
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="recent-activity">
                    <h2 class="section-title">
                        <i class="fas fa-history"></i>
                        Aktivitas Terbaru
                    </h2>
                    <div class="activity-list">
                        <div class="activity-item">
                            <div class="activity-icon store">
                                <i class="fas fa-store"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-text">Akun vendor berhasil dibuat</div>
                                <div class="activity-time">Baru saja</div>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon product">
                                <i class="fas fa-box"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-text">Belum ada produk yang ditambahkan</div>
                                <div class="activity-time">-</div>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon order">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-text">Belum ada pesanan masuk</div>
                                <div class="activity-time">-</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Footer -->
                <div style="margin-top: 40px; padding: 20px; background: white; border-radius: 15px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08); text-align: center;">
                    <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                        <a href="{{ route('vendor.profile.index') }}" style="background: linear-gradient(135deg, #10b981 0%, #14b8a6 100%); color: white; padding: 12px 24px; border-radius: 10px; text-decoration: none; font-weight: 600; transition: all 0.3s;">
                            <i class="fas fa-user-circle"></i> Profil Vendor
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Simple animations and interactions
        document.addEventListener('DOMContentLoaded', function() {
            // Add hover effects
            const actionCards = document.querySelectorAll('.action-card:not(.disabled)');
            actionCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px)';
                });
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });

            // Add loading animation to stats
            const statNumbers = document.querySelectorAll('.stat-content h3');
            statNumbers.forEach(stat => {
                const target = parseInt(stat.textContent.replace(/[^0-9]/g, ''));
                if (target > 0) {
                    animateNumber(stat, 0, target, 2000);
                }
            });

            function animateNumber(element, start, end, duration) {
                let startTimestamp = null;
                const step = (timestamp) => {
                    if (!startTimestamp) startTimestamp = timestamp;
                    const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                    const value = Math.floor(progress * (end - start) + start);
                    element.textContent = formatNumber(value);
                    if (progress < 1) {
                        window.requestAnimationFrame(step);
                    }
                };
                window.requestAnimationFrame(step);
            }

            function formatNumber(num) {
                if (num >= 1000000) {
                    return 'Rp ' + (num / 1000000).toFixed(1) + 'JT';
                }
                if (num >= 1000) {
                    return (num / 1000).toFixed(0) + 'K';
                }
                return num.toString();
            }
        });
    </script>
</body>

</html>
