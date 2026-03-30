@extends('layouts.app')

@section('title', 'Home')

@section('content')

<style>
:root {
    --main-blue: #007BB8;
    --dark-brown: #4B2E2E;
    --pure-white: #FFFFFF;
    --black: #000000;
    --accent-yellow: #FFD700;
    --ticker-brown: #4B2E2E; /* brown color for ticker text */
}

/* --- Global --- */
body {
    font-family: 'Inter', sans-serif;
    margin: 0;
    padding: 0;
    background-color: var(--pure-white);
    color: var(--black);
}

/* --- Hero Section --- */
.hero {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    background-image:;
    background-size: cover;
    background-position: center;
    position: relative;
    color: var(--pure-white);
    overflow: hidden;
    padding: 40px 20px;
    min-height: 70vh; /* desktop visibility */
}

.hero-content {
    position: relative;
    z-index: 1;
    max-width: 900px;
}
.hero h1 {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 15px;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.7);
    white-space: nowrap;
}
.hero p {
    font-size: 1rem;
    font-style: italic;
    color: var(--accent-yellow);
    margin-bottom: 20px;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
}

/* --- Hero Ticker --- */
.hero-ticker {
    position: relative;
    z-index: 3;
    width: 90%;
    max-width: 900px;
    overflow: hidden;
    white-space: nowrap;
    margin: 5px auto 25px auto;
    border-radius: 50px;
    background: linear-gradient(90deg, #075b8b, #8B4513);
    box-shadow: 0 5px 20px rgba(0,0,0,0.3);
    padding: 10px 20px;
    font-size: 1.1rem;
    font-weight: 600;
    color: #FFD700;
    text-shadow: 1px 1px 3px rgba(0,0,0,0.5);
}
.hero-ticker span {
    display: inline-block;
    padding-right: 60px;
    animation: scroll-left 20s linear infinite;
}
@keyframes scroll-left {
    0% { transform: translateX(100%); }
    100% { transform: translateX(-100%); }
}

.scroll-down {
    font-size: 2rem;
    color: var(--pure-white);
    animation: bounce 2s infinite;
    cursor: pointer;
}
@keyframes bounce {
    0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
    40% { transform: translateY(10px); }
    60% { transform: translateY(5px); }
}

/* --- Section --- */
.section {
    padding: 40px 20px;
    max-width: 1100px;
    margin: 0 auto;
    text-align: center;
}
.section h2 {
    font-size: 1.7rem;
    margin-bottom: 30px;
    position: relative;
    display: inline-block;
    color: var(--main-blue);
    font-weight: 700;
}
.section h2::after {
    content: '';
    position: absolute;
    left: 50%;
    bottom: -6px;
    transform: translateX(-50%) scaleX(1);
    width: 20vw;
    max-width: 120px;
    height: 4px;
    background-color: #FF6F00;
    border-radius: 2px;
}

/* --- News Grid --- */
.news-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 20px;
    justify-items: center;
}
@media (min-width: 480px) {
    .news-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (min-width: 768px) {
    .news-grid { grid-template-columns: repeat(4, 1fr); }
}

/* --- Cards --- */
.card {
    background-color: var(--pure-white);
    border-radius: 12px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    width: 100%;
    max-width: 350px;
    text-align: center;
    overflow: hidden;
    transition: transform 0.3s, box-shadow 0.3s;
}
.card img {
    width: 100%;
    height: 160px;
    object-fit: cover;
}
.card h3 {
    color: var(--dark-brown);
    margin: 15px 10px 10px;
    font-size: 1.1rem;
}
.card p {
    color: var(--black);
    font-size: 0.9rem;
    padding: 0 10px 15px;
}
.card small {
    color: #555;
    font-size: 0.85rem;
}
.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
}

/* --- Departments --- */
.department-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    width: 100%;
    max-width: 320px;
    margin-bottom: 20px;
}
.department-card img {
    width: 100%;
    height: 180px;
    object-fit: cover;
}
.department-card h3 {
    font-size: 1.1rem;
    color: #0f3c78;
    margin: 10px 0 5px;
}
.department-card p {
    font-size: 0.9rem;
    color: #555;
    margin: 5px 0;
    line-height: 1.4;
}
.department-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 20px;
    justify-items: center;
}

