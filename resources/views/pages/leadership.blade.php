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

* {
    box-sizing: border-box;
}

body {
    background: var(--soft-bg);
    font-family: 'Inter', sans-serif;
    margin: 0;
    padding: 0;
    overflow-x: hidden;
}

/* ================= WRAPPER ================= */
.leaders-wrapper {
    max-width: 1100px;
    margin: 0 auto;
    padding: 70px 20px;
}

/* ================= TITLE ================= */
.page-title {
    text-align: center;
    font-size: 38px;
    font-weight: 700;
    color: var(--primary);
    margin-bottom: 50px;
}

.page-title::after {
    content: "";
    width: 70px;
    height: 3px;
    background: var(--accent);
    display: block;
    margin: 12px auto 0;
    border-radius: 2px;
}

/* ================= CARD ================= */
.leader-card {
    display: flex;
    gap: 25px;
    padding: 30px;
    margin-bottom: 40px;
    border-radius: 18px;
    background: #fff;
    box-shadow: 0 12px 40px rgba(0,0,0,0.06);
    transition: 0.3s ease;
}

.leader-card:hover {
    transform: translateY(-5px);
}

/* ================= LEFT ================= */
.leader-left {
    flex: 0 0 200px;
    text-align: center;
}

.leader-photo {
    width: 170px;
    height: 170px;
    object-fit: cover;
    border-radius: 14px;
    border: 4px solid #f1f5f9;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.leader-name {
    font-size: 20px;
    font-weight: 700;
    color: var(--primary);
    margin-top: 10px;
}

.leader-position {
    font-size: 13px;
    color: var(--accent);
    font-weight: 600;
    margin-top: 4px;
    text-transform: uppercase;
}

.leader-email a {
    font-size: 13px;
    color: #2563eb;
    text-decoration: none;
}

/* ================= RIGHT ================= */
.leader-right {
    flex: 1;
}

.leader-description {
    font-size: 15px;
    line-height: 1.7;
    color: #334155;
    margin-bottom: 15px;
    text-align: justify;
}

/* ================= MESSAGE ================= */
.leader-message {
    position: relative;
    padding: 16px 18px 16px 38px;
    border-radius: 12px;
    background: var(--message-bg);
    font-size: 14px;
    line-height: 1.6;
    color: #1e293b;
    border-left: 5px solid var(--accent);
    box-shadow: 0 6px 18px rgba(0,0,0,0.06);
}

.leader-message::before {
    content: "“";
    position: absolute;
    top: 5px;
    left: 10px;
    font-size: 32px;
    color: var(--quote-color);
}

.signature {
    font-weight: 700;
}

/* ================= TABLET ================= */
@media (max-width: 900px) {
    .leader-card {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .leader-right {
        width: 100%;
    }

    .leader-description {
        text-align: justify;
    }
}

/* ================= MOBILE FINAL OPTIMIZED ================= */
@media (max-width: 600px) {

    .leaders-wrapper {
        padding: 30px 12px;
    }

    .page-title {
        font-size: 24px;
        margin-bottom: 30px;
    }

    .leader-card {
        padding: 14px;
        border-radius: 14px;
        gap: 12px;
    }

    /* 🔥 BIG FULL-WIDTH IMAGE ON MOBILE */
    .leader-left {
        width: 100%;
    }

    .leader-photo {
        width: 100%;
        height: 300px;
        border-radius: 12px;
        object-fit: cover;
    }

    .leader-name {
        font-size: 18px;
        margin-top: 10px;
    }

    .leader-position {
        font-size: 12px;
    }

    .leader-description {
        font-size: 13.5px;
        line-height: 1.6;
    }

    .leader-message {
        font-size: 13px;
        padding: 14px 14px 14px 34px;
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

            <!-- LEFT -->
            <div class="leader-left">
                <img src="{{ $photo }}" class="leader-photo" alt="">
                <div class="leader-name">{{ $leader->full_name }}</div>
                <div class="leader-position">{{ $leader->position }}</div>

                @if($leader->email)
                    <div class="leader-email">
                        <a href="mailto:{{ $leader->email }}">{{ $leader->email }}</a>
                    </div>
                @endif
            </div>

            <!-- RIGHT -->
            <div class="leader-right">

                @if($leader->brief_description)
                    <div class="leader-description">
                        {{ $leader->brief_description }}
                    </div>
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

@endsection