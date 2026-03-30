@extends('layouts.app')

@section('content')

<style>
:root {
    --primary: #0f172a;
    --accent: #c8a951;
    --muted: #64748b;
    --soft-bg: #f8fafc;
    --message-bg: #fff8e7;
    --quote-color: rgba(200, 169, 81, 0.3);
}

body {
    background: var(--soft-bg);
    font-family: 'Inter', sans-serif;
}

.leaders-wrapper {
    max-width: 1150px;
    margin: 0 auto;
    padding: 90px 24px;
}

.page-title {
    text-align: center;
    font-size: 40px;
    font-weight: 700;
    color: var(--primary);
    margin-bottom: 80px;
    position: relative;
}

.page-title::after {
    content: "";
    width: 70px;
    height: 3px;
    background: var(--accent);
    display: block;
    margin: 15px auto 0;
    border-radius: 2px;
}

/* ================= CARD ================= */
.leader-card {
    display: flex;
    flex-wrap: wrap;
    gap: 30px;
    margin-bottom: 70px;
    padding: 35px;
    border-radius: 22px;
    background: #ffffff;
    box-shadow: 0 20px 50px rgba(0,0,0,0.06);
    transition: all 0.4s ease;
    opacity: 0;
    transform: translateY(40px);
}

.leader-card.visible {
    opacity: 1;
    transform: translateY(0);
    transition: all 0.8s ease;
}

.leader-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 30px 70px rgba(0,0,0,0.08);
}

/* LEFT COLUMN */
.leader-left {
    flex: 0 0 220px;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

.leader-photo {
    width: 180px;
    height: 180px;
    object-fit: cover;
    border-radius: 16px; /* square with slightly rounded corners */
    margin-bottom: 20px;
    border: 5px solid #f1f5f9;
    box-shadow: 0 12px 30px rgba(0,0,0,0.12);
    transition: transform 0.3s ease;
}

.leader-photo:hover {
    transform: scale(1.05);
}

.leader-name {
    font-size: 22px;
    font-weight: 700;
    color: var(--primary);
    margin-bottom: 6px;
}

.leader-position {
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: var(--accent);
    font-weight: 600;
    margin-bottom: 10px;
}

.leader-email a {
    font-size: 13px;
    color: #2563eb;
    text-decoration: none;
    transition: 0.3s;
}

.leader-email a:hover {
    opacity: 0.7;
}

/* RIGHT COLUMN */
.leader-right {
    flex: 1;
    min-width: 250px;
}

.leader-description {
    font-size: 15px;
    line-height: 1.6;
    color: #334155;
    margin-bottom: 20px;
    text-align: justify;
}

/* MESSAGE CARD */
.leader-message {
    display: inline-block;
    position: relative;
    max-width: 100%;
    padding: 20px 22px 20px 40px;
    border-radius: 14px;
    background: var(--message-bg);
    font-size: 14px;
    line-height: 1.5;
    color: #1e293b;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    border-left: 6px solid var(--accent);
    transition: all 0.3s ease;
    overflow-wrap: break-word;
}

.leader-message:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.12);
}

.leader-message::before {
    content: "“";
    position: absolute;
    top: 8px;
    left: 12px;
    font-size: 36px;
    font-weight: 700;
    color: var(--quote-color);
}

.leader-message p {
    margin: 0 0 6px 0;
}

.leader-message p:last-child {
    margin-bottom: 0;
}

.signature {
    font-weight: 700;
}

/* ================= RESPONSIVE ================= */
@media (max-width: 992px) {
    .leader-card {
        flex-direction: column;
        align-items: center;
    }

    .leader-left {
        flex: none;
    }

    .leader-right {
        text-align: center;
    }

    .leader-description,
    .leader-message {
        text-align: justify;
        max-width: 100%;
    }
}
</style>

<div class="leaders-wrapper">

    <h1 class="page-title">{{ $type }}</h1>

    @foreach($leaders as $leader)
        @php
            $file = basename($leader->photo ?? '');
            $path = public_path('leaders/' . $file);
            $photo = ($file && file_exists($path)) 
                ? url('leaders/' . $file) 
                : url('images/default-profile.png');
        @endphp

        <div class="leader-card">

            <!-- LEFT COLUMN -->
            <div class="leader-left">
                <img src="{{ $photo }}" alt="{{ $leader->full_name }}" class="leader-photo">
                <div class="leader-name">{{ $leader->full_name }}</div>
                <div class="leader-position">{{ $leader->position }}</div>

                @if($leader->email)
                    <div class="leader-email">
                        <a href="mailto:{{ $leader->email }}">{{ $leader->email }}</a>
                    </div>
                @endif
            </div>

            <!-- RIGHT COLUMN -->
            <div class="leader-right">
                @if($leader->brief_description)
                    <div class="leader-description">{{ $leader->brief_description }}</div>
                @endif

                @if($leader->message)
                    @php
                        $lines = array_values(array_filter(explode("\n", $leader->message)));
                        $total = count($lines);
                    @endphp
                    <div class="leader-message">
                        @foreach($lines as $index => $line)
                            @if($index >= $total - 3)
                                <p class="signature">{{ trim($line) }}</p>
                            @else
                                <p>{{ trim($line) }}</p>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    @endforeach

</div>

<script>
    const cards = document.querySelectorAll('.leader-card');

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if(entry.isIntersecting){
                entry.target.classList.add('visible');
            }
        });
    }, { threshold: 0.2 });

    cards.forEach(card => {
        observer.observe(card);
    });
</script>

@endsection