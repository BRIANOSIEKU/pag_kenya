@extends('layouts.app') {{-- Your public layout --}}

@section('content')

<div style="max-width:1200px; margin:40px auto; padding:20px;">

    {{-- Department Header --}}
    <div style="text-align:center; margin-bottom:30px;">
        @if($department->photo)
            <div class="department-header-photo-wrapper">
                <img src="{{ asset('storage/departments_photos/'.$department->photo) }}"
                     class="department-header-photo">
                @if($department->leadership)
                    <div class="leadership-badge">
                        {{ $department->leadership }}
                    </div>
                @endif
            </div>
        @endif

        <h1 class="department-title">
            {{ $department->name }}
        </h1>
    </div>

    {{-- Overview --}}
    @if($department->overview)
        <div class="white-card">
            <h2 class="section-title">Overview</h2>
            <p class="section-text">{!! nl2br(e($department->overview)) !!}</p>
        </div>
    @endif

    {{-- Activities --}}
    @if($department->activities)
        <div class="white-card">
            <h2 class="section-title">Activities</h2>
            <p class="section-text">{!! nl2br(e($department->activities)) !!}</p>
        </div>
    @endif

    {{-- Achievements --}}
    <div class="white-card">
        <h2 class="section-title" style="margin-bottom:20px;">Achievements</h2>

        @if($department->achievements->count())
            <div class="achievements-grid">
                @foreach($department->achievements as $achievement)
                    <div class="achievement-card">
                        
                        @if($achievement->photo)
                            <img src="{{ asset('storage/departments_achievements/'.$achievement->photo) }}"
                                 class="achievement-photo">
                        @endif

                        <h4>{{ $achievement->name }}</h4>

                        @if($achievement->description)
                            <p>{{ $achievement->description }}</p>
                        @endif

                        @if($achievement->date)
                            <small>{{ \Carbon\Carbon::parse($achievement->date)->format('d M Y') }}</small>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <p style="color:#555;">No achievements yet.</p>
        @endif
    </div>

</div>

{{-- Styles --}}
<style>

/* White Content Cards */
.white-card {
    background: #ffffff;
    padding: 30px;
    border-radius: 12px;
    margin-bottom: 35px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
}

.white-card:hover {
    box-shadow: 0 12px 30px rgba(0,0,0,0.08);
}

/* Section Titles */
.section-title {
    color: #d4af37;
    font-weight: 700;
    margin-bottom: 15px;
}

/* Section Text */
.section-text {
    line-height: 1.8;
    font-size: 1rem;
    color: #333;
}

/* Department Header Photo & Leadership Badge */
.department-header-photo-wrapper {
    position: relative;
    display: inline-block;
}

.department-header-photo {
    width: 150px;
    height: 150px;
    object-fit: cover;
    border-radius: 8px;
    border: 2px solid #d4af37;
    transition: all 0.3s ease;
}

.leadership-badge {
    position: absolute;
    bottom: -25px;
    left: 50%;
    transform: translateX(-50%);
    background: #d4af37;
    color: #fff;
    padding: 4px 8px;
    font-size: 0.85rem;
    border-radius: 4px;
    white-space: nowrap;
    transition: all 0.3s ease;
}

/* Department Title */
.department-title {
    margin-top: 40px;
    font-family: 'Playfair Display', serif;
    font-weight: 700;
    color: #0f3c78;
}

/* Achievements Grid */
.achievements-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
}

.achievement-card {
    border: 1px solid #eee;
    border-radius: 10px;
    padding: 18px;
    background: #fff;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    text-align: center;
    cursor: pointer;
}

.achievement-photo {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 6px;
    margin-bottom: 10px;
    display: block;
    margin-left: auto;
    margin-right: auto;
}

.achievement-card h4 {
    font-weight: 600;
    color: #0f3c78;
    margin-bottom: 8px;
    font-size: 1rem;
}

.achievement-card p {
    color: #333;
    line-height: 1.5;
    font-size: 0.9rem;
    margin-bottom: 5px;
}

.achievement-card small {
    color: #777;
    display: block;
    font-size: 0.8rem;
}

.achievement-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(212,175,55,0.25);
}

/* Responsive tweaks */
@media (max-width: 768px) {
    .white-card {
        padding: 20px;
    }

    .department-header-photo {
        width: 120px;
        height: 120px;
    }

    .achievements-grid {
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    }
}

@media (max-width: 480px) {
    .white-card {
        padding: 18px;
    }

    .department-header-photo {
        width: 100px;
        height: 100px;
    }

    .achievements-grid {
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    }
}

</style>

@endsection