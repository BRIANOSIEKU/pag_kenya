@extends('layouts.admin')

@section('content')

<style>
.container {
    max-width: 900px;
    margin: auto;
    padding: 20px;
}

.btn {
    display: inline-block;
    padding: 8px 12px;
    border-radius: 6px;
    color: #fff;
    text-decoration: none;
    font-size: 14px;
    font-weight: bold;
}

.btn-primary { background: #2196F3; }

.card {
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.gallery {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 15px;
}

.gallery-item {
    flex: 1 1 150px;
    max-width: 150px;
}

.gallery-item img {
    width: 100%;
    height: auto;
    border-radius: 6px;
    border: 1px solid #ddd;
}
</style>

<div class="container">

    <!-- BACK BUTTON -->
    <a href="{{ route('admin.news.index') }}" class="btn btn-primary" style="margin-bottom:15px;">
        ← Back to News
    </a>

    <!-- NEWS CARD -->
    <div class="card">

        <!-- TITLE -->
        <h2 style="margin-bottom:10px;">{{ $news->title }}</h2>

        <!-- GALLERY -->
        @if($news->photos && $news->photos->count() > 0)
            <div class="gallery">
                @foreach($news->photos as $photo)
                    <div class="gallery-item">
                        <img src="{{ asset('uploads/news/' . $photo->image) }}" alt="News Photo">
                    </div>
                @endforeach
            </div>
        @endif

        <!-- CONTENT -->
        <p style="line-height:1.6; font-size:15px;">
            {{ $news->content }}
        </p>

        <!-- DATE -->
        <p style="margin-top:15px; color:#777; font-size:13px;">
            Posted on {{ $news->created_at->format('d M Y') }}
        </p>

    </div>

</div>

@endsection