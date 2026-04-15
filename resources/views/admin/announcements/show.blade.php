@extends('layouts.admin')

@section('content')

<style>
    .container-box {
        max-width: 800px;
        margin: auto;
        padding: 20px;
    }

    .btn {
        display: inline-block;
        padding: 8px 14px;
        border-radius: 6px;
        text-decoration: none;
        color: #fff;
        font-weight: bold;
        transition: 0.2s;
    }

    .btn:hover {
        opacity: 0.85;
    }

    .btn-back {
        background: #9E9E9E;
        margin-bottom: 15px;
    }

    .card {
        border: 1px solid #ddd;
        border-radius: 8px;
        background: #f9f9f9;
        padding: 20px;
    }

    .section-title {
        font-weight: bold;
        margin-top: 15px;
        margin-bottom: 5px;
    }

    img, video {
        border-radius: 6px;
        margin-top: 10px;
    }

    a.file-link {
        color: #FF5722;
        font-weight: bold;
        text-decoration: none;
    }

    a.file-link:hover {
        text-decoration: underline;
    }
</style>

<div class="container-box">

    <h2>View Announcement</h2>

    <a href="{{ route('admin.announcements.index') }}" class="btn btn-back">
        ← Back to List
    </a>

    <div class="card">

        <!-- Title -->
        <h3>{{ $announcement->title }}</h3>

        <!-- Type -->
        <p><strong>Type:</strong> {{ ucfirst($announcement->type) }}</p>

        <!-- Description -->
        <div class="section-title">Description</div>
        <p>{{ $announcement->description }}</p>

        <!-- Photo -->
        @if($announcement->photo)
            <div class="section-title">Photo</div>
            <img src="{{ asset('storage/announcements/photos/'.$announcement->photo) }}" 
                 alt="Announcement Photo" style="max-width:100%;">
        @endif

        <!-- File / Video -->
        @if($announcement->file)

            @if($announcement->type == 'video')
                <div class="section-title">Video</div>
                <video width="100%" controls>
                    <source src="{{ asset('storage/announcements/files/'.$announcement->file) }}" type="video/mp4">
                    Your browser does not support HTML video.
                </video>

            @elseif($announcement->type == 'document')
                <div class="section-title">Document</div>
                <a class="file-link"
                   href="{{ asset('storage/announcements/files/'.$announcement->file) }}" 
                   target="_blank">
                    View Document
                </a>
            @endif

        @endif

    </div>

</div>

@endsection