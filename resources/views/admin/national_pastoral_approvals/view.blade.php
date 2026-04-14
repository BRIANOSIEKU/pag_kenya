@extends('layouts.admin')

@section('content')

<h2>Pastoral Profile (National Review)</h2>

<!-- BACK BUTTON -->
<a href="{{ route('admin.national.pastoral.approvals.index') }}"
   style="padding:8px 12px;background:#607D8B;color:#fff;border-radius:6px;text-decoration:none;display:inline-block;margin-bottom:15px;">
    ← Back to National Approvals
</a>

@php
    use Carbon\Carbon;

    $age = $pastor->date_of_birth
        ? Carbon::parse($pastor->date_of_birth)->age
        : null;
@endphp

<!-- PROFILE CARD -->
<div style="display:flex; gap:20px; background:#fff; padding:20px; border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,0.1);">

    <!-- PHOTO -->
    <div>
        @if($pastor->photo)
            <img src="{{ asset('storage/' . ltrim($pastor->photo, '/')) }}"
                 width="150" height="150"
                 style="border-radius:10px;">
        @else
            <p>No Photo</p>
        @endif
    </div>

    <!-- DETAILS -->
    <div>

        <p><strong>Name:</strong> {{ $pastor->name }}</p>
        <p><strong>National ID:</strong> {{ $pastor->national_id }}</p>
        <p><strong>District:</strong> {{ $pastor->district_name ?? 'N/A' }}</p>
        <p><strong>Assembly:</strong> {{ $pastor->assembly_name ?? 'N/A' }}</p>
        <p><strong>Contact:</strong> {{ $pastor->contact }}</p>
        <p><strong>Gender:</strong> {{ $pastor->gender }}</p>
        <p><strong>Graduation Year:</strong> {{ $pastor->graduation_year ?? 'N/A' }}</p>
        <p><strong>Date of Birth:</strong> {{ $pastor->date_of_birth ?? 'N/A' }}</p>
        <p><strong>Age:</strong> {{ $age ?? 'N/A' }}</p>

        <!-- STATUS -->
        <p><strong>Status:</strong>
            @if($pastor->status == 'pending')
                <span style="background:orange;color:#fff;padding:4px 8px;border-radius:4px;">Pending</span>
            @elseif($pastor->status == 'approved')
                <span style="background:green;color:#fff;padding:4px 8px;border-radius:4px;">Approved</span>
            @elseif($pastor->status == 'rejected')
                <span style="background:red;color:#fff;padding:4px 8px;border-radius:4px;">Rejected</span>
            @endif
        </p>

        <!-- =========================
             REJECTION REASON (NEW)
        ========================= -->
        @if($pastor->status == 'rejected' && !empty($pastor->rejection_reason))
            <p style="color:#b71c1c;">
                <strong>Rejection Reason:</strong><br>
                {{ $pastor->rejection_reason }}
            </p>
        @endif

    </div>

</div>

<hr>

<!-- =========================
     ATTACHMENTS
========================= -->
<h3>Attachments</h3>

@php
    $attachments = $pastor->attachments;

    if (is_string($attachments)) {
        $attachments = json_decode($attachments, true);
    }

    if (!is_array($attachments)) {
        $attachments = [];
    }

    $attachments = array_filter($attachments);
@endphp

@if(count($attachments) > 0)

    <div style="display:flex; flex-direction:column; gap:6px;">

        @foreach($attachments as $file)
            <a href="{{ asset('storage/' . $file) }}" target="_blank" style="color:#1976d2;">
                📎 View Attachment
            </a>
        @endforeach

    </div>

@else
    <p style="color:#777;">No attachments uploaded</p>
@endif

<hr>

<!-- ACTIONS -->
<h3>National Decision</h3>

<form method="POST"
      action="{{ route('admin.national.pastoral.approvals.approve', $pastor->id) }}"
      style="display:inline-block;">
    @csrf
    <button style="background:#4CAF50;color:#fff;padding:10px 15px;border:none;border-radius:6px;">
        Approve Pastor
    </button>
</form>

<form method="POST"
      action="{{ route('admin.national.pastoral.approvals.reject', $pastor->id) }}"
      style="display:inline-block;">
    @csrf

    <textarea name="rejection_reason"
              placeholder="Enter rejection reason..."
              required
              style="display:block;width:250px;margin:10px 0;padding:5px;"></textarea>

    <button onclick="return confirm('Reject this pastor?')"
            style="background:#F44336;color:#fff;padding:10px 15px;border:none;border-radius:6px;">
        Reject Pastor
    </button>
</form>

@endsection