@extends('layouts.district_admin')

@section('content')

<div style="max-width: 800px; margin: auto; background: #fff; padding: 20px; border-radius: 10px;">

    <h2 style="margin-bottom: 20px;">Assembly Leader Profile</h2>

    <p><strong>Name:</strong> {{ $leader->name }}</p>

    <p>
        <strong>Position:</strong>
        <span style="color:#003366; font-weight:600;">
            {{ $leader->position }}
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
        <img src="{{ asset('storage/' . $leader->photo) }}"
             style="width:150px;height:150px;object-fit:cover;border-radius:10px;">
    @else
        <p>No photo uploaded.</p>
    @endif

    <hr style="margin: 20px 0;">

    <!-- ATTACHMENTS -->
    <h3>Attachments</h3>

    @php
        $attachments = $leader->attachments ? json_decode($leader->attachments, true) : [];
    @endphp

    @if(!empty($attachments))
        <ul style="list-style:none;padding:0;">

            @foreach($attachments as $file)
                <li style="margin-bottom:10px;">
                    <a href="{{ asset('storage/' . $file) }}" target="_blank">
                        📎 View File
                    </a>
                    <div style="font-size:12px;color:#666;">
                        {{ basename($file) }}
                    </div>
                </li>
            @endforeach

        </ul>
    @else
        <p>No attachments uploaded.</p>
    @endif

</div>

@endsection