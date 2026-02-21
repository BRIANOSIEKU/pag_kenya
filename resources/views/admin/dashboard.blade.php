@extends('layouts.admin')

@section('content')

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h1>Admin Dashboard</h1>

    <!-- Logout button with hidden POST form -->
    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    <a href="#"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
       style="
           background-color: #FFD700;
           color: #1e3c72;
           padding: 10px 18px;
           border: 2px solid #4CAF50;
           border-radius: 6px;
           font-weight: bold;
           cursor: pointer;
           text-decoration: none;
       "
       onmouseover="this.style.backgroundColor='#4CAF50'; this.style.color='#fff';"
       onmouseout="this.style.backgroundColor='#FFD700'; this.style.color='#1e3c72';"
    >
       Logout
    </a>
</div>

<p>Welcome, {{ Auth::user()->name }}</p>
<hr><br>

<!-- ================= WEBSITE CONTENT ================= -->
<h2>Website Management</h2>

<div class="dashboard-grid">

    <!-- Home Page -->
    <div class="card">
        <h3>Home Page</h3>
        <p>Manage Theme of the Year & Scripture of the Year</p>
        <a href="{{ route('admin.dashboard') }}">Manage</a>
    </div>

    <!-- Church Profile -->
    <div class="card">
        <h3>Church Profile</h3>
        <p>Mission, Vision, Core Values, Statement of Faith</p>
        @php
            $profile = \App\Models\ChurchProfile::first();
        @endphp
        @if($profile)
            <a href="{{ route('admin.church-profile.show', $profile->id) }}">View Profile</a>
        @else
            <a href="{{ route('admin.church-profile.create') }}">Add Profile</a>
        @endif
    </div>

    <!-- Leadership -->
    <div class="card">
        <h3>Leadership</h3>
        <p>Manage Current & Former Leaders</p>
        <div style="display:flex; flex-direction:column; gap:8px; margin-top:10px;">
            <a href="{{ route('admin.leadership.index', ['type' => 'executive']) }}"
               style="background-color:#4CAF50; color:#fff; padding:8px; border-radius:6px; text-align:center; font-weight:bold; text-decoration:none; transition:0.3s;"
               onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                Executive Committee
            </a>
            <a href="{{ route('admin.leadership.index', ['type' => 'council']) }}"
               style="background-color:#2196F3; color:#fff; padding:8px; border-radius:6px; text-align:center; font-weight:bold; text-decoration:none; transition:0.3s;"
               onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                Church Council
            </a>
            <a href="{{ route('admin.leadership.index', ['type' => 'hq']) }}"
               style="background-color:#FF9800; color:#fff; padding:8px; border-radius:6px; text-align:center; font-weight:bold; text-decoration:none; transition:0.3s;"
               onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                PAG HQ Staff
            </a>
        </div>
    </div>

    <!-- Departments -->
    <div class="card">
        <h3>Departments</h3>
        <p>Create, Edit & Delete Departments</p>
        <a href="{{ route('admin.departments.index') }}"
           style="background-color:#9C27B0; color:#fff; padding:8px; border-radius:6px; text-align:center; font-weight:bold; text-decoration:none; transition:0.3s;"
           onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
            Manage
        </a>
    </div>

    <!-- News & Updates -->
    <div class="card">
        <h3>News & Updates</h3>
        <p>Post church news and announcements</p>
        <a href="{{ route('admin.news.index') }}"
           style="background-color:#FF5722; color:#fff; padding:8px; border-radius:6px; text-align:center; font-weight:bold; text-decoration:none; transition:0.3s;"
           onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
            Manage
        </a>
    </div>

    <!-- Projects -->
    <div class="card">
        <h3>Projects</h3>
        <p>Manage church projects & progress</p>
        <a href="{{ route('admin.projects.index') }}"
           style="background-color:#FF9800; color:#fff; padding:8px; border-radius:6px; text-align:center; font-weight:bold; text-decoration:none; transition:0.3s;"
           onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
            Manage
        </a>
    </div>

    <!-- Daily Devotions -->
    <div class="card">
        <h3>Daily Devotions</h3>
        <p>Create and schedule devotions</p>
        <a href="{{ route('admin.devotions.index') }}"
           style="background-color:#673AB7; color:#fff; padding:8px; border-radius:6px; text-align:center; font-weight:bold; text-decoration:none; transition:0.3s;"
           onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
            Manage
        </a>
    </div>

    <!-- Partners -->
    <div class="card">
        <h3>Partners</h3>
        <p>Manage ministry partners</p>
        <a href="{{ route('admin.partners.index') }}">Manage</a>
    </div>

</div>

<br><hr><br>

<!-- ================= USER INTERACTIONS ================= -->
<h2>User Interactions</h2>
<div class="dashboard-grid">
    <div class="card">
        <h3>Comments Moderation</h3>
        <p>Approve or delete user comments</p>
        <a href="{{ route('admin.comments.index') }}">Moderate</a>
    </div>

    <div class="card">
        <h3>Chat Messages</h3>
        <p>Respond to live chat inquiries</p>
        <a href=""
           style="background-color:#009688; color:#fff; padding:8px; border-radius:6px; display:inline-block; text-align:center; font-weight:bold; text-decoration:none; transition:0.3s;"
           onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
            View Messages
        </a>
    </div>
</div>

<br><hr><br>

<!-- ================= FINANCE & COMMUNICATION ================= -->
<h2>Finance & Communication</h2>
<div class="dashboard-grid">

    <div class="card">
        <h3>Donations / Online Giving</h3>
        <p>View transactions and giving reports</p>
        <a href="{{ route('admin.donations.index') }}">View Donations</a>
    </div>

    <div class="card">
        <h3>Contact Us</h3>
        <p>Manage official contact information</p>
        <a href="{{ route('admin.contact.index') }}"
           style="background-color:#E91E63; color:#fff; padding:8px; border-radius:6px; text-align:center; font-weight:bold; text-decoration:none; transition:0.3s;"
           onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
            Manage
        </a>
    </div>

   <div class="card">
    <h3>Live Streaming</h3>
    <p>Manage church radio, YouTube, Facebook, and other live events</p>

    <div style="display:flex; flex-direction:column; gap:8px; margin-top:10px;">

        <a href="{{ route('admin.livestreams.index') }}"
           style="background-color:#009688; color:#fff; padding:8px; border-radius:6px; text-align:center; font-weight:bold; text-decoration:none; transition:0.3s;"
           onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
            Manage Live Streams
        </a>

        <a href="{{ route('admin.livestreams.create') }}"
           style="background-color:#4CAF50; color:#fff; padding:8px; border-radius:6px; text-align:center; font-weight:bold; text-decoration:none; transition:0.3s;"
           onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
            Add New Stream
        </a>


        </a>

    </div>
</div>

</div>

@endsection