@extends('layouts.admin')

@section('content')

<style>
.container {
    max-width: 900px;
    margin: auto;
    padding: 15px;
}

/* HEADER */
.header {
    margin-bottom: 20px;
}

/* BACK BUTTON */
.btn-back {
    background: #607D8B;
    color: white;
    padding: 8px 12px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 13px;
    font-weight: bold;
    display: inline-block;
    margin-bottom: 15px;
}
.btn-back:hover {
    opacity: 0.85;
}

/* CARD */
.card {
    background: #fff;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
}

/* TITLE */
.title {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 10px;
}

/* META INFO */
.meta {
    color: #777;
    font-size: 14px;
    margin-bottom: 15px;
}

/* IMAGE */
.thumbnail {
    width: 100%;
    max-height: 400px;
    object-fit: cover;
    border-radius: 10px;
    margin-bottom: 15px;
}

/* CONTENT */
.content {
    line-height: 1.6;
    white-space: pre-line;
    font-size: 15px;
}

/* RESPONSIVE */
@media(max-width:768px){
    .title {
        font-size: 20px;
    }
}
</style>

<div class="container">

    <!-- HEADER -->
    <div class="header">
        <a href="{{ route('admin.devotions.index') }}" class="btn-back">
            ← Back to Devotions
        </a>
    </div>

    <!-- CARD -->
    <div class="card">

        <!-- TITLE -->
        <div class="title">
            {{ $devotion->title }}
        </div>

        <!-- META -->
        <div class="meta">
            <strong>Author:</strong> {{ $devotion->author }} |
            <strong>Date:</strong> {{ \Carbon\Carbon::parse($devotion->date)->format('M d, Y') }}
        </div>

        <!-- IMAGE -->
        @if($devotion->thumbnail)
            <img src="{{ asset($devotion->thumbnail) }}" alt="Thumbnail" class="thumbnail">
        @endif

        <!-- CONTENT -->
        <div class="content">
            {{ $devotion->content }}
        </div>

    </div>

</div>

@endsection