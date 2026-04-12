<!DOCTYPE html>
<html>
<head>
    <title>District Admin Panel</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #f4f6f9;
        }

        /* ===== LAYOUT ===== */
        .wrapper {
            display: flex;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 250px;
            background: #1e3c72;
            color: #fff;
            min-height: 100vh;
            padding: 20px;
        }

        .sidebar img {
            width: 110px;
            display: block;
            margin: 0 auto 10px;
        }

        .sidebar h3 {
            text-align: center;
            font-size: 1rem;
            margin-bottom: 25px;
        }

        .menu-section {
            margin-bottom: 15px;
        }

        .menu-title {
            font-size: 12px;
            opacity: 0.7;
            margin: 10px 0 5px;
            text-transform: uppercase;
        }

        .sidebar a {
            display: block;
            padding: 10px;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            margin-bottom: 6px;
            transition: 0.3s;
            font-size: 14px;
        }

        .sidebar a:hover {
            background: #4CAF50;
        }

        .sidebar a.active {
            background: #4CAF50;
        }

        /* ===== MAIN ===== */
        .main {
            flex: 1;
            padding: 25px;
        }

        /* ===== HEADER ===== */
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .logout-btn {
            background: #FFD700;
            padding: 8px 15px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            color: #000;
        }

        .logout-btn:hover {
            background: #4CAF50;
            color: #fff;
        }

        /* badge (future notifications) */
        .badge {
            background: red;
            color: #fff;
            font-size: 11px;
            padding: 2px 6px;
            border-radius: 50%;
            float: right;
        }

    </style>
</head>

<body>

<div class="wrapper">

    <!-- ===== SIDEBAR ===== -->
    <div class="sidebar">

        <img src="{{ asset('images/pagk_logo.png') }}" alt="Logo">

        <h3>District Panel</h3>

        <!-- MAIN -->
        <div class="menu-section">
            <div class="menu-title">Main</div>
            <a href="{{ route('district.admin.dashboard') }}">Dashboard</a>
        </div>

        <!-- CHURCH STRUCTURE -->
        <div class="menu-section">
            <div class="menu-title">Church Structure</div>
            <a href="#">Assemblies</a>
            <a href="#">Members</a>
            <a href="#">Pastoral Team</a>
        </div>

        <!-- FINANCE -->
        <div class="menu-section">
            <div class="menu-title">Finance</div>
            <a href="#">Tithe Reports</a>
        </div>

        <!-- TRANSFERS -->
        <div class="menu-section">
            <div class="menu-title">Transfers</div>

            <a href="{{ route('district.admin.pastoral.transfers.incoming') }}"
               class="{{ request()->routeIs('district.admin.pastoral.transfers.*') ? 'active' : '' }}">
                Pastoral Transfers
                <span class="badge">!</span>
            </a>
        </div>

        <!-- AUTH -->
        <div class="menu-section">
            <div class="menu-title">Account</div>
            <a href="{{ route('district.admin.logout') }}">Logout</a>
        </div>

    </div>

    <!-- ===== MAIN CONTENT ===== -->
    <div class="main">

        <div class="topbar">
            <h2>District Admin Dashboard</h2>

            <a href="{{ route('district.admin.logout') }}" class="logout-btn">
                Logout
            </a>
        </div>

        @yield('content')

    </div>

</div>

</body>
</html>