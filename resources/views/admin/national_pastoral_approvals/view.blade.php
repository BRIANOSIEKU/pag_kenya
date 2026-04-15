@extends('layouts.admin')

@section('content')

<style>
/* ===== WRAPPER ===== */
.page-wrapper {
    max-width: 1000px;
    margin: auto;
    padding: 15px;
}

/* ===== BACK BUTTON ===== */
.btn-back {
    display: inline-block;
    background: #607D8B;
    color: #fff;
    padding: 10px 14px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 13px;
    font-weight: bold;
    margin-bottom: 15px;
}

.btn-back:hover { opacity: 0.85; }

/* ===== CARD ===== */
.card {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
}

/* ===== PHOTO ===== */
.photo {
    width: 150px;
    height: 150px;
    border-radius: 12px;
    object-fit: cover;
    border: 1px solid #ddd;
}

/* ===== DETAILS ===== */
.details p {
    margin: 6px 0;
    font-size: 14px;
}

/* ===== STATUS BADGES ===== */
.badge {
    padding: 4px 8px;
    border-radius: 4px;
    color: #fff;
    font-size: 12px;
}

.badge-pending { background: orange; }
.badge-approved { background: green; }
.badge-rejected { background: red; }

/* ===== SECTION TITLE ===== */
.section-title {
    margin-top: 20px;
    font-size: 18px;
    color: #1e3c72;
}

/* ===== ATTACHMENTS ===== */
.attachments a {
    color: #1976d2;
    text-decoration: none;
    margin-bottom: 6px;
    display: inline-block;
}

/* ===== ACTION BOX ===== */
.actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: 15px;
}

/* ===== BUTTONS ===== */
.btn {
    padding: 10px 14px;
    border-radius: 6px;
    border: none;
    color: #fff;
    cursor: pointer;
    font-size: 13px;
}

.btn-approve { background: #4CAF50; }
.btn-reject { background: #F44336; }

textarea {
    width: 100%;
    max-width: 300px;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 6px;
    margin-top: 8px;
}

/* ===== MOBILE ===== */
@media (max-width: 768px) {
    .card {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .details {
        width: 100%;
    }

    textarea {
        max-width: 100%;
    }
}
</style>

<div class="page-wrapper">

    {{-- BACK --}}
    <a href="{{ route('admin.national.pastoral.approvals.index') }}" class="btn-back">
        ← Back to National Approvals
    </a>

    <h2 style="color:#1e3c72;">Pastoral Profile (National Review)</h2>

    @php
        use Carbon\Carbon;

        $age = $pastor->date_of_birth
            ? Carbon::parse($pastor->date_of_birth)->age
            : null;

        $attachments = $pastor->attachments;

        if (is_string($attachments)) {
            $attachments = json_decode($attachments, true);
        }

        if (!is_array($attachments)) {
            $attachments = [];
        }

        $attachments = array_filter($attachments);
    @endphp

    {{-- PROFILE CARD --}}
    <div class="card">

        {{-- PHOTO --}}
        <div>
            @if($pastor->photo)
                <img src="{{ asset('storage/' . ltrim($pastor->photo, '/')) }}" class="photo">
            @else
                <p>No Photo</p>
            @endif
        </div>

        {{-- DETAILS --}}
        <div class="details">

            <p><strong>Name:</strong> {{ $pastor->name }}</p>
            <p><strong>National ID:</strong> {{ $pastor->national_id }}</p>
            <p><strong>District:</strong> {{ $pastor->district_name ?? 'N/A' }}</p>
            <p><strong>Assembly:</strong> {{ $pastor->assembly_name ?? 'N/A' }}</p>
            <p><strong>Contact:</strong> {{ $pastor->contact }}</p>
            <p><strong>Gender:</strong> {{ $pastor->gender }}</p>
            <p><strong>Graduation Year:</strong> {{ $pastor->graduation_year ?? 'N/A' }}</p>
            <p><strong>Date of Birth:</strong> {{ $pastor->date_of_birth ?? 'N/A' }}</p>
            <p><strong>Age:</strong> {{ $age ?? 'N/A' }}</p>

            {{-- STATUS --}}
            <p><strong>Status:</strong>
                @if($pastor->status == 'pending')
                    <span class="badge badge-pending">Pending</span>
                @elseif($pastor->status == 'approved')
                    <span class="badge badge-approved">Approved</span>
                @elseif($pastor->status == 'rejected')
                    <span class="badge badge-rejected">Rejected</span>
                @endif
            </p>

            {{-- REJECTION REASON --}}
            @if($pastor->status == 'rejected' && !empty($pastor->rejection_reason))
                <p style="color:#b71c1c;">
                    <strong>Rejection Reason:</strong><br>
                    {{ $pastor->rejection_reason }}
                </p>
            @endif

        </div>

    </div>

    {{-- ATTACHMENTS --}}
    <h3 class="section-title">Attachments</h3>

    <div class="attachments">

        @if(count($attachments) > 0)
            @foreach($attachments as $file)
                <a href="{{ asset('storage/' . $file) }}" target="_blank">
                    📎 View Attachment
                </a>
            @endforeach
        @else
            <p style="color:#777;">No attachments uploaded</p>
        @endif

    </div>

    {{-- ACTIONS --}}
    <h3 class="section-title">National Decision</h3>

    <div class="actions">

        <form method="POST"
              action="{{ route('admin.national.pastoral.approvals.approve', $pastor->id) }}">
            @csrf
            <button class="btn btn-approve">
                Approve Pastor
            </button>
        </form>

        <form method="POST"
              action="{{ route('admin.national.pastoral.approvals.reject', $pastor->id) }}">
            @csrf

            <div>
                <textarea name="rejection_reason"
                          placeholder="Enter rejection reason..."
                          required></textarea>
            </div>

            <button class="btn btn-reject"
                    onclick="return confirm('Reject this pastor?')">
                Reject Pastor
            </button>
        </form>

    </div>

</div>

@endsection