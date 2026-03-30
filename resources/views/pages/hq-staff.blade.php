@extends('layouts.app') {{-- Use your public layout --}}

@section('content')
<div class="hero-section">
    <h1 class="page-title">
        PAG Kenya HQ Staff
    </h1>
</div>

<div class="staff-container">
    @if($staffs->isEmpty())
        <p style="text-align:center; font-size:1.1rem; color:#555;">No HQ staff found at the moment.</p>
    @else
        <div class="staff-grid">
            @foreach($staffs as $staff)
            <div class="staff-card animate-on-scroll">
                <div class="staff-photo">
                    @if($staff->photo && file_exists(public_path($staff->photo)))
                        <img src="{{ asset($staff->photo) }}" alt="{{ $staff->full_name }}">
                    @else
                        <img src="{{ asset('images/default-avatar.png') }}" alt="Default Staff Photo">
                    @endif
                </div>
                <div class="staff-info">
                    <h3>{{ $staff->full_name }}</h3>
                    <p class="position">{{ $staff->position }}</p>
                    <p class="email">{{ $staff->email }}</p>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>

<style>
/* Hero section: full screen, centered title */
.hero-section {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 60vh; /* title vertical center in viewport */
    flex-direction: column;
    text-align: center;
    padding: 0 20px;
    background: #f4f4f4;
}

/* Page Title with animated underline */
.page-title {
    font-family: 'Playfair Display', serif;
    font-size: 3rem;
    color: #0f3c78;
    position: relative;
    display: inline-block;
    margin: 0;
}

/* Animated underline from center */
.page-title::after {
    content: '';
    display: block;
    width: 60%;
    height: 4px;
    background-color: orange;
    margin: 8px auto 0;
    border-radius: 2px;
    transform: scaleX(0);
    transform-origin: center;
    animation: underline-grow 1s ease forwards;
}

@keyframes underline-grow {
    to {
        transform: scaleX(1);
    }
}

/* Staff container below hero */
.staff-container {
    padding: 40px 20px 80px;
}

/* Staff Grid */
.staff-grid {
    display: grid;
    grid-template-columns: repeat(10, 1fr); /* 10 cards per row on desktop */
    gap: 20px;
    justify-items: center;
}

/* Staff Card */
.staff-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    overflow: hidden;
    text-align: center;
    width: 100%;
    max-width: 150px; /* smaller cards */
    transition: transform 0.3s ease, box-shadow 0.3s ease, opacity 0.6s ease;
    opacity: 0; /* hidden initially for animation */
    transform: translateY(30px); /* slide-up effect */
}

.staff-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.12);
}

/* Photo */
.staff-photo img {
    width: 100%;
    height: 150px;
    object-fit: cover;
}

/* Info */
.staff-info {
    padding: 10px 8px;
}

.staff-info h3 {
    font-family: 'Playfair Display', serif;
    font-size: 1rem;
    color: #0f3c78;
    margin-bottom: 4px;
}

.staff-info .position {
    font-family: 'Inter', sans-serif;
    font-size: 0.85rem;
    color: #4CAF50;
    margin-bottom: 3px;
}

.staff-info .email {
    font-family: 'Inter', sans-serif;
    font-size: 0.75rem;
    color: #555;
    word-wrap: break-word;
}

/* Scroll animation class */
.animate-on-scroll.show {
    opacity: 1;
    transform: translateY(0);
}

/* Responsive */
@media(max-width: 1200px) {
    .staff-grid {
        grid-template-columns: repeat(6, 1fr);
    }
}

@media(max-width: 992px) {
    .staff-grid {
        grid-template-columns: repeat(4, 1fr);
    }
}

@media(max-width: 768px) {
    .staff-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media(max-width: 500px) {
    .staff-grid {
        grid-template-columns: repeat(2, 1fr); /* 2 cards per row on mobile */
    }
    .page-title {
        font-size: 2rem;
    }
    .page-title::after {
        width: 50%;
        height: 3px;
    }
}
</style>

<script>
/* Scroll animation for staff cards */
document.addEventListener('DOMContentLoaded', () => {
    const cards = document.querySelectorAll('.animate-on-scroll');

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if(entry.isIntersecting){
                entry.target.classList.add('show');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.2 });

    cards.forEach(card => observer.observe(card));
});
</script>
@endsection