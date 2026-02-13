@extends('layouts.app')

@section('title', 'Home')

@section('content')

<style>
    :root {
        --main-blue: #007BB8;
        --dark-brown: #4B2E2E;
        --pure-white: #FFFFFF;
        --black: #000000;
        --accent-yellow: #FFD700; /* gold */
    }

    body {
        font-family: 'Arial', sans-serif;
        background-color: var(--pure-white);
        color: var(--black);
        margin: 0;
        padding: 0;
    }

    /* --- Hero Section --- */
    .hero {
        height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        background-image: url('{{ asset("images/background.png") }}');
        background-size: cover;
        background-position: center;
        position: relative;
        color: var(--pure-white);
        overflow: hidden;
        perspective: 1000px;
        will-change: transform, background-position;
        transition: background-position 0.1s ease-out;
    }

    /* Overlay for readability */
    .hero::after {
        content: '';
        position: absolute;
        top:0; left:0; width:100%; height:100%;
        background-color: rgba(0,0,0,0.5);
        z-index: 0;
    }

    .hero-content {
        position: relative;
        z-index: 1;
        max-width: 900px;
        padding: 0 20px;
        transform-style: preserve-3d;
    }

    /* --- Heading --- */
    .hero h1 {
        font-size: 3.5rem;
        color: var(--pure-white); /* white heading */
        margin-bottom: 15px;
        line-height: 1.2;
        font-weight: bold;
        text-shadow: 
            2px 2px 0 #000,
            4px 4px 0 rgba(0,0,0,0.5),
            6px 6px 0 rgba(0,0,0,0.3);
        transition: transform 0.2s ease-out, text-shadow 0.2s ease-out;
        will-change: transform, text-shadow;
    }

    .hero p {
        font-size: 1.4rem;
        color: var(--accent-yellow); /* gold text */
        font-style: italic;
        margin-bottom: 30px;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
    }

    /* --- Fade-In Animations --- */
    .fade-in {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 1s forwards;
    }

    .delay-1 { animation-delay: 0.3s; }
    .delay-2 { animation-delay: 0.7s; }
    .delay-3 { animation-delay: 1.1s; }

    @keyframes fadeInUp {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    /* --- Scrolling Ticker on Hero Top --- */
    .hero-ticker {
        position: absolute;
        top: 20px;
        left: 0;
        width: 100%;
        overflow: hidden;
        white-space: nowrap;
        z-index: 2;
    }

    .hero-ticker span {
        display: inline-block;
        padding-right: 60px;
        color: var(--accent-yellow);
        font-weight: bold;
        font-size: 1.1rem;
        animation: scroll-left 20s linear infinite;
    }

    .hero-ticker:hover span {
        animation-play-state: paused;
    }

    @keyframes scroll-left {
        0% { transform: translateX(100%); }
        100% { transform: translateX(-100%); }
    }

    /* --- Scroll Down Arrow --- */
    .scroll-down {
        font-size: 2.5rem;
        color: var(--pure-white);
        animation: bounce 2s infinite;
        cursor: pointer;
    }

    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
        40% { transform: translateY(10px); }
        60% { transform: translateY(5px); }
    }

    /* --- Sections --- */
    .section {
        padding: 60px 20px;
        text-align: center;
        max-width: 1200px;
        margin: 0 auto;
    }

    .section h2 {
        color: var(--main-blue);
        font-size: 2.5rem;
        margin-bottom: 40px;
        position: relative;
        display: inline-block;
    }

    .section h2::after {
        content: '';
        display: block;
        height: 4px;
        width: 50%;
        background: var(--accent-yellow);
        margin: 8px auto 0 auto;
        border-radius: 2px;
    }

    /* --- Cards --- */
    .cards, .carousel {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 25px;
    }

    .card {
        background-color: var(--pure-white);
        border-radius: 12px;
        box-shadow: 0 6px 15px rgba(0,0,0,0.1);
        width: 280px;
        transition: transform 0.3s, box-shadow 0.3s;
        overflow: hidden;
        text-align: center;
        flex-shrink: 0;
    }

    .card img {
        width: 100%;
        height: 160px;
        object-fit: cover;
    }

    .card h3 {
        color: var(--dark-brown);
        margin: 15px 10px 10px 10px;
    }

    .card p {
        color: var(--black);
        font-size: 0.95rem;
        padding: 0 10px 15px 10px;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 20px rgba(0,0,0,0.2);
    }

    .carousel {
        overflow-x: auto;
        scroll-behavior: smooth;
        padding-bottom: 10px;
    }

    .carousel::-webkit-scrollbar {
        height: 8px;
    }

    .carousel::-webkit-scrollbar-thumb {
        background-color: var(--main-blue);
        border-radius: 4px;
    }

    /* --- Responsive --- */
    @media (max-width: 992px) {
        .hero h1 { font-size: 2.8rem; }
        .hero p { font-size: 1.2rem; }
        .section h2 { font-size: 2rem; }
        .hero-ticker span { font-size: 1rem; }
    }

    @media (max-width: 768px) {
        .cards, .carousel { flex-direction: column; align-items: center; }
        .hero h1 { font-size: 2.2rem; }
        .hero p { font-size: 1rem; }
        .hero-ticker span { font-size: 0.9rem; }
    }
