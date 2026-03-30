@extends('layouts.app')

@section('content')
<div style="max-width:800px; margin:20px auto; padding:15px;">

    <!-- Constant Heading -->
    <h1 style="text-align:center; color:#0D47A1; font-weight:700; font-size:2rem; position:relative; margin-bottom:40px;">
        ANNOUNCEMENTS
        <span style="display:block; width:60px; height:4px; background:#0D47A1; margin:10px auto 0; border-radius:2px;"></span>
    </h1>

    <!-- Announcement Title -->
    <h2 style="margin-bottom:10px; font-size:1.75rem; text-align:center;">{{ $announcement->title }}</h2>

    <!-- Video -->
    @if($announcement->video_path)
        <div style="margin:25px 0; display:flex; justify-content:center;">
            <video controls 
                   style="width:100%; max-width:600px; border-radius:6px; height:auto;">
                <source src="{{ $announcement->video_path }}" type="video/mp4">
                Your browser does not support HTML5 video.
            </video>
        </div>
    @endif

    <!-- Document -->
    @if($announcement->document_path)
        <div style="margin:25px 0;">
            <iframe src="{{ $announcement->document_path }}" 
                    style="width:100%; height:600px; border:1px solid #ccc; border-radius:6px;">
            </iframe>
            <p style="text-align:center; margin-top:10px;">
                <a href="{{ $announcement->document_path }}" target="_blank" 
                   style="color:#0D47A1; text-decoration:underline; font-weight:500;">
                   Download Document
                </a>
            </p>
        </div>
    @endif

    <!-- Description -->
    <p style="margin-top:25px; font-size:1rem; line-height:1.6;">
        {!! nl2br(e($announcement->description)) !!}
    </p>

    <!-- Published Date -->
    <p style="color:#777; font-size:0.9rem; margin-top:20px; text-align:right;">
        Published on: {{ $announcement->created_at->format('F d, Y') }}
    </p>

</div>
@endsection