@extends('layouts.app')

@section('content')

<div class="page-wrapper">

    {{-- SIMPLE PAGE TITLE (NO HERO SECTION) --}}
    <h1 class="page-title">
        EXECUTIVE OFFICE STAFF
    </h1>

    {{-- STAFF SECTION --}}
    <div class="staff-container">

        @if($staffs->isEmpty())
            <p class="empty-text">No HQ staff found at the moment.</p>
        @else
            <div class="staff-grid">

                @foreach($staffs as $staff)
                <div class="staff-card animate-on-scroll">

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

</div>

<style>

/* PAGE WRAPPER */
.page-wrapper{
    padding: 40px 20px 80px;
}

/* SIMPLE TITLE (NO HERO) */
.page-title{
    text-align: center;
    font-family: 'Playfair Display', serif;
    font-size: 2.6rem;
    color: #0f3c78;
    margin-bottom: 30px;
    position: relative;
}

/* subtle underline */
.page-title::after{
    content: '';
    display: block;
    width: 80px;
    height: 4px;
    background: orange;
    margin: 10px auto 0;
    border-radius: 2px;
}

/* EMPTY STATE */
.empty-text{
    text-align:center;
    font-size:1.1rem;
    color:#666;
    margin-top: 40px;
}

/* STAFF GRID */
.staff-grid{
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 22px;
    justify-items: center;
}

/* STAFF CARD */
.staff-card{
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 3px 12px rgba(0,0,0,0.08);
    overflow: hidden;
    text-align: center;
    width: 100%;
    max-width: 200px;
    transition: 0.3s ease;
    opacity: 0;
    transform: translateY(25px);
}

.staff-card:hover{
    transform: translateY(-6px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.12);
}

/* IMAGE */
.staff-photo img{
    width: 100%;
    height: 180px;
    object-fit: cover;
}

/* INFO */
.staff-info{
    padding: 12px 10px;
}

.staff-info h3{
    font-size: 1rem;
    color: #0f3c78;
    margin-bottom: 4px;
    font-family: 'Playfair Display', serif;
}

.staff-info .position{
    font-size: 0.85rem;
    color: #2e7d32;
    margin-bottom: 3px;
}

.staff-info .email{
    font-size: 0.75rem;
    color: #555;
    word-break: break-word;
}

/* ANIMATION */
.animate-on-scroll.show{
    opacity: 1;
    transform: translateY(0);
}

/* MOBILE */
@media(max-width: 600px){
    .page-title{
        font-size: 2rem;
    }
}

</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const cards = document.querySelectorAll('.animate-on-scroll');

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if(entry.isIntersecting){
                entry.target.classList.add('show');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.15 });

    cards.forEach(card => observer.observe(card));
});
</script>

@endsection