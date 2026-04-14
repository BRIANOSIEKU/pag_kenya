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

/* CONTAINER */
.citam-container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 70px 20px;
}

/* TITLE */
.citam-title {
    font-size: 44px;
    font-weight: 900;
    text-align: center;
    margin-bottom: 50px;
    position: relative;
    padding-bottom: 15px;
    color: var(--citam-blue);
    letter-spacing: -1px;
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

/* SECTION HEAD */
.citam-section-head {
    font-size: 26px;
    font-weight: 700;
    margin: 60px 0 25px;
    color: var(--citam-dark);
    text-transform: uppercase;
    position: relative;
    padding-bottom: 10px;
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

/* OVERVIEW */
.citam-overview {
    font-size: 17px;
    color: var(--citam-gray);
    margin-bottom: 60px;
    padding: 25px 35px;
    border-left: 5px solid var(--citam-gold);
    background: #fdfdfd;
}

/* =========================
   LEADERSHIP FIXED SECTION
========================= */

.leadership-row {
    display: flex;
    flex-wrap: wrap;
    gap: 30px;
    justify-content: center;
}

/* CARD */
.leader-item {
    flex: 1;
    min-width: 220px;
    max-width: 240px;
    text-align: center;
    padding: 15px;
}

/* ✅ UNIFORM IMAGE SIZE FIX */
.leader-photo-citam {
    width: 160px;
    height: 160px;       /* FIXED HEIGHT */
    object-fit: cover;   /* CROPS IMAGE UNIFORMLY */
    border-radius: 50%;  /* MAKES IT CIRCULAR (cleaner look) */
    margin-bottom: 12px;
    box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    border: 4px solid #fff;
}

/* MEMBERS */
.member-row-citam {
    display: flex;
    justify-content: space-between;
    padding: 14px 0;
    border-bottom: 1px solid #eee;
}

/* REPORTS */
.report-card {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    border: 1px solid #eee;
    margin-bottom: 12px;
    border-radius: 6px;
}

.report-card:hover {
    border-color: var(--citam-gold);
    background: #fffcf5;
}

.hidden-report {
    display: none;
}

.btn-download {
    background: var(--citam-dark);
    color: #fff;
    padding: 10px 18px;
    border-radius: 5px;
    text-decoration: none;
    font-size: 13px;
}

.btn-download:hover {
    background: var(--citam-blue);
}

.btn-show-more {
    display: block;
    margin: 30px auto;
    padding: 12px 25px;
    border: 2px solid var(--citam-blue);
    background: white;
    color: var(--citam-blue);
    font-weight: bold;
    cursor: pointer;
}

.btn-show-more:hover {
    background: var(--citam-blue);
    color: white;
}
</style>

<div class="citam-container">

    <!-- TITLE -->
    <h1 class="citam-title">{{ $committee->name }}</h1>

    {{-- LEADERS --}}
    @if($committee->leaders && $committee->leaders->count())
        <h2 class="citam-section-head">Leadership</h2>

        <div class="leadership-row">
            @foreach($committee->leaders as $leader)

                @php
                    $photo = $leader->pivot->photo
                        ? asset('storage/leaders_photos/'.$leader->pivot->photo)
                        : asset('images/default-profile.png');
                @endphp

                <div class="leader-item">
                    <img src="{{ $photo }}" class="leader-photo-citam">

                    <div style="color:var(--citam-gold);font-size:12px;font-weight:700;">
                        {{ $leader->pivot->role ?? 'Officer' }}
                    </div>

                    <div style="font-size:18px;font-weight:700;">
                        {{ $leader->name }}
                    </div>
                </div>

            @endforeach
        </div>
    @endif

    {{-- MEMBERS --}}
    @if($committee->members && $committee->members->count())
        <h2 class="citam-section-head">Committee Members</h2>

        @foreach($committee->members as $index => $member)
            <div class="member-row-citam">
                <div>
                    <strong style="color:var(--citam-gold);margin-right:10px;">
                        {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                    </strong>
                    {{ $member->member_name }}
                </div>

                <div style="font-size:12px;color:#888;text-transform:uppercase;">
                    {{ $member->member_gender }}
                </div>
            </div>
        @endforeach
    @endif

    {{-- OVERVIEW --}}
    @if(!empty($committee->overview))
        <h2 class="citam-section-head">Overview</h2>

        <div class="citam-overview">
            {!! $committee->overview !!}
        </div>
    @endif

    {{-- REPORTS --}}
    @if($committee->reports && $committee->reports->count())
        <h2 class="citam-section-head">Reports</h2>

        <div id="reports-list">
            @foreach($committee->reports as $index => $report)
                <div class="report-wrapper {{ $index >= 5 ? 'hidden-report' : '' }}">

                    <div class="report-card">
                        <div>
                            <div style="font-size:12px;color:var(--citam-gold);font-weight:700;">
                                {{ \Carbon\Carbon::parse($report->report_date)->format('M d, Y') }}
                            </div>

                            <div style="font-size:18px;font-weight:700;">
                                {{ $report->title }}
                            </div>

                            @if($report->description)
                                <div style="font-size:14px;color:#666;">
                                    {{ $report->description }}
                                </div>
                            @endif
                        </div>

                        @if($report->attachment)
                            <a href="{{ asset('storage/'.$report->attachment) }}"
                               class="btn-download" target="_blank">
                                View
                            </a>
                        @endif
                    </div>

                </div>
            @endforeach
        </div>

        @if($committee->reports->count() > 5)
            <button id="btn-load-more" class="btn-show-more">
                Show More
            </button>
        @endif
    @endif

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('btn-load-more');

    if (btn) {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.hidden-report')
                .forEach(el => el.style.display = 'block');

            btn.style.display = 'none';
        });
    }
});
</script>

@endsection