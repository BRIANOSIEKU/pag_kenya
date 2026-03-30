@extends('layouts.admin')

@section('content')

<style>
    /* ===== Dashboard Grid Styling ===== */
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }

    .card {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .card h3 {
        margin-bottom: 10px;
        font-size: 1.2rem;
        color: #1e3c72;
    }

    .card p {
        margin-bottom: 12px;
        font-size: 0.95rem;
        color: #555;
    }

    .card a {
        display: inline-block;
        padding: 10px;
        border-radius: 6px;
        font-weight: bold;
        text-decoration: none;
        text-align: center;
        color: #fff;
        transition: all 0.3s ease;
    }

    .card a:hover {
        opacity: 0.85;
    }

    /* Specific colors for buttons */
    .btn-gold { background: #FFD700; color: #1e3c72; border: 2px solid #4CAF50; }
    .btn-gold:hover { background: #4CAF50; color: #fff; }
    .btn-green { background: #4CAF50; }
    .btn-blue { background: #2196F3; }
    .btn-orange { background: #FF9800; }
    .btn-purple { background: #9C27B0; }
    .btn-red { background: #FF5722; }
    .btn-deep-purple { background: #673AB7; }
    .btn-brown { background: #795548; }
    .btn-teal { background: #009688; }
    .btn-pink { background: #E91E63; }
    .btn-orange-dark { background: #FF4500; }
    .btn-amber { background: #FFA500; }

    /* Section headings */
    h2 {
        margin-top: 40px;
        margin-bottom: 20px;
        color: #1e3c72;
        font-size: 1.5rem;
        border-bottom: 2px solid #e0e0e0;
        padding-bottom: 6px;
    }

    /* Logout area */
    .logout-area {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .logout-area h1 {
        font-size: 1.8rem;
        color: #1e3c72;
    }

    @media (max-width: 600px) {
        .logout-area {
            flex-direction: column;
            gap: 12px;
        }
    }
</style>

<!-- ===== Header & Logout ===== -->
<div class="logout-area">
    <h1>Admin Dashboard</h1>

    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <a href="#"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
       class="btn-gold">
       Logout
    </a>
</div>

<p>Welcome, {{ Auth::user()->name }}</p>
<hr>

<!-- ================= WEBSITE CONTENT ================= -->
<h2>Website Management</h2>
<div class="dashboard-grid">

    <!-- Church Profile -->
    <div class="card">
        <h3>Church Profile</h3>
        <p>Mission, Vision, Core Values</p>
        @php $profile = \App\Models\ChurchProfile::first(); @endphp
        @if($profile)
            <a href="{{ route('admin.church-profile.show', $profile->id) }}" class="btn-blue">View Profile</a>
        @else
            <a href="{{ route('admin.church-profile.create') }}" class="btn-blue">Add Profile</a>
        @endif
    </div>

    <!-- Leadership -->
    <div class="card">
        <h3>Leadership</h3>
        <p>Manage Leadership Structure</p>
        <div style="display:flex; flex-direction:column; gap:8px; margin-top:10px;">
            <a href="{{ route('admin.leadership.index', ['type' => 'executive']) }}" class="btn-green">Executive Committee</a>
            <a href="{{ route('admin.leadership.index', ['type' => 'council']) }}" class="btn-blue">Church Council</a>
            <a href="{{ route('admin.overseers.index') }}" class="btn-brown">Church Overseers</a>
            <a href="{{ route('admin.pastoral-teams.index') }}" class="btn-brown">Pastoral Team</a>
            <a href="{{ route('admin.leadership.index', ['type' => 'hq']) }}" class="btn-orange">PAG HQ Staff</a>
        </div>
    </div>

    <!-- Departments -->
    <div class="card">
        <h3>Departments</h3>
        <p>Create, Edit & Delete Departments</p>
        <a href="{{ route('admin.departments.index') }}" class="btn-purple">Manage</a>
    </div>

    <!-- News -->
    <div class="card">
        <h3>News & Updates</h3>
        <p>Post church news</p>
        <a href="{{ route('admin.news.index') }}" class="btn-red">Manage</a>
    </div>

    <!-- Projects -->
    <div class="card">
        <h3>Projects</h3>
        <p>Manage church projects</p>
        <a href="{{ route('admin.projects.index') }}" class="btn-orange">Manage</a>
    </div>

    <!-- Daily Devotions -->
    <div class="card">
        <h3>Daily Devotions</h3>
        <p>Create & schedule devotions</p>
        <a href="{{ route('admin.devotions.index') }}" class="btn-deep-purple">Manage</a>
    </div>

    <!-- Partners -->
    <div class="card">
        <h3>Partners</h3>
        <p>Manage ministry partners</p>
        <a href="{{ route('admin.partners.index') }}" class="btn-teal">Manage</a>
    </div>
      <!--Admin Management -->
    <div class="card">
        <h3>Admin Management</h3>
        <p>Manage Admins</p>
        <a href="{{ route('admin.admins.create') }}" class="btn-teal">Manage</a>
    </div>
     <!--Admin Management -->
    <div class="card">
        <h3>PASSWORD RESET</h3>
        <p>Reset my Password </p>
        <a href="{{ route('admin.admins.reset_my_password.form') }}" class="btn-teal">Reset</a>
    </div>
</div>

<!-- ================= USER INTERACTIONS ================= -->
<h2>User Interactions</h2>
<div class="dashboard-grid">
    <div class="card">
        <h3>Comments Moderation</h3>
        <p>Approve or delete user comments</p>
        <a href="{{ route('admin.comments.index') }}" class="btn-orange-dark">Moderate</a>
    </div>

    <div class="card">
        <h3>Chat Messages</h3>
        <p>Respond to live chat inquiries</p>
        <a href="#" class="btn-teal">View Messages</a>
    </div>
</div>

<!-- ================= ANNOUNCEMENTS ================= -->
<h2>Announcements</h2>
<div class="card">
    <h3>Announcements</h3>
    <p>Post official memos & videos</p>
    <div style="display:flex; flex-direction:column; gap:8px; margin-top:10px;">
        <a href="{{ route('admin.announcements.index') }}" class="btn-blue-">Manage Announcements</a>
        <a href="{{ route('admin.announcements.create') }}" class="btn-amber">Add Announcement</a>
    </div>
</div>

<!-- ================= FINANCE & COMMUNICATION ================= -->
<h2>Finance & Communication</h2>
<div class="dashboard-grid">
    <div class="card">
        <h3>Donations / Online Giving</h3>
        <p>View transactions & reports</p>
        <a href="{{ route('admin.donations.index') }}" class="btn-green">View Donations</a>
    </div>

    <div class="card">
        <h3>Contact Us</h3>
        <p>Manage official contact info</p>
        <a href="{{ route('admin.contact.index') }}" class="btn-pink">Manage</a>
    </div>

    <div class="card">
        <h3>Live Streaming</h3>
        <p>Manage YouTube, Facebook & Radio</p>
        <div style="display:flex; flex-direction:column; gap:8px; margin-top:10px;">
            <a href="{{ route('admin.livestreams.index') }}" class="btn-teal">Manage Live Streams</a>
            <a href="{{ route('admin.livestreams.create') }}" class="btn-green">Add New Stream</a>
        </div>
    </div>
</div>

@endsection