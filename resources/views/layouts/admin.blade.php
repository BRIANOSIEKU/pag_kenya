<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard - PAG (K)</title>

<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color:#f4f6f9; }

/* ================= SIDEBAR ================= */
.sidebar {
    width:250px;
    background: linear-gradient(180deg,#003366,#002244);
    color:white;
    min-height:100vh;
    padding:20px 15px;
    position:fixed;
    box-shadow:2px 0 10px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
    z-index: 1000;
}

.sidebar h2 {
    text-align:center; margin-bottom:25px; font-size:20px;
    letter-spacing:1px; border-bottom:1px solid rgba(255, 255, 255, 0.2); padding-bottom:10px;
    color: white;
}


.sidebar ul { list-style:none; }
.sidebar ul li { margin-bottom:8px; }
.sidebar ul li a {
    color:#fff; text-decoration:none; display:block;
    padding:10px 12px; border-radius:6px; transition:0.3s ease; font-size:14px;
}
.sidebar ul li a:hover { background-color:#00509e; padding-left:16px; }
.sidebar ul li a.highlight { background-color:#007BB8; font-weight:bold; }
.sidebar .logout { margin-top:30px; background-color:#c0392b; text-align:center; }
.sidebar .logout:hover { background-color:#922b21; }

/* ================= MOBILE MENU ================= */
.mobile-menu-btn {
    display:none; width:50px; height:50px; font-size:28px;
    background:#003366; color:#fff; border:none; border-radius:6px; cursor:pointer;
    position:fixed; top:15px; left:15px; z-index:1100;
}

/* mobile hidden = off-screen */
.sidebar.mobile-hidden { transform: translateX(-100%); }

/* mobile visible = slide in */
.sidebar.mobile-visible { transform: translateX(0); }

/* ================= MAIN CONTENT ================= */
.main-content {
    margin-left:250px; /* space for sidebar on desktop */
    padding:30px;
    transition: margin-left 0.3s ease;
}

/* ================= TOPBAR ================= */
.topbar { background:white; padding:15px 20px; border-radius:10px; margin-bottom:25px; box-shadow:0 2px 10px rgba(0,0,0,0.05); display:flex; justify-content:space-between; align-items:center; }
.topbar-left { display:flex; align-items:center; gap:15px; }
.admin-logo { height:90px; }
.topbar h1 { font-size:22px; color:#003366; }
.user-info { font-size:14px; color:#555; }
.card { background:white; padding:20px; border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,0.05); }

/* ================= RESPONSIVE ================= */
@media(max-width:768px){
    .sidebar { width:50%; transform: translateX(-100%); }
    .mobile-menu-btn { display:block; }
    .main-content { margin-left:0; padding:15px; }
        .sidebar h2 {
        color: #0a9cf0;    }
}

/* ================= DESKTOP OVERRIDE ================= */
@media(min-width:769px){
    .sidebar { transform: none !important; position:fixed; top:0; left:0; }
    .main-content { margin-left:250px; } /* always leave space for sidebar */
}
</style>
</head>
<body>

<!-- ================= MOBILE MENU BUTTON ================= -->
<button class="mobile-menu-btn" onclick="toggleMobileMenu()">☰</button>

<!-- ================= SIDEBAR ================= -->
<div class="sidebar mobile-hidden" id="sidebar">
    <h2>PAG KENYA Admin</h2>
    <ul>
        <li><a href="{{ route('admin.dashboard') }}" onclick="closeMobileMenu()">🏠 Dashboard</a></li>
        <li><a href="{{ route('admin.church-profile.index') }}" onclick="closeMobileMenu()">⛪ Church Profile</a></li>
        <li><a href="{{ route('admin.leadership.index', ['type'=>'executive']) }}" onclick="closeMobileMenu()">👥 Leadership</a></li>
        <li><a href="{{ route('admin.departments.index') }}" onclick="closeMobileMenu()">📂 Departments</a></li>
        <li><a href="{{ route('admin.news.index') }}" onclick="closeMobileMenu()">📰 News & Updates</a></li>
        <li><a href="{{ route('admin.devotions.index') }}" onclick="closeMobileMenu()">📖 Daily Devotions</a></li>
        <li><a href="{{ route('admin.livestreams.index') }}" onclick="closeMobileMenu()">📺 Live Streaming</a></li>
        <li><a href="{{ route('admin.comments.index') }}" onclick="closeMobileMenu()">💬 Comments</a></li>
        <li><a href="{{ route('admin.contact.index') }}" onclick="closeMobileMenu()">📩 Contact US</a></li>
        <li><a href="{{ route('admin.donations.index') }}" onclick="closeMobileMenu()">💰 Donations</a></li>
        <li><a href="{{ route('admin.projects.index') }}" onclick="closeMobileMenu()">📊 Projects</a></li>
        <li><a href="{{ route('admin.partners.index') }}" onclick="closeMobileMenu()">🤝 Partners</a></li>
        <li><a href="{{ route('admin.announcements.index') }}" onclick="closeMobileMenu()">📢 Announcements</a></li>
        <li><a href="{{ route('admin.hero.index') }}" class="highlight" onclick="closeMobileMenu()">🖼 Hero Slides & Theme</a></li>

        <li>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout">🚪 Logout</button>
            </form>
        </li>
    </ul>
</div>

<!-- ================= MAIN CONTENT ================= -->
<div class="main-content">
    <div class="topbar">
        <div class="topbar-left">
            <img src="{{ asset('images/pagk_logo.png') }}" class="admin-logo">
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
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('mobile-visible');
    sidebar.classList.remove('mobile-hidden');
}

function closeMobileMenu() {
    const sidebar = document.getElementById('sidebar');
    if(window.innerWidth <= 768){
        sidebar.classList.remove('mobile-visible');
        sidebar.classList.add('mobile-hidden');
    }
}

// Resize listener to restore sidebar for desktop
window.addEventListener('resize', () => {
    const sidebar = document.getElementById('sidebar');
    if(window.innerWidth > 768){
        sidebar.classList.remove('mobile-hidden');
        sidebar.classList.remove('mobile-visible');
    } else {
        sidebar.classList.add('mobile-hidden');
    }
});
</script>

</body>
</html>