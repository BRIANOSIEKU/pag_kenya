@extends('layouts.app')

@section('content')

@php
use Illuminate\Support\Facades\Storage;
@endphp

<div class="department-wrapper">

    {{-- ================= TITLE ================= --}}
    <h1 class="department-title">
        {{ $department->name ?? 'Department' }}
    </h1>

    {{-- ================= LEADERS ================= --}}
    <div class="leaders-row">

        {{-- DIRECTOR --}}
        <div class="leader-card">

            @php
                $directorPhoto = $department->photo
                    ? Storage::url('departments_photos/'.$department->photo)
                    : asset('images/default-user.png');
            @endphp

            <img src="{{ $directorPhoto }}"
                 class="leader-img"
                 onerror="this.src='{{ asset('images/default-user.png') }}'">

            <div class="leader-info">
                <h3>{{ $department->leadership ?? 'Director' }}</h3>
                <span class="badge">Leader</span>
            </div>

        </div>

        {{-- OTHER LEADERS --}}
        @forelse($department->otherLeaders ?? [] as $leader)

            @php
                $photo = str_replace([
                    'other_leaders/',
                    'storage/other_leaders/',
                    '/storage/other_leaders/'
                ], '', $leader->photo);

                $leaderPhoto = $photo
                    ? asset('storage/other_leaders/'.$photo)
                    : asset('images/default-user.png');
            @endphp

            <div class="leader-card">

                <img src="{{ $leaderPhoto }}?v={{ time() }}"
                     class="leader-img"
                     onerror="this.src='{{ asset('images/default-user.png') }}'">

                <div class="leader-info">
                    <h3>{{ $leader->name }}</h3>
                    <span class="badge">{{ $leader->position }}</span>
                </div>

            </div>

        @empty
        @endforelse

    </div>

    {{-- ================= CONTENT ================= --}}
    <div class="content-row">

        <div class="main-content">

            @if($department->overview)
            <div class="white-card">
                <h2>Overview</h2>
                {!! $department->overview !!}
            </div>
            @endif

            @if($department->activities)
            <div class="white-card">
                <h2>Activities</h2>
                {!! $department->activities !!}
            </div>
            @endif

        </div>

        <div class="sidebar">

            {{-- EVENTS --}}
            <div class="white-card">
                <h3>Upcoming Events</h3>

                @forelse($department->upcomingEvents ?? [] as $event)

                    <div class="event-item">

                        @if($event->file)

                            @php
                                $file = str_replace([
                                    'department_events/',
                                    'storage/department_events/',
                                    '/storage/department_events/'
                                ], '', $event->file);

                                $eventUrl = asset('storage/department_events/'.$file);
                            @endphp

                            <a href="{{ $eventUrl }}" target="_blank">

                                @if(in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['jpg','jpeg','png','webp']))
                                    <img src="{{ $eventUrl }}"
                                         class="event-img">
                                @else
                                    <div class="doc-box">
                                        📄 Click to View Document
                                    </div>
                                @endif

                            </a>

                        @endif

                        <strong>{{ $event->title }}</strong><br>

                        @if($event->event_date)
                            <small>
                                {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}
                            </small>
                        @endif

                        <p>{{ $event->description }}</p>

                    </div>

                @empty
                    <p></p>
                @endforelse

            </div>

            {{-- GALLERY --}}
            <div class="white-card">
                <h3>Gallery</h3>

                <div class="gallery-vertical">

                    @forelse($department->galleryImages ?? [] as $image)

                        @php
                            $imgUrl = Storage::url('departments_gallery/'.$image->image_path);
                        @endphp

                        <a href="{{ $imgUrl }}" target="_blank">
                            <img src="{{ $imgUrl }}" class="gallery-img">
                        </a>

                    @empty
                        <p>No gallery images</p>
                    @endforelse

                </div>

            </div>

        </div>

    </div>

</div>

{{-- ================= STYLES ================= --}}
<style>

.department-wrapper {
    max-width: 1200px;
    margin: auto;
    padding: 30px;
    font-family: Arial;
}

.department-title {
    text-align: center;
    margin-bottom: 30px;
}

/* ================= LEADERS ================= */
.leaders-row {
    display: flex;
    justify-content: center;
    gap: 60px;
    flex-wrap: wrap;
    margin-bottom: 40px;
}

.leader-card {
    width: 230px;
    border-radius: 14px;
    overflow: hidden; /* KEY FIX */
    box-shadow: 0 3px 12px rgba(0,0,0,0.1);
    background: #fff;
}

.leader-img {
    width: 100%;
    height: 260px;
    object-fit: cover;
    display: block;
}

/* text under image */
.leader-info {
    padding: 10px;
    text-align: center;
}

.badge {
    display: inline-block;
    margin-top: 5px;
    padding: 5px 10px;
    background: #c8a951;
    color: #fff;
    border-radius: 6px;
    font-size: 12px;
}

/* ================= LAYOUT ================= */
.content-row {
    display: flex;
    gap: 25px;
}

.main-content { flex: 2; }
.sidebar { flex: 1; }

/* ================= CARDS ================= */
.white-card {
    background: #fff;
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

/* EVENTS */
.event-img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 10px;
    margin-bottom: 10px;
}

.doc-box {
    padding: 25px;
    background: #f2f2f2;
    border-radius: 10px;
    text-align: center;
    font-weight: bold;
}

/* GALLERY */
.gallery-vertical {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.gallery-img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    border-radius: 10px;
}

/* ================= MOBILE ONLY TEXT FIX ================= */
@media(max-width: 768px){

    .department-wrapper {
        padding: 10px;
    }

    .content-row {
        flex-direction: column;
        gap: 15px;
    }

    .white-card {
        padding: 12px;
        font-size: 14px;
        line-height: 1.6;
    }

    .department-title {
        font-size: 20px;
    }

    body {
        overflow-x: hidden;
    }
}

</style>

@endsection