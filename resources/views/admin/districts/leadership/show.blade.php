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
    <p><strong>Date of Birth:</strong> {{ $leader->dob }}</p>

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

    @php
        $attachments = is_array($leader->attachments) ? $leader->attachments : json_decode($leader->attachments, true);
    @endphp

    @if(!empty($attachments) && count($attachments) > 0)

        <ul style="list-style: none; padding: 0;">

            @foreach($attachments as $file)
                <li style="margin-bottom: 10px; padding: 8px; border: 1px solid #eee; border-radius: 6px;">

                    <a href="{{ asset('storage/' . $file) }}" target="_blank" style="color: #1a73e8; font-weight: 500;">
                        📎 View Credentials
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