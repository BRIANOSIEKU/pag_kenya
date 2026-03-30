@extends('layouts.admin')

@section('content')
<h2>View Announcement</h2>

<a href="{{ route('admin.announcements.index') }}"
   style="background-color:#9E9E9E; color:#fff; padding:8px 16px; border-radius:6px; font-weight:bold; text-decoration:none; display:inline-block; margin-bottom:15px;">
   ← Back to List
</a>

<div style="max-width:700px; border:1px solid #ddd; padding:20px; border-radius:6px; background-color:#f9f9f9;">

    <!-- Title -->
    <h3>{{ $announcement->title }}</h3>

    <!-- Type -->
    <p><strong>Type:</strong> {{ ucfirst($announcement->type) }}</p>

    <!-- Description -->
    <p><strong>Description:</strong></p>
    <p>{{ $announcement->description }}</p>

    <!-- Photo -->
    @if($announcement->photo)
        <div style="margin-top:15px;">
            <p><strong>Photo:</strong></p>
            <img src="{{ asset('storage/announcements/photos/'.$announcement->photo) }}" 
                 alt="Announcement Photo" style="max-width:100%; border-radius:6px;">
        </div>
    @endif

    <!-- File / Video -->
    @if($announcement->file)
        @if($announcement->type == 'video')
            <div style="margin-top:15px;">
                <p><strong>Video:</strong></p>
                <video width="100%" controls>
                    <source src="{{ asset('storage/announcements/files/'.$announcement->file) }}" type="video/mp4">
                    Your browser does not support HTML video.
                </video>
            </div>
        @elseif($announcement->type == 'document')
            <div style="margin-top:15px;">
                <p><strong>Document:</strong></p>
                <a href="{{ asset('storage/announcements/files/'.$announcement->file) }}" target="_blank" 
                   style="color:#FF5722; font-weight:bold;">
                    View Document
                </a>
            </div>
        @endif
    @endif

</div>
@endsection