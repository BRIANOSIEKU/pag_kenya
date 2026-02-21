@extends('layouts.app') {{-- Use your public layout --}}

@section('content')
<div class="container" style="padding: 60px 20px;">

    <h1 class="page-title" style="text-align:center; font-family: 'Playfair Display', serif; font-size:2.2rem; color:#0f3c78; margin-bottom:40px;">
        PAG Kenya HQ Staff
    </h1>

    @if($staffs->isEmpty())
        <p style="text-align:center; font-size:1.1rem; color:#555;">No HQ staff found at the moment.</p>
    @else
        <div class="staff-grid">
            @foreach($staffs as $staff)
            <div class="staff-card">
                <div class="staff-photo">
                    @if($staff->photo && file_exists(public_path($staff->photo)))
                        <img src="{{ asset($staff->photo) }}" alt="{{ $staff->full_name }}">
                    @else
                        <img src="{{ asset('images/default-avatar.png') }}" alt="Default Staff Photo">
                    @endif
                </div>
                <div class="staff-info">
                    <h3>{{ $staff->full_name }}</h3>
                    <p class="position">{{ $staff->position }}</p>
                    <p class="email">{{ $staff->email }}</p>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>

<style>
/* Staff Grid */
.staff-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 30px;
    justify-items: center;
    align-items: stretch;
}

/* Staff Card */
.staff-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    overflow: hidden;
    text-align: center;
    width: 100%;
    max-width: 250px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.staff-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

/* Photo */
.staff-photo img {
    width: 100%;
    height: 250px;
    object-fit: cover;
}

/* Info */
.staff-info {
    padding: 15px 10px;
}

.staff-info h3 {
    font-family: 'Playfair Display', serif;
    font-size: 1.2rem;
    color: #0f3c78;
    margin-bottom: 5px;
}

.staff-info .position {
    font-family: 'Inter', sans-serif;
    font-size: 0.95rem;
    color: #4CAF50;
    margin-bottom: 5px;
}

.staff-info .email {
    font-family: 'Inter', sans-serif;
    font-size: 0.85rem;
    color: #555;
    word-wrap: break-word;
}

/* Responsive */
@media(max-width: 768px) {
    .staff-card {
        max-width: 45%;
    }
}

@media(max-width: 500px) {
    .staff-card {
        max-width: 100%;
    }
}
</style>
@endsection