/* --- Contact Links Animation --- */
.underline-center {
    position: relative;
    color: var(--main-blue);
    text-decoration: none;
}
.underline-center::after {
    content: '';
    position: absolute;
    left: 50%;
    bottom: -2px;
    transform: translateX(-50%) scaleX(0);
    transform-origin: center;
    width: 100%;
    height: 2px;
    background-color: var(--dark-brown);
    border-radius: 1px;
    transition: transform 0.3s ease;
}
.underline-center:hover::after {
    transform: translateX(-50%) scaleX(1);
}

/* --- Responsive --- */
@media (min-width: 480px) {
    .hero h1 { font-size: 2.5rem; }
    .hero p { font-size: 1.1rem; }
    .section h2 { font-size: 1.9rem; }
    .department-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (min-width: 768px) {
    .department-grid { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 767px) {
    .hero { min-height: 50vw; background-size: cover; background-position: center; }
    .hero h1 { font-size: 1.5rem; }
}
@media (max-width: 480px) {
    .hero { min-height: 60vw; }
    .hero h1 { font-size: 1.3rem; }
    .news-grid { grid-template-columns: 1fr; }
    .department-grid { grid-template-columns: 1fr; }
}
</style>

<!-- Hero Section -->
<!-- ================= HERO SECTION ================= -->
<section class="hero">

    <!-- Slider Wrapper -->
    <div class="hero-slider-wrapper">
        <div class="hero-slider" id="hero-slider">
            @foreach($heroSlides as $slide)
                <div class="slide" style="background-image: url('{{ asset('storage/' . $slide->image) }}');">
                    <div class="overlay"></div>

                    <!-- Hero Content -->
                    <div class="hero-content">

                        <!-- Desktop Ticker -->
                        <div class="hero-ticker desktop-ticker">
                            <span>
                                Theme of the Year: {{ $homeSetting->theme ?? 'MOUNTING UP!' }}
                            </span>
                            <span>
                                Scripture of the Year: {{ $homeSetting->scripture ?? 'ISAIAH 40:31' }}
                            </span>
                        </div>

                        <!-- Slide Title -->
                        <h1 class="slide-title">{{ $homeSetting->hero_heading ?? 'WELCOME TO PAG - K' }}</h1>

                        <!-- Slide Caption -->
                        <p class="slide-caption">{{ $homeSetting->hero_subtext ?? 'The Home of Pentecostalism' }}</p>

                        <!-- Scroll Down Indicator -->
                        <div class="scroll-down">&#x25BC;</div>

                    </div>
                </div>
            @endforeach
        </div>

        <!-- Navigation Arrows -->
        <button class="slider-arrow prev" id="prev-slide">&#10094;</button>
        <button class="slider-arrow next" id="next-slide">&#10095;</button>

        <!-- Slide Indicators (Dots) -->
        <div class="slider-dots" id="slider-dots">
            @foreach($heroSlides as $slide)
                <span class="dot @if($loop->first) active @endif"></span>
            @endforeach
        </div>
    </div>

    <!-- Mobile Ticker (Static, below slider) -->
    <div class="hero-ticker mobile-ticker">
        <span>Theme of the Year: {{ $homeSetting->theme ?? 'MOUNTING UP!' }}</span>
        <span>Scripture of the Year: {{ $homeSetting->scripture ?? 'ISAIAH 40:31' }}</span>
    </div>

</section>

<style>
/* --- Hero Slider --- */
.hero-slider-wrapper {
    width: 100%;
    height: 90vh;
    overflow: hidden;
    position: relative;
}

.hero-slider {
    display: flex;
    width: 100%;
    height: 100%;
    transition: transform 0.7s ease-in-out;
}

.hero-slider .slide {
    min-width: 100%;
    height: 100%;
    position: relative;
    background-size: cover;
    background-position: center 35%;
    background-repeat: no-repeat;
    flex-shrink: 0;
}

.hero-slider .slide .overlay {
    position: absolute;
    top:0; left:0;
    width:100%; height:100%;
    background: linear-gradient(
        to bottom,
        rgba(0,0,0,0.75) 0%,
        rgba(0,0,0,0.45) 40%,
        rgba(0,0,0,0.6) 100%
    );
    z-index: 0;
}

.hero-slider .slide .hero-content {
    position: relative;
    z-index: 2;
    max-width: 900px;
    text-align: center;
    margin: auto;
    top: 50%;
    transform: translateY(-50%);
    color: #fff;
    padding: 0 20px;
}

/* Fade-in animation for text */
.slide-title {
    font-size: 3rem;
    opacity: 0;
    transform: translateY(20px);
    animation: fadeInText 1s forwards;
}

.slide-caption {
    font-size: 1.2rem;
    margin-top: 10px;
    opacity: 0;
    transform: translateY(20px);
    animation: fadeInText 1s forwards;
    animation-delay: 0.5s;
}

@keyframes fadeInText {
    to { opacity: 1; transform: translateY(0); }
}

/* Arrows */
.slider-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(0,0,0,0.4);
    border: none;
    color: #fff;
    font-size: 2rem;
    padding: 10px 15px;
    cursor: pointer;
    border-radius: 50%;
    z-index: 5;
    transition: background 0.3s;
}
.slider-arrow:hover { background: rgba(0,0,0,0.7); }
.slider-arrow.prev { left: 20px; }
.slider-arrow.next { right: 20px; }

/* Dots */
.slider-dots {
    position: absolute;
    bottom: 15px;
    width: 100%;
    display: flex;
    justify-content: center;
    gap: 8px;
    z-index: 5;
}

.slider-dots .dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: rgba(2, 60, 114, 0.5);
    cursor: pointer;
    transition: background 0.3s;
}

