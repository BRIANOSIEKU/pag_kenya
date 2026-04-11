@extends('layouts.app')

@section('title', $committee->name)

@section('content')

<style>
:root {
    --citam-dark: #1a1a1a;
    --citam-gold: #c8a951;
    --citam-gray: #555555;
    --citam-blue: #003366;
    --citam-light-bg: #ffffff;
}

body {
    background: var(--citam-light-bg);
    font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
    color: var(--citam-dark);
    line-height: 1.6;
}

.citam-container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 80px 20px;
}

/* TITLE */
.citam-title {
    font-size: 42px;
    font-weight: 800;
    text-align: center;
    margin-bottom: 50px;
    position: relative;
    padding-bottom: 15px;
}

.citam-title::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 100px;
    height: 4px;
    background-color: var(--citam-blue);
}

/* OVERVIEW */
.citam-overview {
    font-size: 18px;
    color: var(--citam-gray);
    margin-bottom: 60px;
    padding: 20px 40px;
    border-left: 5px solid var(--citam-gold);
    background: #fdfdfd;
}

/* SECTION TITLE */
.citam-section-head {
    font-size: 26px;
    font-weight: 700;
    margin: 80px 0 30px;
    color: var(--citam-dark);
    position: relative;
    padding-bottom: 10px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.citam-section-head::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    width: 60px;
    height: 3px;
    background-color: var(--citam-blue);
}

/* LEADERS */
.leadership-row {
    display: flex;
    flex-wrap: wrap;
    gap: 30px;
}

.leader-item {
    flex: 1;
    min-width: 280px;
    max-width: 310px;
    margin-bottom: 40px;
    text-align: center;
}

/* ✅ MODERN PHOTO STYLE */
.leader-photo-citam {
    width: 100%;
    height: auto;
    border-radius: 16px;
    box-shadow: 0 20px 40px rgba(255,255,255,0.2), 0 10px 20px rgba(0,0,0,0.15);
    transition: transform 0.3s ease;
    margin-bottom: 15px;
}

.leader-photo-citam:hover {
    transform: scale(1.03);
}

.leader-role-citam {
    font-size: 13px;
    color: var(--citam-gold);
    font-weight: 700;
    text-transform: uppercase;
    margin-bottom: 5px;
}

.leader-name-citam {
    font-size: 20px;
    font-weight: 700;
    margin: 0;
}

/* MEMBERS */
.member-row-citam {
    display: flex;
    justify-content: space-between;
    padding: 15px 0;
    border-bottom: 1px solid #f0f0f0;
}

/* REPORTS */
.report-card {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 25px;
    border: 1px solid #eee;
    margin-bottom: 15px;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.report-card:hover {
    border-color: var(--citam-gold);
    background: #fffcf5;
}

.hidden-report {
    display: none;
}

.report-date {
    font-size: 12px;
    color: var(--citam-gold);
    font-weight: 700;
    text-transform: uppercase;
}

.report-title {
    font-size: 18px;
    font-weight: 700;
    margin: 5px 0;
}

.btn-download {
    padding: 10px 22px;
    background: var(--citam-dark);
    color: #fff;
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
    border-radius: 4px;
    text-transform: uppercase;
}

.btn-download:hover {
    background: var(--citam-blue);
}

.btn-show-more {
    display: block;
    margin: 30px auto;
    padding: 12px 30px;
    background: white;
    border: 2px solid var(--citam-blue);
    color: var(--citam-blue);
    font-weight: 700;
    cursor: pointer;
    border-radius: 4px;
}

.btn-show-more:hover {
    background: var(--citam-blue);
    color: white;
}

/* MOBILE */
@media (max-width: 768px) {
    .report-card {
        flex-direction: column;
        text-align: center;
    }

    .btn-download {
        margin-top: 15px;
        width: 100%;
    }
}
</style>

<div class="citam-container">

    <h1 class="citam-title">{{ $committee->name }}</h1>

    {{-- OVERVIEW --}}
    @if($committee->overview)
        <div class="citam-overview">
            {!! nl2br(e($committee->overview)) !!}
        </div>
    @endif

    {{-- LEADERS --}}
    @if($committee->leaders && $committee->leaders->count() > 0)
        <h2 class="citam-section-head">Leadership</h2>
        <div class="leadership-row">
            @foreach($committee->leaders as $leader)
                <div class="leader-item">
                    @php
                        $photo = $leader->pivot->photo 
                            ? asset('storage/leaders_photos/'.$leader->pivot->photo) 
                            : asset('images/default-profile.png');
                    @endphp

                    <img src="{{ $photo }}" 
                         class="leader-photo-citam"
                         alt="{{ $leader->name }}"
                         onerror="this.src='{{ asset('images/default-profile.png') }}';">

                    <div class="leader-role-citam">
                        {{ $leader->pivot->role ?? 'Officer' }}
                    </div>

                    <h3 class="leader-name-citam">{{ $leader->name }}</h3>
                </div>
            @endforeach
        </div>
    @endif

    {{-- MEMBERS --}}
    @if($committee->members && $committee->members->count() > 0)
        <h2 class="citam-section-head">Committee Members</h2>
        @foreach($committee->members as $index => $member)
            <div class="member-row-citam">
                <div>
                    <span style="color: var(--citam-gold); margin-right: 15px; font-weight: 700;">
                        {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                    </span>
                    {{ $member->member_name }}
                </div>
                <div style="font-size: 12px; color: #999; text-transform: uppercase; font-weight: 600;">
                    {{ $member->member_gender }}
                </div>
            </div>
        @endforeach
    @endif

    {{-- REPORTS --}}
    @if($committee->reports && $committee->reports->count() > 0)
        <h2 class="citam-section-head">Committee Reports</h2>

        <div id="reports-list">
            @foreach($committee->reports as $index => $report)
                <div class="report-wrapper {{ $index >= 5 ? 'hidden-report' : '' }}">
                    <div class="report-card">
                        <div>
                            <div class="report-date">
                                {{ \Carbon\Carbon::parse($report->report_date)->format('M d, Y') }}
                            </div>
                            <h4 class="report-title">{{ $report->title }}</h4>

                            @if($report->description)
                                <p style="font-size: 14px; color: var(--citam-gray); margin: 0;">
                                    {{ $report->description }}
                                </p>
                            @endif
                        </div>

                        @if($report->attachment)
                            <a href="{{ asset('storage/'.$report->attachment) }}" 
                               class="btn-download" target="_blank">
                                View Report
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        @if($committee->reports->count() > 5)
            <button id="btn-load-more" class="btn-show-more">
                Show More Reports
            </button>
        @endif
    @endif

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('btn-load-more');

    if (btn) {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.hidden-report')
                .forEach(el => el.style.display = 'block');

            btn.style.display = 'none';
        });
    }
});
</script>

@endsection