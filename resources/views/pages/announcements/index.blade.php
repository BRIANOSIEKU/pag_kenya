@extends('layouts.app')

@section('title', 'Announcements')

@section('content')
<section class="section">
    <!-- Centered Fancy Section Title -->
    <h2 class="section-title mb-6">Latest Announcements</h2>

    @if($announcements->isEmpty())
        <p class="text-center text-gray-600">No announcements available at the moment. Check back later!</p>
    @else
        <div class="news-grid news-grid-spacing">
            @foreach($announcements as $announcement)
                <a href="{{ route('announcements.show', $announcement->id) }}" class="announcement-link">
                    <div class="card">
                        <div class="card-image-wrapper">
                            @if($announcement->photo_path)
                                <img src="{{ Storage::url('announcements/photos/' . $announcement->photo_path) }}" 
                                     alt="{{ $announcement->title }}">
                            @else
                                <img src="{{ asset('images/announcement-placeholder.jpg') }}" 
                                     alt="No Image">
                            @endif
                        </div>
                        <div class="card-content">
                            <h3>{{ $announcement->title }}</h3>
                            <p class="text-sm text-gray-500"><em>Click below to read announcement</em></p>
                            <small class="text-gray-400">{{ $announcement->created_at->format('F j, Y') }}</small>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('announcements.index') }}" class="btn-more">
                More Announcements
            </a>
        </div>
    @endif
</section>

<!-- Styles -->
<style>
/* Centered Fancy Section Title */
.section-title {
    color: #004080; /* dark blue */
    font-size: 2.25rem;
    font-weight: 700;
    position: relative;
    display: block;
    text-align: center; /* center text */
    cursor: default;
    margin: 0 auto;
}

/* Underline */
.section-title::after {
    content: "";
    display: block;
    width: 40px; /* initial width */
    height: 4px;
    background-color: orange;
    border-radius: 2px;
    margin: 8px auto 0; /* center underline */
    transition: width 0.4s ease;
}

/* Hover Effect on underline */
.section-title:hover::after {
    width: 80px;
}

/* Grid */
.news-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 20px;
    justify-items: center;
    padding: 0 10px;
}

/* Add extra top margin to push cards down slightly from the title */
.news-grid-spacing {
    margin-top: 20px; /* adjust this value to move cards down more/less */
}

@media (min-width: 480px) {
    .news-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (min-width: 768px) {
    .news-grid { grid-template-columns: repeat(3, 1fr); }
}
@media (min-width: 1024px) {
    .news-grid { grid-template-columns: repeat(4, 1fr); }
}

/* Card */
.card {
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    width: 100%;
    max-width: 320px;
    text-align: center;
    overflow: hidden;
    transition: transform 0.3s, box-shadow 0.3s;
    cursor: pointer;
}

/* Card hover effect: shadow + slight lift */
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.25);
}

/* Wrapper for image hover zoom */
.card-image-wrapper {
    overflow: hidden; /* ensures zoom doesn't spill outside card */
}

.card-image-wrapper img {
    height: 160px; /* zoomed in a bit for better focus */
    width: 100%;
    object-fit: cover;
    object-position: center top;
    border-bottom: 1px solid #ddd;
    display: block;
    transition: transform 0.4s ease; /* smooth zoom on hover */
}

/* Zoom image on card hover */
.card:hover .card-image-wrapper img {
    transform: scale(1.05); /* slightly enlarges the image */
}

/* Card content */
.card-content {
    padding: 16px;
}

.card-content h3 {
    margin-bottom: 8px;
    font-size: 1.2rem;
    font-weight: 600;
    color: #222;
}

/* Button */
.btn-more {
    display: inline-block;
    padding: 10px 20px;
    background: var(--main-blue);
    color: #fff;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 500;
    transition: background 0.3s;
}

.btn-more:hover {
    background: #005f8a;
}

.announcement-link {
    text-decoration: none;
    color: inherit;
}
</style>
@endsection