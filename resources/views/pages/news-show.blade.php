@extends('layouts.app') <!-- Or your public layout -->

@section('content')

<!-- ================= NEWS DETAIL ================= -->
<section id="news-detail" style="padding:60px 20px; background:#f9f9f9;">
    <div style="max-width:900px; margin:0 auto;">

        <!-- News Title -->
        <h1 style="font-family:'Playfair Display', serif; font-weight:700; color:#0f3c78; margin-bottom:20px;">
            {{ $news->title }}
        </h1>

        <!-- Posted Date -->
        <p style="font-family:'Inter', sans-serif; color:#555; margin-bottom:20px;">
            <small>Posted on {{ $news->created_at->format('d M Y') }}</small>
        </p>

        <!-- News Images -->
        @if($news->photos && $news->photos->count() > 0)
            <div style="display:flex; flex-wrap:wrap; gap:15px; margin-bottom:30px; justify-content:center;">
                @foreach($news->photos as $photo)
                    <div style="flex:1 1 200px; max-width:250px;">
                        <img src="{{ asset('uploads/news/' . $photo->image) }}" 
                             alt="News Photo" 
                             style="width:100%; height:auto; border-radius:8px; border:1px solid #ddd; object-fit:cover;">
                    </div>
                @endforeach
            </div>
        @endif

        <!-- News Content -->
        <div style="font-family:'Inter', sans-serif; color:#333; line-height:1.7; margin-bottom:30px;">
            {!! nl2br(e($news->content)) !!}
        </div>

        <!-- Back Button -->
        <a href="{{ url('/#news') }}" 
           style="display:inline-block; padding:10px 16px; background:#2196F3; color:#fff; border-radius:6px; text-decoration:none; transition:0.3s;"
           onmouseover="this.style.backgroundColor='#0f3c78';"
           onmouseout="this.style.backgroundColor='#2196F3';">
            ← Back to News
        </a>

    </div>
</section>

@endsection
