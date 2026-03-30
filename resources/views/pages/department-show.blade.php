@extends('layouts.app')

@section('content')

<div class="department-wrapper">

    {{-- Department Title --}}
    <h1 class="department-title">{{ $department->name }}</h1>

    <div class="department-card">

        {{-- LEFT: Photo + Leader + Leadership + Vertical Gallery --}}
        <div class="department-left">
            @if($department->photo)
                <img src="{{ asset('storage/departments_photos/'.$department->photo) }}" 
                     class="department-photo" 
                     alt="{{ $department->name }}">
            @endif

            {{-- Leader Name --}}
            @if($department->leader_name)
                <h2 class="leader-name">{{ $department->leader_name }}</h2>
            @endif

            {{-- Leadership Badge --}}
            @if($department->leadership)
                <div class="leadership-badge">{{ $department->leadership }}</div>
            @endif

            {{-- Vertical Gallery --}}
            @if($department->galleryImages && $department->galleryImages->count())
            <div class="white-card gallery-card">
                <h2 class="section-title" style="font-size: 1rem; margin-bottom: 12px;">Gallery</h2>
                <div class="gallery-vertical">
                    @php
                        $images = $department->galleryImages->sortByDesc('id'); // latest first
                        $initialCount = 4;
                    @endphp
                    @foreach($images as $index => $image)
                        <div class="gallery-item-vertical {{ $index >= $initialCount ? 'hidden-image' : '' }}">
                            <img src="{{ asset('storage/departments_gallery/'.$image->image_path) }}" 
                                 alt="{{ $image->caption ?? 'Gallery image' }}" 
                                 class="gallery-photo-vertical lightbox-trigger" data-index="{{ $index }}" loading="lazy">>
                                 
                        </div>
                    @endforeach
                </div>
                @if(count($images) > $initialCount)
                    <button id="view-more-btn" class="view-more-btn">Click to view more</button>
                @endif
            </div>
            @endif
        </div>

        {{-- RIGHT: Overview + Activities --}}
        <div class="department-right">
            @if($department->overview)
                <div class="white-card">
                    <h2 class="section-title">Overview</h2>
                    <p class="section-text">{!! nl2br(e($department->overview)) !!}</p>
                </div>
            @endif

            @if($department->activities)
                <div class="white-card">
                    <h2 class="section-title">Activities</h2>
                    <p class="section-text">{!! nl2br(e($department->activities)) !!}</p>
                </div>
            @endif
        </div>

    </div>

    {{-- Achievements --}}
    @if($department->achievements && $department->achievements->count())
        <div class="white-card">
            <h2 class="section-title">Achievements</h2>
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
        </div>
    @endif

</div>

{{-- Lightbox Modal --}}
<div id="lightbox-modal" class="lightbox-modal">
    <span class="lightbox-close">&times;</span>
    <img class="lightbox-content" id="lightbox-img">
    <a class="lightbox-prev">&#10094;</a>
    <a class="lightbox-next">&#10095;</a>
</div>

{{-- Styles --}}
<style>
:root {
    --primary: #0f172a;
    --accent: #c8a951;
    --soft-bg: #f8fafc;
}

body {
    background: var(--soft-bg);
    font-family: 'Inter', sans-serif;
}

.department-wrapper {
    max-width: 1200px;
    margin: 40px auto;
    padding: 20px;
    text-align: center;
}

/* Department Title */
.department-title {
    font-family: 'Playfair Display', serif;
    font-weight: 700;
    font-size: 40px;
    color: var(--primary);
    margin-bottom: 40px;
}

/* Department Card */
.department-card {
    display: flex;
    gap: 40px;
    flex-wrap: wrap;
    align-items: flex-start;
    justify-content: center;
}

/* LEFT Column */
.department-left {
    flex: 0 0 350px;
    text-align: center;
}

/* Department photo */
.department-photo {
    width: 100%;
    max-width: 350px;
    height: auto;
    border-radius: 16px;
    box-shadow: 0 20px 40px rgba(255,255,255,0.2), 0 10px 20px rgba(0,0,0,0.15);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.department-photo:hover {
    transform: scale(1.03);
}

/* Leader + Badge */
.leader-name {
    font-weight: 600;
    font-size: 20px;
    color: #4B3B2B;
    margin-top: 20px;
}

.leadership-badge {
    display: inline-block;
    margin-top: 8px;
    background: var(--accent);
    color: #fff;
    padding: 5px 12px;
    font-size: 0.9rem;
    border-radius: 6px;
    font-weight: 600;
}

/* RIGHT Column */
.department-right {
    flex: 1;
    min-width: 300px;
}

/* White Cards */
.white-card {
    background: #ffffff;
    padding: 25px;
    border-radius: 16px;
    margin-bottom: 25px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.05);
}

