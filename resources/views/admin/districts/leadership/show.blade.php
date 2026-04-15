@extends('layouts.admin')

@section('content')

<style>
/* ===== CONTAINER ===== */
.profile-container {
    max-width: 800px;
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

/* ===== TITLE ===== */
.page-title {
    font-size: 22px;
    margin-bottom: 15px;
}

/* ===== SECTION TITLE ===== */
.section-title {
    font-size: 18px;
    margin-top: 20px;
    margin-bottom: 10px;
}

/* ===== BACK BUTTON (optional reuse if needed) ===== */
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

.btn-back:hover {
    opacity: 0.85;
}

/* ===== DETAILS GRID ===== */
.details {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}

.detail-box {
    background: #f9f9f9;
    padding: 10px;
    border-radius: 8px;
    font-size: 14px;
}

/* ===== POSITION STYLE ===== */
.position {
    color: #003366;
    font-weight: 600;
}

/* ===== PHOTO ===== */
.photo {
    width: 150px;
    height: 150px;
    border-radius: 10px;
    object-fit: cover;
    border: 1px solid #ddd;
}

/* ===== ATTACHMENTS ===== */
.attachments {
    list-style: none;
    padding: 0;
}

.attachments li {
    margin-bottom: 10px;
    padding: 10px;
    border: 1px solid #eee;
    border-radius: 8px;
    background: #fafafa;
}

.attachments a {
    color: #1a73e8;
    font-weight: 500;
    text-decoration: none;
}

.attachments a:hover {
    text-decoration: underline;
}

.file-name {
    font-size: 12px;
    color: #666;
    margin-top: 3px;
}

/* ===== MOBILE ===== */
@media (max-width: 768px) {
    .details {
        grid-template-columns: 1fr;
    }

    .page-title {
        font-size: 18px;
    }

    .photo {
        width: 120px;
        height: 120px;
    }
}
</style>

<div class="profile-container">

    <div class="profile-card">

        <h2 class="page-title">Leader Profile</h2>

        <!-- BASIC DETAILS -->
        <p><strong>Name:</strong> {{ $leader->name }}</p>

        <p>
            <strong>Position:</strong>
            <span class="position">
                {{ $leader->position ?? 'N/A' }}
            </span>
        </p>

        <p><strong>Gender:</strong> {{ $leader->gender }}</p>
        <p><strong>Contact:</strong> {{ $leader->contact }}</p>
        <p><strong>National ID:</strong> {{ $leader->national_id }}</p>

        <p><strong>Date of Birth:</strong>
            {{ \Carbon\Carbon::parse($leader->dob)->format('d M Y') }}
        </p>

        <!-- AGE -->
        <p>
            <strong>Age:</strong>
            {{ \Carbon\Carbon::parse($leader->dob)->age }} years
        </p>

        <hr style="margin: 20px 0;">

        <!-- BANK DETAILS -->
        <h3 class="section-title">Bank Details</h3>

        <div class="details">

            <div class="detail-box">
                <strong>Bank Name</strong><br>
                {{ $leader->bank_name ?? 'N/A' }}
            </div>

            <div class="detail-box">
                <strong>Branch</strong><br>
                {{ $leader->bank_branch ?? 'N/A' }}
            </div>

            <div class="detail-box">
                <strong>Account Number</strong><br>
                {{ $leader->account_number ?? 'N/A' }}
            </div>

        </div>

        <hr style="margin: 20px 0;">

        <!-- PHOTO -->
        <h3 class="section-title">Photo</h3>

        @if($leader->photo)
            <img src="{{ asset('storage/' . $leader->photo) }}" class="photo">
        @else
            <p>No photo uploaded.</p>
        @endif

        <hr style="margin: 20px 0;">

        <!-- ATTACHMENTS -->
        <h3 class="section-title">Attachments</h3>

        @if(!empty($leader->attachments))

            <ul class="attachments">

                @foreach($leader->attachments as $file)
                    <li>
                        <a href="{{ asset('storage/' . $file) }}" target="_blank">
                            📎 View Credential
                        </a>

                        <div class="file-name">
                            {{ basename($file) }}
                        </div>
                    </li>
                @endforeach

            </ul>

        @else
            <p>No Credentials uploaded.</p>
        @endif

    </div>

</div>

@endsection