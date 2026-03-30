@extends('layouts.app')

@section('content')

<!-- HERO SECTION -->
<section class="profile-hero">
    <div class="hero-content">
        <h1>THE PAG (K) CHURCH PROFILE</h1>
        <p>
            {{ optional($profile)->motto ?? 'Empowering communities through faith and service' }}
        </p>
    </div>
</section>


<!-- MAIN CONTENT -->
<section class="profile-container">

    <!-- Overview -->
    <div id="overview" class="profile-card">
        <h2>Overview</h2>
        <div class="gold-line"></div>
        <p>{{ optional($profile)->overview }}</p>
    </div>

    <!-- Brief History -->
    <div id="history" class="profile-card">
        <h2>Brief Church History</h2>
        <div class="gold-line"></div>

        @php
            $historyParagraphs = explode("\n", optional($profile)->history);
        @endphp

        @foreach($historyParagraphs as $paragraph)
            @if(trim($paragraph) != '')
                <p>{{ $paragraph }}</p>
            @endif
        @endforeach
    </div>

    <!-- Vision -->
    <div id="vision" class="profile-card">
        <h2>Vision</h2>
        <div class="gold-line"></div>
        <p>{{ optional($profile)->vision }}</p>
    </div>

    <!-- Mission -->
    <div id="mission" class="profile-card">
        <h2>Mission</h2>
        <div class="gold-line"></div>
        <p>{{ optional($profile)->mission }}</p>
    </div>

    <!-- Core Values -->
    <div id="core-values" class="profile-card">
        <h2>Core Values</h2>
        <div class="gold-line"></div>

        @php
            $values = explode("\n", optional($profile)->core_values);
        @endphp

        <ol class="core-values-list">
            @foreach($values as $value)
                @if(trim($value) != '')
                    <li>{{ $value }}</li>
                @endif
            @endforeach
        </ol>
    </div>

    <!-- Statement of Faith -->
    <div id="statement-of-faith" class="profile-card">
        <h2>Statement of Faith</h2>
        <div class="gold-line"></div>
        <p>{{ optional($profile)->statement_of_faith }}</p>
    </div>

</section>

@endsection


<style>

/* ================= HERO SECTION ================= */
.profile-hero {
    position: relative;
    height: 350px;
    background: linear-gradient(rgba(6, 95, 131, 0.9), rgba(5, 94, 121, 0.9)),
                url('{{ asset('images/church-bg.jpg') }}');
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    color: #fff;
}

.hero-content h1 {
    font-family: 'Playfair Display', serif;
    font-size: 3rem;
    margin-bottom: 10px;
}

.hero-content p {
    font-family: 'Inter', sans-serif;
    font-size: 1.1rem;
    color: #d4af37;
}

/* ================= MAIN CONTAINER ================= */
.profile-container {
    max-width: 1100px;
    margin: 80px auto;
    padding: 0 20px;
}

/* ================= CARD STYLE ================= */
.profile-card {
    background: #fff;
    padding: 40px;
    margin-bottom: 50px;
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
    margin-bottom: 10px;
}

.profile-card p {
    font-family: 'Inter', sans-serif;
    line-height: 1.8;
    color: #444;
}

/* ================= GOLD DIVIDER ================= */
.gold-line {
    width: 60px;
    height: 3px;
    background: linear-gradient(90deg, #d4af37, #b8860b);
    margin-bottom: 25px;
}

/* ================= CORE VALUES ================= */
.core-values-list {
    list-style: none;
    padding: 0;
    margin: 0;
    counter-reset: core-counter;
}

.core-values-list li {
    counter-increment: core-counter;
    position: relative;
    padding-left: 70px;
    margin-bottom: 30px;
    font-family: 'Inter', sans-serif;
    font-size: 1rem;
    line-height: 1.7;
    color: #444;
}

.core-values-list li::before {
    content: counter(core-counter);
    position: absolute;
    left: 0;
    top: 0;
    width: 45px;
    height: 45px;
    background: linear-gradient(135deg, #d4af37, #b8860b);
    color: #fff;
    font-weight: 600;
    font-size: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    box-shadow: 0 6px 15px rgba(0,0,0,0.15);
}

/* ================= RESPONSIVE ================= */
@media (max-width: 768px) {
    .hero-content h1 {
        font-size: 2rem;
    }

    .profile-card {
        padding: 25px;
    }

    .core-values-list li {
        padding-left: 60px;
    }

    .core-values-list li::before {
        width: 38px;
        height: 38px;
        font-size: 0.9rem;
    }
}

</style>