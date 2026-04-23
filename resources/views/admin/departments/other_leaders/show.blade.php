@extends('layouts.admin')

@section('content')

<style>
    .page-wrapper {
        padding: 20px;
    }

    .top-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        margin-bottom: 20px;
        gap: 10px;
    }

    .btn {
        padding: 9px 14px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 14px;
        display: inline-block;
        color: white;
        border: none;
    }

    .btn-back {
        background: #607D8B;
    }

    .card {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        max-width: 800px;
        margin: auto;
    }

    .profile-header {
        display: flex;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .profile-img {
        width: 120px;
        height: 120px;
        border-radius: 12px;
        object-fit: cover;
        border: 1px solid #eee;
    }

    .profile-name {
        font-size: 22px;
        font-weight: 600;
        margin: 0;
    }

    .profile-position {
        color: #666;
        font-size: 14px;
        margin-top: 4px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-top: 20px;
    }

    .info-box {
        background: #f8f9fa;
        padding: 12px;
        border-radius: 8px;
        font-size: 14px;
    }

    .label {
        font-weight: 600;
        color: #333;
        display: block;
        margin-bottom: 5px;
    }

    /* MOBILE */
    @media (max-width: 768px) {

        .profile-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .card {
            padding: 15px;
        }
    }
</style>

<div class="page-wrapper">

    {{-- TOP BAR --}}
    <div class="top-bar">

        <a href="{{ route('admin.departments.other-leaders.index', $department->id) }}"
           class="btn btn-back">
            ← Back
        </a>

    </div>

    {{-- PROFILE CARD --}}
    <div class="card">

        <div class="profile-header">

            {{-- PHOTO --}}
            @if($leader->photo)
                <img src="{{ asset('storage/' . $leader->photo) }}"
                     class="profile-img">
            @else
                <img src="https://via.placeholder.com/120"
                     class="profile-img">
            @endif

            {{-- NAME + POSITION --}}
            <div>
                <h2 class="profile-name">{{ $leader->name }}</h2>
                <div class="profile-position">{{ $leader->position }}</div>
            </div>

        </div>

        {{-- DETAILS --}}
        <div class="info-grid">

            <div class="info-box">
                <span class="label">Department</span>
                {{ $leader->department->name ?? '-' }}
            </div>

            <div class="info-box">
                <span class="label">Position</span>
                {{ $leader->position }}
            </div>

            <div class="info-box">
                <span class="label">Created At</span>
                {{ $leader->created_at->format('d M Y') }}
            </div>

            <div class="info-box">
                <span class="label">Updated At</span>
                {{ $leader->updated_at->format('d M Y') }}
            </div>

        </div>

    </div>

</div>

@endsection