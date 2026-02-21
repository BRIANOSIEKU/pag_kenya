@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-5">PAG Kenya HQ Staff</h1>

    <div class="hq-staff-grid">
        @forelse($leaders as $staff)
            <div class="hq-card">
                @if($staff->photo)
                    <img src="{{ asset($staff->photo) }}" alt="{{ $staff->full_name }}">
                @else
                    <img src="{{ asset('images/default-profile.png') }}" alt="No photo">
                @endif
                <h5>{{ $staff->full_name }}</h5>
                <p>{{ $staff->position }}</p>
            </div>
        @empty
            <p class="text-center">No HQ Staff found.</p>
        @endforelse
    </div>
</div>

<style>
.hq-staff-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 20px;
    justify-items: center;
}

.hq-card {
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    text-align: center;
    padding: 15px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    width: 100%;
    max-width: 220px;
}

.hq-card img {
    width: 100%;
    height: 220px;
    object-fit: cover;
    border-radius: 8px;
    margin-bottom: 12px;
}

.hq-card h5 {
    font-weight: 600;
    margin-bottom: 4px;
    font-size: 1rem;
    color: #1e3c72;
}

.hq-card p {
    font-size: 0.85rem;
    color: #555;
    margin: 0;
}

.hq-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

/* Responsive tweaks */
@media (max-width: 1200px) {
    .hq-staff-grid {
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    }
}

@media (max-width: 768px) {
    .hq-staff-grid {
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    }
}
</style>
@endsection
