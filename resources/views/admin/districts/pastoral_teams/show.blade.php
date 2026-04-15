@extends('layouts.admin')

@section('content')

<style>
/* ===== PAGE WRAPPER ===== */
.profile-container {
    max-width: 900px;
    margin: auto;
    padding: 10px;
}

/* ===== CARD ===== */
.profile-card {
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
}

/* ===== BACK BUTTON ===== */
.btn-back {
    display: inline-block;
    margin-bottom: 15px;
    padding: 8px 12px;
    background: #555;
    color: #fff;
    border-radius: 6px;
    text-decoration: none;
    font-size: 13px;
}

.btn-back:hover { opacity: 0.85; }

/* ===== HEADER ===== */
.profile-header {
    display: flex;
    gap: 20px;
    align-items: center;
    flex-wrap: wrap;
}

.profile-header img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #eee;
}

.profile-header h2 {
    margin: 0;
    font-size: 22px;
}

/* ===== DETAILS GRID ===== */
.details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 15px;
}

.detail-box {
    background: #f9f9f9;
    padding: 12px;
    border-radius: 8px;
}

/* ===== SECTION TITLE ===== */
.section-title {
    font-size: 18px;
    margin-bottom: 10px;
}

/* ===== CREDENTIALS ===== */
.credentials ul {
    padding-left: 18px;
}

.credentials a {
    color: #2196F3;
    text-decoration: none;
}

.credentials a:hover {
    text-decoration: underline;
}

/* ===== MOBILE ===== */
@media (max-width: 768px) {
    .profile-header {
        flex-direction: column;
        text-align: center;
    }

    .profile-header img {
        width: 100px;
        height: 100px;
    }

    .profile-header h2 {
        font-size: 18px;
    }
}
</style>

<div class="profile-container">

    <h2 style="margin-bottom:15px;">Pastoral Team Member Profile</h2>

    <div class="profile-card">

        <!-- BACK -->
        <a href="{{ route('admin.districts.pastoral-teams.index', $pastor->district_id) }}"
           class="btn-back">
            ← Back to Pastoral Team List
        </a>

        <!-- HEADER -->
        <div class="profile-header">

            <img src="{{ $pastor->photo ? asset('storage/' . $pastor->photo) : 'https://via.placeholder.com/120' }}">

            <div>
                <h2>{{ $pastor->name }}</h2>
                <p><strong>Gender:</strong> {{ $pastor->gender }}</p>
                <p><strong>Contact:</strong> {{ $pastor->contact }}</p>
                <p><strong>National ID:</strong> {{ $pastor->national_id }}</p>
            </div>

        </div>

        <hr style="margin:20px 0;">

        <!-- DETAILS -->
        <div class="details-grid">

            <div class="detail-box">
                <strong>District</strong><br>
                {{ $pastor->district->name ?? 'N/A' }}
            </div>

            <div class="detail-box">
                <strong>Assembly</strong><br>
                {{ $pastor->assembly->name ?? 'N/A' }}
            </div>

            <div class="detail-box">
                <strong>Year of Graduation</strong><br>
                {{ $pastor->graduation_year ?? 'N/A' }}
            </div>

            <div class="detail-box">
                <strong>Date of Birth</strong><br>
                {{ $pastor->date_of_birth ? \Carbon\Carbon::parse($pastor->date_of_birth)->format('d M Y') : 'N/A' }}
            </div>

        </div>

        <hr style="margin:20px 0;">

        <!-- CREDENTIALS -->
        <div class="credentials">

            <h3 class="section-title">Credentials</h3>

            @php
                $files = $pastor->attachments ? json_decode($pastor->attachments, true) : [];
            @endphp

            @if(!empty($files) && count($files))
                <ul>
                    @foreach($files as $file)
                        <li>
                            <a href="{{ asset('storage/' . $file) }}" target="_blank">
                                📄 View Credential
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p>No credentials available.</p>
            @endif

        </div>

    </div>

</div>

@endsection