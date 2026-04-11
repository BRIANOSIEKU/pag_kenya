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
            width: 240px;
            background: #1e3c72;
            color: #fff;
            min-height: 100vh;
            padding: 20px;
        }

        .sidebar img {
            width: 120px;
            display: block;
            margin: 0 auto 10px;
        }

        .sidebar h3 {
            text-align: center;
            font-size: 1rem;
            margin-bottom: 30px;
        }

        .sidebar a {
            display: block;
            padding: 10px;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            margin-bottom: 8px;
            transition: 0.3s;
        }

        .sidebar a:hover {
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

    </style>
</head>

<body>

<div class="wrapper">

    <!-- ===== SIDEBAR ===== -->
    <div class="sidebar">
        <img src="{{ asset('images/pagk_logo.png') }}" alt="Logo">

        <h3>District Panel</h3>

        <a href="{{ route('district.admin.dashboard') }}">Dashboard</a>
        <a href="#">Assemblies</a>
        <a href="#">Members</a>
        <a href="#">Pastoral Team</a>
        <a href="#">Tithe Reports</a>
        <a href="#">Transfers</a>
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