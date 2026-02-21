<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - PAG (K)</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            display: flex;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
        }

        /* ================= SIDEBAR ================= */

        .sidebar {
            width: 250px;
            background-color: #003366;
            color: white;
            min-height: 100vh;
            padding: 20px 15px;
            position: fixed;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 20px;
            letter-spacing: 1px;
        }

        .sidebar ul {
            list-style: none;
        }

        .sidebar ul li {
            margin-bottom: 15px;
        }

        .sidebar ul li a {
            color: #ffffff;
            text-decoration: none;
            display: block;
            padding: 10px;
            border-radius: 6px;
            transition: 0.3s ease;
        }

        .sidebar ul li a:hover {
            background-color: #00509e;
        }

        .sidebar .logout {
            margin-top: 40px;
            background-color: #c0392b;
            text-align: center;
        }

        .sidebar .logout:hover {
            background-color: #922b21;
        }

        /* Mobile menu button */
        .mobile-menu-btn {
            display: none;
            width: 100%;
            padding: 12px;
            background-color: #003366;
            color: #fff;
            font-size: 18px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-bottom: 15px;
        }

        /* ================= MAIN CONTENT ================= */

        .main-content {
            margin-left: 250px;
            padding: 30px;
            width: 100%;
        }

        /* ================= TOPBAR ================= */

        .topbar {
            background: white;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Logo + Title container */
        .topbar-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .admin-logo {
            height: 100px;
            width: auto;
        }

        .topbar h1 {
            font-size: 24px;
        }

        .topbar .user-info {
            font-size: 14px;
            color: #555;
        }

        /* ================= CARDS ================= */

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            transition: 0.3s ease;
        }

        .card:hover {
            transform: translateY(-3px);
        }

        .card h3 {
            margin-bottom: 10px;
            font-size: 18px;
            color: #003366;
        }

        .card p {
            font-size: 14px;
            color: #555;
            margin-bottom: 15px;
        }

        .card a {
            display: inline-block;
            padding: 8px 12px;
            background-color: #003366;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
        }

        .card a:hover {
            background-color: #00509e;
        }

        /* ================= RESPONSIVE ================= */

        @media(max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
                padding: 10px;
            }

            .sidebar h2 {
                margin-bottom: 10px;
            }

            .mobile-menu-btn {
                display: block;
            }

            .menu-links {
                display: none; /* Hidden by default */
                flex-direction: column;
                gap: 10px;
            }

            .menu-links li a {
                padding: 12px;
                background-color: #003366;
                display: block;
                border-radius: 6px;
                text-align: center;
            }

            .menu-links li a:hover {
                background-color: #00509e;
            }

            .main-content {
                margin-left: 0;
                padding: 15px;
            }

            .admin-logo {
                height: 80px;
            }
        }
    </style>
</head>
<body>

    <!-- ================= SIDEBAR ================= -->
    <div class="sidebar">
        <h2>System Admin</h2>

        <button class="mobile-menu-btn" onclick="toggleMobileMenu()">☰ Menu</button>

        <ul class="menu-links">
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li><a href="#">Church Profile</a></li>
            <li><a href="#">Leadership</a></li>
            <li><a href="#">Departments</a></li>
            <li><a href="#">News & Updates</a></li>
            <li><a href="#">Projects</a></li>
            <li><a href="#">Daily Devotions</a></li>
            <li><a href="#">Partners</a></li>
            <li><a href="#">Comments</a></li>
            <li><a href="#">Contact Messages</a></li>
            <li><a href="#">Donations</a></li>
            <li><a href="#">Live Streaming</a></li>

            <li>
                <a class="logout" href="{{ route('admin.logout') }}">🚪 Logout</a>
            </li>
        </ul>
    </div>

    <!-- ================= MAIN CONTENT ================= -->
    <div class="main-content">

        <div class="topbar">
            <!-- Logo + Title -->
            <div class="topbar-left">
                <img src="{{ asset('images/pagk_logo.png') }}" alt="PAG Kenya Logo" class="admin-logo">
                <h1>Admin Panel</h1>
            </div>

            <div class="user-info">
                Logged in as: <strong>{{ Auth::user()->name }}</strong>
            </div>
        </div>

        @yield('content')

    </div>

    <script>
        function toggleMobileMenu() {
            const menu = document.querySelector('.menu-links');
            if(menu.style.display === 'flex') {
                menu.style.display = 'none';
            } else {
                menu.style.display = 'flex';
            }
        }
    </script>

</body>
</html>