.section-title {
    color: var(--accent);
    font-weight: 700;
    margin-bottom: 12px;
}

.section-text {
    line-height: 1.8;
    font-size: 1rem;
    color: #333;
    text-align: justify;
}

/* Achievements */
.achievements-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
}

.achievement-card {
    border: 1px solid #eee;
    border-radius: 12px;
    padding: 20px;
    background: #fff;
    text-align: center;
}

.achievement-photo {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 12px;
    margin-bottom: 12px;
}

/* Vertical Gallery */
.gallery-card {
    width: 100%;
    padding: 10px;
    margin-top: 40px;
}

.gallery-vertical {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.gallery-item-vertical img {
    width: 100%;
    height: auto;
    border-radius: 12px;
    cursor: pointer;
    transition: transform 0.3s ease;
}

.gallery-item-vertical img:hover {
    transform: scale(1.03);
}

.hidden-image {
    display: none;
}

.view-more-btn {
    margin-top: 10px;
    padding: 8px 14px;
    border: none;
    background-color: var(--accent);
    color: white;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
}

/* Lightbox */
.lightbox-modal {
    display: none;
    position: fixed;
    z-index: 999;
    left: 0; top: 0;
    width: 100%; height: 100%;
    background-color: rgba(0,0,0,0.9);
    padding-top: 150px;
}

.lightbox-content {
    margin: auto;
    display: block;
    max-width: 90%;
    max-height: 80%;
    border-radius: 12px;
}

.lightbox-close {
    position: absolute;
    top: 30px;
    right: 30px;
    color: white;
    font-size: 36px;
    font-weight: bold;
    cursor: pointer;
}

/* Next/Prev Arrows */
.lightbox-prev,
.lightbox-next {
    cursor: pointer;
    position: absolute;
    top: 50%;
    padding: 16px;
    color: white;
    font-weight: bold;
    font-size: 36px;
    user-select: none;
    transform: translateY(-50%);
}

.lightbox-prev { left: 30px; }
.lightbox-next { right: 30px; }

/* Responsive */
@media (max-width: 992px) {
    .department-card {
        flex-direction: column;
        align-items: center;
    }
    .department-left, .department-right {
        width: 100%;
    }
}
</style>

{{-- Lightbox Script --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const lightboxModal = document.getElementById('lightbox-modal');
    const lightboxImg = document.getElementById('lightbox-img');
    const closeBtn = document.querySelector('.lightbox-close');
    const prevBtn = document.querySelector('.lightbox-prev');
    const nextBtn = document.querySelector('.lightbox-next');
    const triggers = document.querySelectorAll('.lightbox-trigger');
    const viewMoreBtn = document.getElementById('view-more-btn');

    let currentIndex = 0;
    const images = Array.from(triggers);

    function showLightbox(index) {
        currentIndex = index;
        lightboxImg.src = images[currentIndex].src;
        lightboxModal.style.display = 'block';

        // ✅ Smooth scroll to top so image is fully visible
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    images.forEach((img, idx) => {
        img.addEventListener('click', () => showLightbox(idx));
    });

    function closeLightbox() {
        lightboxModal.style.display = 'none';
    }

    function showPrev() {
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        lightboxImg.src = images[currentIndex].src;
    }

    function showNext() {
        currentIndex = (currentIndex + 1) % images.length;
        lightboxImg.src = images[currentIndex].src;
    }

    closeBtn.addEventListener('click', closeLightbox);
    prevBtn.addEventListener('click', showPrev);
    nextBtn.addEventListener('click', showNext);

    // क्लिक outside closes modal
    lightboxModal.addEventListener('click', function(e) {
        if(e.target === lightboxModal) closeLightbox();
    });

    // ✅ Keyboard controls
    document.addEventListener('keydown', function(e) {
        if (lightboxModal.style.display === 'block') {
            if (e.key === 'ArrowLeft') {
                showPrev();
            } else if (e.key === 'ArrowRight') {
                showNext();
            } else if (e.key === 'Escape') {
                closeLightbox();
            }
        }
    });

    // ✅ View More Button
    if(viewMoreBtn){
        viewMoreBtn.addEventListener('click', () => {
            document.querySelectorAll('.hidden-image').forEach(img => img.style.display = 'block');
            viewMoreBtn.style.display = 'none';
        });
    }
});
</script>

@endsection