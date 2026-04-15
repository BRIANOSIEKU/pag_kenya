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

        /* ===== WRAPPER ===== */
        .wrapper {
            display: flex;
        }

        /* ===== OVERLAY ===== */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.45);
            z-index: 900;
        }

        .overlay.show {
            display: block;
        }

        /* ===== SIDEBAR (DESKTOP ONLY VISIBLE) ===== */
        .sidebar {
            width: 260px;
            background: #1e3c72;
            color: #fff;
            min-height: 100vh;
            padding: 20px;
            transition: 0.3s ease;
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
            width: 100%;
        }

        /* ===== TOPBAR ===== */
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            gap: 10px;
        }

        /* ===== MENU BUTTON ===== */
        .menu-toggle {
            background: #1e3c72;
            color: #fff;
            border: none;
            padding: 10px 16px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 3px 8px rgba(0,0,0,0.2);
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

        /* ===== CLOSE BUTTON ===== */
        .close-btn {
            font-size: 26px;
            cursor: pointer;
            text-align: right;
            margin-bottom: 10px;
            font-weight: bold;
        }

        /* ===========================
           🔥 MOBILE FIX (IMPORTANT)
        =========================== */
        @media (max-width: 768px) {

            .wrapper {
                display: block; /* 👈 removes side-by-side layout */
            }

            .sidebar {
                position: fixed;
                top: 0;
                left: -300px; /* 👈 COMPLETELY OFF SCREEN */
                height: 100%;
                width: 260px;
                z-index: 1000;
                padding-top: 15px;
            }

            .sidebar.show {
                left: 0;
            }

            .main {
                padding: 15px;
            }
        }
    </style>
</head>

<body>

<!-- OVERLAY -->
<div class="overlay" onclick="closeSidebar()"></div>

<div class="wrapper">

    <!-- SIDEBAR -->
    <div class="sidebar">

        <div class="close-btn" onclick="closeSidebar()">×</div>

        <img src="{{ asset('images/pagk_logo.png') }}" alt="Logo">

        <h3>District Panel</h3>

        <div class="menu-section">
            <div class="menu-title">Main</div>
            <a href="{{ route('district.admin.dashboard') }}">Dashboard</a>
        </div>

        <div class="menu-section">
            <div class="menu-title">Church Structure</div>
            <a href="{{ route('district.admin.assemblies.index') }}">Assemblies</a>
            <a href="{{ route('district.admin.pastoral.index') }}">Pastoral Team</a>
        </div>

        <div class="menu-section">
            <div class="menu-title">Finance</div>
            <a href="{{ route('district.admin.tithes.index') }}">Tithe Reports</a>
        </div>

        <div class="menu-section">
            <div class="menu-title">Transfers</div>
            <a href="{{ route('district.admin.pastoral.transfers.incoming') }}">Pastoral Transfers</a>
        </div>

        <div class="menu-section">
            <div class="menu-title">Account</div>
            <a href="{{ route('district.admin.logout') }}">Logout</a>
        </div>

    </div>

    <!-- MAIN CONTENT -->
    <div class="main">

        <div class="topbar">

            <button class="menu-toggle" onclick="openSidebar()">☰ Menu</button>

            <h2>District Admin Dashboard</h2>

            <a href="{{ route('district.admin.logout') }}" class="logout-btn">
                Logout
            </a>
        </div>

        @yield('content')

    </div>

</div>

<script>
    function openSidebar() {
        document.querySelector('.sidebar').classList.add('show');
        document.querySelector('.overlay').classList.add('show');
    }

    function closeSidebar() {
        document.querySelector('.sidebar').classList.remove('show');
        document.querySelector('.overlay').classList.remove('show');
    }
</script>

</body>
</html>