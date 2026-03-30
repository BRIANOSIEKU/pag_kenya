@extends('layouts.app')

@section('title', 'Giving / Donations')

@section('content')
<div class="container mx-auto py-12 px-4">

    <!-- ================== Page Header ================== -->
<div class="hero-center text-center px-4">

    <!-- ================== Heading with Animated Glow Underline ================== -->
    <h1 class="text-4xl md:text-5xl font-bold text-gray-800 relative inline-block mb-2">
        <span class="underline-creative">Support Our Mission</span>
    </h1>

    <!-- ================== Paragraph ================== -->
    <p class="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
        Your heartfelt donations make a real difference; helping us uplift communities, advance vital church projects, 
        and share the life-changing message of the gospel throughout Kenya.<br>
        Every gift, big or small, plays a part in transforming lives. May God bless you abundantly as you plan to give cheerfully.
    </p>

</div>

<style>
/* ================== Full Center Hero (Reduced Vertical Gaps) ================== */
.hero-center {
    display: flex;
    flex-direction: column;
    justify-content: flex-start; /* Align to top instead of center vertically */
    align-items: center;
    min-height: auto; /* Remove extra vertical height */
    text-align: center;
    padding: 20px;
}

/* ================== Animated Glow + Pulse Underline ================== */
.underline-creative {
    position: relative;
    display: inline-block;
}

.underline-creative::after {
    content: '';
    position: absolute;
    left: 50%;
    bottom: -6px; /* Slightly closer to text */
    transform: translateX(-50%) scaleX(0);
    transform-origin: center;
    width: 70%;
    height: 4px;
    background: linear-gradient(90deg, #fbbf24, #f59e0b);
    border-radius: 5px;
    box-shadow: 0 3px 8px rgba(251, 191, 36, 0.5);
    animation: drawGlowUnderline 1.2s forwards ease-out, pulseUnderline 2s infinite ease-in-out 1.2s;
}

/* Keyframes for the "drawing + glow pulse" effect */
@keyframes drawGlowUnderline {
    0% {
        transform: translateX(-50%) scaleX(0);
        box-shadow: 0 0 0 rgba(251, 191, 36, 0);
    }
    50% {
        transform: translateX(-50%) scaleX(0.5);
        box-shadow: 0 0 6px rgba(251, 191, 36, 0.6);
    }
    100% {
        transform: translateX(-50%) scaleX(1);
        box-shadow: 0 0 10px rgba(251, 191, 36, 0.8);
    }
}

/* Subtle ongoing pulse after drawing */
@keyframes pulseUnderline {
    0%, 100% {
        box-shadow: 0 0 10px rgba(251, 191, 36, 0.8);
    }
    50% {
        box-shadow: 0 0 14px rgba(251, 191, 36, 1);
    }
}

/* ================= RESPONSIVE ================= */
@media (max-width: 768px) {
    .underline-creative::after {
        width: 50%;
        height: 3px;
        bottom: -4px;
    }

    p {
        font-size: 1rem;
    }

    h1 {
        font-size: 1.8rem;
    }
}
</style>


    <!-- ================== Donation Instructions Cards ================== -->
    <section class="profile-container grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        @if($instructions->count() > 0)
            @foreach($instructions as $index => $instruction)
                <div class="profile-card">
                    <!-- Image -->
                    @if($instruction->image)
                        <img src="{{ asset('storage/' . $instruction->image) }}" 
                             alt="{{ $instruction->mode_of_payment }}" 
                             class="w-full h-40 object-cover rounded mb-4">
                    @endif

                    <!-- Numbered Mode of Payment -->
                    <h2>{{ $index + 1 }}. {{ $instruction->mode_of_payment }}</h2>
                    <div class="gold-line"></div>

                    <!-- Instructions as Roman Numerals -->
                    @if($instruction->instruction)
                        @php
                            $steps = explode("\n", $instruction->instruction);
                        @endphp
                        <ol class="roman-list mt-3">
                            @foreach($steps as $step)
                                @if(trim($step) != '')
                                    <li>{{ $step }}</li>
                                @endif
                            @endforeach
                        </ol>
                    @endif
                </div>
            @endforeach
        @else
            <p class="text-gray-600 mb-10">No donation instructions available at the moment. Please check back later.</p>
        @endif

    </section>

    <!-- ================== Give Now Button ================== -->
    <div class="flex justify-center mt-12">
        <a href="{{ route('giving.form') }}"
           class="give-now-btn">
           Give Now
        </a>
    </div>

</div>

<style>
/* ================== Enhanced Message Card ================== */
.animate-fade-in {
    animation: fadeIn 1s ease-in-out forwards;
}

@keyframes fadeIn {
    0% { opacity: 0; transform: translateY(20px);}
    100% { opacity: 1; transform: translateY(0);}
}

/* ================== Give Now Button Style ================== */
.give-now-btn {
    display: inline-block;
    font-size: 1.5rem;
    font-weight: 700;
    color: #fff;
    padding: 20px 50px;
    border-radius: 12px;
    background: linear-gradient(90deg, #f59e0b, #fbbf24);
    box-shadow: 0 8px 25px rgba(255, 184, 28, 0.5);
    transition: all 0.3s ease;
    text-decoration: none;
    animation: pulseGlow 2.5s infinite;
}

.give-now-btn:hover {
    background: linear-gradient(90deg, #fbbf24, #f59e0b);
    transform: scale(1.1);
    box-shadow: 0 12px 35px rgba(255, 184, 28, 0.7);
}

@keyframes pulseGlow {
    0% { transform: scale(1); box-shadow: 0 8px 25px rgba(255, 184, 28, 0.5); }
    50% { transform: scale(1.05); box-shadow: 0 12px 35px rgba(255, 184, 28, 0.7); }
    100% { transform: scale(1); box-shadow: 0 8px 25px rgba(255, 184, 28, 0.5); }
}

/* ================= CARD STYLE ================= */
.profile-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.profile-card {
    background: #fff;
    padding: 25px;
    border-radius: 14px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.profile-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 18px 40px rgba(0,0,0,0.12);
}

.profile-card h2 {
    font-family: 'Playfair Display', serif;
    color: #0f3c78;
    margin-bottom: 15px;
}

/* ================= GOLD DIVIDER ================= */
.gold-line {
    width: 60px;
    height: 3px;
    background: linear-gradient(90deg, #d4af37, #b8860b);
    margin-bottom: 20px;
}

/* ================= ROMAN LIST STYLE ================= */
.roman-list {
    list-style-type: upper-roman;
    padding-left: 40px;
    font-family: 'Inter', sans-serif;
    color: #444;
    line-height: 1.7;
    margin: 0;
}

.roman-list li {
    margin-bottom: 12px;
}

/* ================= RESPONSIVE ================= */
@media (max-width: 768px) {
    .profile-card { padding: 20px; }
}
</style>
@endsection