.slider-dots .dot.active { background: #FFD700; }

/* ===== Ticker Style ===== */
.hero-ticker {
    width: 90%;
    max-width: 900px;
    margin: 15px auto;
    border-radius: 50px;
    background: linear-gradient(90deg, #075b8b, #8B4513);
    box-shadow: 0 5px 20px rgba(4, 80, 116, 0.3);
    padding: 8px 20px;
    font-size: 1rem;
    font-weight: 600;
    color: #FFD700;
    text-shadow: 1px 1px 3px rgba(0,0,0,0.5);
    text-align: center;
}

/* Static ticker spans (no scroll) */
.hero-ticker span {
    display: inline-block;
    padding: 0 15px;
}

/* Desktop ticker spacing */
.desktop-ticker { margin-bottom: 25px; }

/* Hide mobile ticker on desktop */
.mobile-ticker { display: none; }

/* ===== Desktop View ===== */
@media (min-width: 1025px) {
    .desktop-ticker { display: block; }
    .mobile-ticker { display: none; }
}

/* ===== Mobile View ===== */
@media (max-width: 1024px) {
    .desktop-ticker { display: none; }
    .mobile-ticker { display: block; }

    .hero-slider-wrapper { height: 75vw; width:110%; }

    .slide-title { font-size: 2rem; }
    .slide-caption { font-size: 1rem; }

    /* Keep hero content centered */
    .hero-slider .slide .hero-content {
        top: 50%;
        transform: translateY(-50%);
    }

    /* Add spacing below slider for mobile ticker */
    .mobile-ticker { margin-top: 15px; }
}
</style>

<script>
// ================== Hero Slider JS ==================
const slides = document.querySelectorAll('#hero-slider .slide');
const prevBtn = document.getElementById('prev-slide');
const nextBtn = document.getElementById('next-slide');
const dots = document.querySelectorAll('#slider-dots .dot');

let currentIndex = 0;
let slideInterval = setInterval(nextSlide, 5000);

function showSlide(index) {
    const slider = document.getElementById('hero-slider');

    if(index >= slides.length) index = 0;
    if(index < 0) index = slides.length - 1;

    slider.style.transform = `translateX(-${index * 100}%)`;
    currentIndex = index;
    updateDots();
}

function nextSlide() { showSlide(currentIndex + 1); }
function prevSlide() { showSlide(currentIndex - 1); }

function updateDots() {
    dots.forEach(dot => dot.classList.remove('active'));
    dots[currentIndex].classList.add('active');
}

nextBtn.addEventListener('click', () => { nextSlide(); resetInterval(); });
prevBtn.addEventListener('click', () => { prevSlide(); resetInterval(); });

dots.forEach((dot, i) => {
    dot.addEventListener('click', () => {
        showSlide(i);
        resetInterval();
    });
});

function resetInterval() {
    clearInterval(slideInterval);
    slideInterval = setInterval(nextSlide, 5000);
}

showSlide(0);
</script>
<!-- Latest Announcements Section -->
<section class="section">
    <h2>Latest Announcements</h2>

    @if($announcements->isEmpty())
        <p>No announcements available at the moment. Check back later!</p>
    @else
        <div class="news-grid">
            @foreach($announcements as $announcement)
                <a href="{{ route('announcements.show', $announcement->id) }}" style="text-decoration:none; color:inherit;">
                    <div class="card">
                        @if($announcement->photo_path)
                            <img src="{{ asset('storage/announcements/photos/' . $announcement->photo_path) }}" 
                                 alt="{{ $announcement->title }}"
                                 style="height: 180px; object-fit: cover; object-position: top; width: 100%;">
                        @else
                            <img src="{{ asset('images/announcement-placeholder.jpg') }}" 
                                 alt="No Image"
                                 style="height: 180px; object-fit: cover; object-position: top; width: 100%;">
                        @endif
                        <div class="p-4">
                            <h3 style="margin-bottom: 8px;">{{ $announcement->title }}</h3>
                            <p style="margin-bottom: 8px;"><em>Click below to read announcement</em></p>
                            <small>{{ $announcement->created_at->format('F j, Y') }}</small>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div style="margin-top:30px; text-align:center;">
            <a href="{{ route('announcements.index') }}" 
               style="padding:10px 20px; background: var(--main-blue); color:#fff; border-radius:6px; text-decoration:none;">
                More Announcements
            </a>
        </div>
    @endif
</section>

<!-- Responsive Styles -->
<style>
.news-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 20px;
    justify-items: center;
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

.card {
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    width: 100%;
    max-width: 320px;
    text-align: center;
    overflow: hidden;
    transition: transform 0.3s, box-shadow 0.3s;
}

.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
}

.card img {
    border-bottom: 1px solid #ddd;
    display: block;
}
</style>
{{-- ================= PREMIUM LIVE STREAM SECTION ================= --}}
@if($liveStream)

@php
    $videoId = null;

    if($liveStream->type === 'youtube') {
        if(str_contains($liveStream->url, 'watch?v=')) {
            $videoId = explode('watch?v=', $liveStream->url)[1];
        } elseif(str_contains($liveStream->url, 'youtu.be/')) {
            $videoId = explode('youtu.be/', $liveStream->url)[1];
        }
    }
@endphp

<section id="live-section" class="live-section">

    <div class="live-container">

        <div class="live-header">
            <span class="live-dot"></span>
            <h2>We Are Live Now</h2>
        </div>

        <div class="live-card">

            @if($liveStream->logo)
                <img src="{{ asset('storage/' . $liveStream->logo) }}"
                     class="live-logo"
                     alt="{{ $liveStream->title }}">
            @endif

            <h3>{{ $liveStream->title }}</h3>

            @if($liveStream->description)
                <p class="live-description">
                    {{ $liveStream->description }}
                </p>
            @endif

            {{-- Viewer Counter (YouTube only) --}}
            @if($liveStream->type === 'youtube' && $videoId)
                <p id="viewer-count" class="viewer-count">
                    Checking live viewers...
                </p>
            @endif

            <div class="live-player">

                {{-- YouTube --}}
                @if($liveStream->type === 'youtube' && $videoId)
                    <iframe width="100%" height="450"
                        src="https://www.youtube.com/embed/{{ $videoId }}"
                        frameborder="0"
                        allow="autoplay; encrypted-media"
                        allowfullscreen>
                    </iframe>

                {{-- Facebook --}}
                @elseif($liveStream->type === 'facebook')
                    <iframe
                        src="https://www.facebook.com/plugins/video.php?href={{ urlencode($liveStream->url) }}"
                        width="100%" height="450"
                        style="border:none;overflow:hidden"
                        scrolling="no"
                        frameborder="0"
                        allowfullscreen>
                    </iframe>

                {{-- Radio --}}
                @elseif($liveStream->type === 'radio')
                    <audio controls  style="width:100%;">
                        <source src="{{ $liveStream->url }}">
                        Your browser does not support the audio element.
                    </audio>

                {{-- Fallback --}}
                @else
                    <a href="{{ $liveStream->url }}" target="_blank" class="live-btn">
                        Watch Live
                    </a>
                @endif

            </div>

        </div>
    </div>
</section>

{{-- Floating LIVE Button --}}
<a href="#live-section" class="floating-live-btn">
    <span class="pulse-dot"></span>
    LIVE
</a>

{{-- ================= STYLES ================= --}}
<style>

.live-section {
    background: linear-gradient(135deg, #ffffff, #ffffff);
    padding: 80px 20px;
    text-align: center;
    color: #010369;
}

.live-container {
    max-width: 1000px;
    margin: auto;
}

.live-header {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
    margin-bottom: 30px;
}

.live-dot {
    width: 14px;
    height: 14px;
    background: red;
    border-radius: 50%;
    animation: pulse 1.5s infinite;
}

@keyframes pulse {
    0% { box-shadow: 0 0 0 0 rgba(255,0,0,0.7); }
    70% { box-shadow: 0 0 0 15px rgba(255,0,0,0); }
    100% { box-shadow: 0 0 0 0 rgba(255,0,0,0); }
}

.live-card {
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(12px);
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 10px 35px rgba(0,0,0,0.4);
}

.live-logo {
    width: 120px;
    margin-bottom: 15px;
    border-radius: 12px;
}

.live-card h3 {
    font-size: 1.6rem;
    margin-bottom: 10px;
}

.live-description {
    color: #032a4e;
    margin-bottom: 15px;
}

.viewer-count {
    color: #FFD700;
    font-weight: bold;
    margin-bottom: 20px;
}

.live-player iframe,
.live-player audio {
    border-radius: 12px;
}

.live-btn {
    display: inline-block;
    padding: 12px 25px;
    background: #FFD700;
    color: black;
    font-weight: bold;
    border-radius: 8px;
    text-decoration: none;
}

/* Floating Button */
.floating-live-btn {
    position: fixed;
    right: 20px;
    bottom: 30px;
    background: red;
    color: white;
    padding: 12px 20px;
    border-radius: 50px;
    font-weight: bold;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.3);
    z-index: 999;
    animation: floatGlow 2s infinite;
}

.pulse-dot {
    width: 10px;
    height: 10px;
    background: white;
    border-radius: 50%;
}

@keyframes floatGlow {
    0% { box-shadow: 0 0 0 0 rgba(255,0,0,0.7); }
    70% { box-shadow: 0 0 0 15px rgba(255,0,0,0); }
    100% { box-shadow: 0 0 0 0 rgba(255,0,0,0); }
}

@media (max-width: 768px) {
    .live-player iframe {
        height: 300px;
    }
}

</style>

{{-- ================= SCRIPTS ================= --}}
<script>

document.addEventListener("DOMContentLoaded", function() {

    // Auto-scroll


    @if($liveStream->type === 'youtube' && $videoId)
        // YouTube Viewer Counter
        async function fetchViewerCount() {
            const apiKey = "{{ config('services.youtube.key') }}";
            const videoId = "{{ $videoId }}";

            try {
                const response = await fetch(
                    `https://www.googleapis.com/youtube/v3/videos?part=liveStreamingDetails&id=${videoId}&key=${apiKey}`
                );

                const data = await response.json();

                if(data.items.length > 0) {
                    const viewers = data.items[0].liveStreamingDetails?.concurrentViewers;
                    document.getElementById("viewer-count").innerText =
                        viewers ? viewers + " people watching live" : "Live Now";
                }
            } catch (error) {
                console.log("Viewer count error", error);
            }
        }

        fetchViewerCount();
        setInterval(fetchViewerCount, 30000);
    @endif

});

</script>

@endif
{{-- ================= END LIVE STREAM SECTION ================= --}}

<!-- News Section -->
<section class="section">
    <h2>News & Updates</h2>

    @if($news->isEmpty())
        <p>No news available at the moment. Check back later!</p>
    @else
        <div class="news-grid">
            @foreach($news as $item)
                <a href="{{ route('news.show', $item->id) }}" style="text-decoration:none; color:inherit;">
                    <div class="card">
                        <img src="{{ $item->photos->first() ? asset('uploads/news/' . $item->photos->first()->image) : asset('images/news-placeholder.jpg') }}" 
                             alt="{{ $item->title }}">
                        <h3>{{ $item->title }}</h3>
                        <p>{{ \Illuminate\Support\Str::limit($item->excerpt ?? $item->content, 80) }}</p>
                        <small>{{ $item->created_at->format('F j, Y') }}</small>
                    </div>
                </a>
            @endforeach
        </div>

        <div style="margin-top:20px; text-align:center;">
            <a href="{{ route('news.index') }}" style="padding:10px 20px; background: var(--main-blue); color:#fff; border-radius:6px; text-decoration:none;">
                More News
            </a>
        </div>
    @endif
</section>

<!-- Key Departments -->
<!-- Key Departments -->
<section class="section" id="departments" style="background:#f9f9f9; padding:40px 20px;">
    <h2 style="text-align:center; margin-bottom:30px;">Key Church Departments</h2>

    @if($departments->isEmpty())
        <p style="text-align:center;">No departments available at the moment.</p>
    @else
        <div class="department-grid" style="display:grid; grid-template-columns:repeat(auto-fit,minmax(250px,1fr)); gap:20px;">
            @foreach($departments as $department)
                <div class="department-card" style="background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.1); transition: transform 0.2s;">
                    
                    @if($department->photo)
                        <div style="padding:10px; background:#f5f5f5; display:flex; justify-content:center; align-items:center;">
                            <img src="{{ asset('storage/departments_photos/' . $department->photo) }}" 
                                 alt="{{ $department->name }}" 
                                 style="width:100%; max-height:200px; object-fit:contain; border-radius:16px; border:3px solid #e0e0e0; box-shadow:0 2px 8px rgba(0,0,0,0.1);">
                        </div>
                    @else
                        <div style="width:100%; height:180px; background:#ccc; display:flex; align-items:center; justify-content:center; color:#555; border-radius:16px; border:3px solid #e0e0e0;">
                            No Image
                        </div>
                    @endif

                    <div style="padding:12px;">
                        <h3 style="margin:5px 0;">{{ $department->name }}</h3>
                        @if($department->leadership)
                            <p style="margin:3px 0; font-size:0.95rem;"><strong>Leadership:</strong> {{ $department->leadership }}</p>
                        @endif
                        @if($department->description)
                            <p style="margin:5px 0; font-size:0.9rem;">{{ \Illuminate\Support\Str::limit($department->description,120) }}</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</section>
<!-- Contact Us Section -->
@if($contactInfo)
<section class="section" id="contact" style="background:#fff;">
    <h2>Contact Us</h2>

    <div class="contact-card" style="flex-direction: column; gap: 15px; padding: 25px; max-width: 700px; margin: 0 auto;">

        <!-- Website -->
        @if($contactInfo->website_url)
        <p>
            <svg xmlns="http://www.w3.org/2000/svg" class="icon web-icon" viewBox="0 0 24 24" fill="none" stroke="#F9CA24" stroke-width="2" style="width:20px; height:20px; vertical-align:middle; margin-right:5px;">
                <path d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20z"/>
                <path d="M2 12h20"/>
                <path d="M12 2a10 10 0 0 1 0 20"/>
            </svg>
            <strong>Website:</strong>
            <a href="{{ $contactInfo->website_url }}" target="_blank" class="underline-center">
                {{ $contactInfo->website_url }}
            </a>
        </p>
        @endif

        <!-- Official Email -->
        @if($contactInfo->official_email)
        <p>
            <svg xmlns="http://www.w3.org/2000/svg" class="icon email-icon" viewBox="0 0 24 24" fill="none" stroke="#54A0FF" stroke-width="2" style="width:20px; height:20px; vertical-align:middle; margin-right:5px;">
                <path d="M4 4h16v16H4z"/>
                <polyline points="22,6 12,13 2,6"/>
            </svg>
            <strong>Email:</strong>
            <a href="mailto:{{ $contactInfo->official_email }}" class="underline-center">
                {{ $contactInfo->official_email }}
            </a>
        </p>
        @endif

        <!-- Customer Care Number -->
        @if($contactInfo->customer_care_number)
        <p>
            <svg xmlns="http://www.w3.org/2000/svg" class="icon phone-icon" viewBox="0 0 24 24" fill="none" stroke="#FF6B6B" stroke-width="2" style="width:20px; height:20px; vertical-align:middle; margin-right:5px;">
                <path d="M22 16.92v3a2 2 0 0 1-2.18 2
                         19.79 19.79 0 0 1-8.63-3.07
                         19.5 19.5 0 0 1-6-6
                         19.79 19.79 0 0 1-3.07-8.67A2
                         2 0 0 1 4.11 2h3a2 2 0 0 1
                         2 1.72c.12.89.32 1.76.59 2.59
                         a2 2 0 0 1-.45 2.11L8.09 9.91
                         a16 16 0 0 0 6 6l1.49-1.16
                         a2 2 0 0 1 2.11-.45c.83.27
                         1.7.47 2.59.59A2 2 0 0 1 22 16.92z"/>
            </svg>
            <strong>Customer Care:</strong> {{ $contactInfo->customer_care_number }}
        </p>
        @endif

        <!-- GS PA Number -->
        @if($contactInfo->general_superintendent_pa_number)
        <p>
            <svg xmlns="http://www.w3.org/2000/svg" class="icon gs-icon" viewBox="0 0 24 24" fill="none" stroke="#1DD1A1" stroke-width="2" style="width:20px; height:20px; vertical-align:middle; margin-right:5px;">
                <circle cx="12" cy="12" r="10"/>
                <path d="M8 12h8M12 8v8"/>
            </svg>
            <strong>Office of the GS:</strong> {{ $contactInfo->general_superintendent_pa_number }}
        </p>
        @endif

        <!-- Postal Address -->
        @if($contactInfo->postal_address)
        <p>
            <svg xmlns="http://www.w3.org/2000/svg" class="icon address-icon" viewBox="0 0 24 24" fill="none" stroke="#FF9F43" stroke-width="2" style="width:20px; height:20px; vertical-align:middle; margin-right:5px;">
                <path d="M21 10V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v4"/>
                <path d="M21 10l-9 6-9-6"/>
            </svg>
            <strong>Postal Address:</strong> {{ $contactInfo->postal_address }}
        </p>
        @endif

        <!-- Working Hours -->
        @if($contactInfo->working_hours)
        <p>
            <svg xmlns="http://www.w3.org/2000/svg" class="icon hours-icon" viewBox="0 0 24 24" fill="none" stroke="#9B59B6" stroke-width="2" style="width:20px; height:20px; vertical-align:middle; margin-right:5px;">
                <circle cx="12" cy="12" r="10"/>
                <path d="M12 6v6l4 2"/>
            </svg>
            <strong>Office Hours:</strong> {{ $contactInfo->working_hours }}
        </p>
        @endif

    </div>

    <!-- Google Map Embed -->
    @if($contactInfo->google_map_embed)
    <div class="map-container" style="margin-top:30px;">
        <iframe 
            src="{{ $contactInfo->google_map_embed }}" 
            width="100%" 
            height="400" 
            style="border:0; border-radius:10px;" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>
    @endif
</section>

<!-- CSS for animated underline links -->
<style>
.underline-center {
    position: relative;
    color: #0F3C78; /* blue text */
    text-decoration: none;
}

.underline-center::after {
    content: '';
    position: absolute;
    left: 50%;
    bottom: -2px;
    transform: translateX(-50%) scaleX(0);
    transform-origin: center;
    width: 100%;
    height: 2px;
    background-color: #FF6F00; /* orange underline */
    border-radius: 1px;
    transition: transform 0.3s ease;
}

.underline-center:hover::after {
    transform: translateX(-50%) scaleX(1);
}
</style>
@endif


<script>
const heading = document.getElementById('hero-heading');
const hero = document.querySelector('.hero');
const ticker = document.getElementById('hero-ticker');

window.addEventListener('scroll', () => {
    const scrollY = window.scrollY;
    const headingOffset = Math.min(scrollY / 5, 50);
    heading.style.transform = `scale(${1 + headingOffset / 100}) translateZ(${headingOffset}px) translateY(${headingOffset / 8}px)`;
    heading.style.textShadow = `
        ${4 + headingOffset}px ${4 + headingOffset}px 0 #000,
        ${8 + headingOffset}px ${8 + headingOffset}px 0 rgba(0,0,0,0.5),
        ${12 + headingOffset}px ${12 + headingOffset}px 0 rgba(0,0,0,0.3)
    `;
    hero.style.backgroundPosition = `center ${scrollY * 0.2}px`;
    ticker.style.transform = `translateY(${scrollY * 0.5}px)`;
});
</script>

@endsection
