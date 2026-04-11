@extends('layouts.district_admin')

@section('content')

<h2>Pastoral Profile</h2>

<!-- BACK BUTTON -->
<a href="{{ route('district.admin.pastoral.index') }}"
   style="padding:8px 12px;background:#607D8B;color:#fff;border-radius:6px;text-decoration:none;display:inline-block;margin-bottom:15px;">
    ← Back
</a>

<div style="display:flex; gap:20px;">

    <!-- PHOTO -->
    <div>
        @if($pastor->photo)
            <img src="{{ asset('storage/'.$pastor->photo) }}"
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
        <p><strong>Assembly:</strong> {{ $pastor->assembly->name ?? 'N/A' }}</p>
        <p><strong>Contact:</strong> {{ $pastor->contact }}</p>
        <p><strong>Gender:</strong> {{ $pastor->gender }}</p>
        <p><strong>Graduation Year:</strong> {{ $pastor->graduation_year }}</p>
        <p><strong>Date of Birth:</strong> {{ $pastor->date_of_birth }}</p>

    </div>

</div>

<hr>

<h3>Attachments</h3>

@if($pastor->attachments)
    @foreach(json_decode($pastor->attachments, true) as $file)
        <a href="{{ asset('storage/'.$file) }}" target="_blank">
            View Credentials
        </a><br>
    @endforeach
@else
    <p>No attachments uploaded</p>
@endif

@endsection