</style>

<!-- --- Hero Section --- -->
<section class="hero">
    <!-- Theme & Scripture Ticker -->
    <div class="hero-ticker" id="hero-ticker">
        <span>Theme of the Year: MOUNTING UP!</span>
        <span>Scripture of the Year: Isaiah 40:31</span>
    </div>

    <div class="hero-content">
        <h1 id="hero-heading" class="fade-in delay-1">WELCOME TO PAG - K</h1>
        <p class="fade-in delay-2">The Home of Pentecostalism</p>
        <div class="scroll-down fade-in delay-3">&#x25BC;</div>
    </div>
</section>

<!-- --- Featured Daily Devotion --- -->
<section class="section">
    <h2>Featured Daily Devotion</h2>
    <div class="card" style="margin: 0 auto; max-width: 600px;">
        <img src="{{ asset('images/devotion-placeholder.jpg') }}" alt="Devotion">
        <h3>Daily Devotion Title</h3>
        <p>Short excerpt of the daily devotion goes here...</p>
        <small>{{ now()->format('F j, Y') }}</small>
    </div>
</section>

<!-- --- Departments Section --- -->
<section class="section">
    <h2>Key Church Departments</h2>
    <div class="cards">
        <div class="card">
            <img src="{{ asset('images/department-placeholder.jpg') }}" alt="Youth Ministry">
            <h3>Youth Ministry</h3>
            <p>Engaging young people in faith and community.</p>
        </div>
        <div class="card">
            <img src="{{ asset('images/department-placeholder.jpg') }}" alt="Music Ministry">
            <h3>Music Ministry</h3>
            <p>Leading worship through music and praise.</p>
        </div>
        <div class="card">
            <img src="{{ asset('images/department-placeholder.jpg') }}" alt="Outreach">
            <h3>Outreach</h3>
            <p>Serving the community with love.</p>
        </div>
    </div>
</section>

<!-- --- Programs Carousel --- -->
<section class="section" style="background-color:#f9f9f9;">
    <h2>Our Programs</h2>
    <div class="carousel">
        <div class="card">
            <img src="{{ asset('images/program-placeholder.jpg') }}" alt="Sunday School">
            <h3>Sunday School</h3>
            <p>Fun and faith for kids.</p>
        </div>
        <div class="card">
            <img src="{{ asset('images/program-placeholder.jpg') }}" alt="Bible Study">
            <h3>Bible Study</h3>
            <p>Deep dive into God's Word.</p>
        </div>
        <div class="card">
            <img src="{{ asset('images/community-placeholder.jpg') }}" alt="Community Service">
            <h3>Community Service</h3>
            <p>Helping those in need.</p>
        </div>
    </div>
</section>

<!-- --- Latest News Carousel --- -->
<section class="section">
    <h2>Latest News</h2>
    <div class="carousel">
        <div class="card">
            <img src="{{ asset('images/news-placeholder.jpg') }}" alt="Annual Conference">
            <h3>Annual Conference</h3>
            <p>Highlights from our annual conference.</p>
        </div>
        <div class="card">
            <img src="{{ asset('images/news-placeholder.jpg') }}" alt="Mission Trip">
            <h3>Mission Trip</h3>
            <p>Our recent mission trip to the local community.</p>
        </div>
        <div class="card">
            <img src="{{ asset('images/news-placeholder.jpg') }}" alt="Charity Drive">
            <h3>Charity Drive</h3>
            <p>Updates on our charity initiatives.</p>
        </div>
    </div>
</section>

<script>
    const heading = document.getElementById('hero-heading');
    const hero = document.querySelector('.hero');
    const ticker = document.getElementById('hero-ticker');

    window.addEventListener('scroll', () => {
        const scrollY = window.scrollY;

        // Heading: slower parallax for 3D pop
        const headingOffset = Math.min(scrollY / 5, 50);
        heading.style.transform = `scale(${1 + headingOffset / 100}) translateZ(${headingOffset}px) translateY(${headingOffset / 8}px)`;
        heading.style.textShadow = `
            ${4 + headingOffset}px ${4 + headingOffset}px 0 #000,
            ${8 + headingOffset}px ${8 + headingOffset}px 0 rgba(0,0,0,0.5),
            ${12 + headingOffset}px ${12 + headingOffset}px 0 rgba(0,0,0,0.3)
        `;

        // Background: slow parallax
        hero.style.backgroundPosition = `center ${scrollY * 0.2}px`;

        // Ticker: slightly faster parallax
        ticker.style.transform = `translateY(${scrollY * 0.5}px)`;
    });
</script>

@endsection
