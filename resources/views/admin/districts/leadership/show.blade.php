@extends('layouts.admin')

@section('content')

<div style="max-width: 800px; margin: auto; background: #fff; padding: 20px; border-radius: 10px;">

    <h2 style="margin-bottom: 20px;">Leader Profile</h2>

    <!-- BASIC DETAILS -->
    <p><strong>Name:</strong> {{ $leader->name }}</p>

    <p>
        <strong>Position:</strong> 
        <span style="color:#003366; font-weight:600;">
            {{ $leader->position ?? 'N/A' }}
        </span>
    </p>

    <p><strong>Gender:</strong> {{ $leader->gender }}</p>
    <p><strong>Contact:</strong> {{ $leader->contact }}</p>
    <p><strong>National ID:</strong> {{ $leader->national_id }}</p>

    <p><strong>Date of Birth:</strong> {{ \Carbon\Carbon::parse($leader->dob)->format('d M Y') }}</p>

    {{-- ================= AGE CALCULATION ================= --}}
    <p>
        <strong>Age:</strong>
        {{ \Carbon\Carbon::parse($leader->dob)->age }} years
    </p>

    <hr style="margin: 20px 0;">

    {{-- ================= BANK DETAILS ================= --}}
    <h3>Bank Details</h3>

    <p><strong>Bank Name:</strong> {{ $leader->bank_name ?? 'N/A' }}</p>
    <p><strong>Branch:</strong> {{ $leader->bank_branch ?? 'N/A' }}</p>
    <p><strong>Account Number:</strong> {{ $leader->account_number ?? 'N/A' }}</p>

    <hr style="margin: 20px 0;">

    <!-- PHOTO -->
    <h3>Photo</h3>

    @if($leader->photo)
        <img 
            src="{{ asset('storage/' . $leader->photo) }}" 
            alt="Leader Photo"
            style="width: 150px; height: 150px; object-fit: cover; border-radius: 10px; border: 1px solid #ddd;"
        >
    @else
        <p>No photo uploaded.</p>
    @endif

    <hr style="margin: 20px 0;">

    <!-- ATTACHMENTS -->
    <h3>Attachments</h3>

    @if(!empty($leader->attachments))

        <ul style="list-style: none; padding: 0;">

            @foreach($leader->attachments as $file)
                <li style="margin-bottom: 10px; padding: 8px; border: 1px solid #eee; border-radius: 6px;">

                    <a href="{{ asset('storage/' . $file) }}" target="_blank" style="color: #1a73e8; font-weight: 500;">
                        📎 View Credential
                    </a>

                    <div style="font-size: 12px; color: #666;">
                        {{ basename($file) }}
                    </div>

                </li>
            @endforeach

        </ul>

    @else
        <p>No Credentials uploaded.</p>
    @endif

</div>

@endsection