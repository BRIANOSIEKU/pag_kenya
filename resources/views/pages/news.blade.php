@extends('layouts.app') <!-- Or your public layout -->

@section('content')

<!-- ================= NEWS & UPDATES ================= -->
<section id="news" style="padding:60px 20px; background:#f9f9f9;">
    <div style="max-width:1200px; margin:0 auto;">
        <h1 style="font-family:'Playfair Display', serif; font-weight:700; color:#0f3c78; margin-bottom:30px;">News & Updates</h1>

        @php
            use App\Models\News;
            $allNews = News::latest()->paginate(6); // adjust number per page
        @endphp

        @foreach($allNews as $newsItem)
            <div style="margin-bottom:50px; background:#fff; padding:20px; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.05);">
                
                <h2 style="font-family:'Playfair Display', serif; font-weight:600; color:#1e3c72; margin-bottom:10px;">{{ $newsItem->title }}</h2>
                
                <p style="font-family:'Inter', sans-serif; color:#555; margin-bottom:15px;">
                    <small>Posted on {{ $newsItem->created_at->format('d M Y') }}</small>
                </p>

                @if($newsItem->photos && $newsItem->photos->count() > 0)
                    <div style="display:flex; flex-wrap:wrap; gap:10px; margin-bottom:15px;">
                        @foreach($newsItem->photos as $photo)
                            <div style="flex:1 1 180px; max-width:180px;">
                                <img src="{{ asset('uploads/news/' . $photo->image) }}" 
                                     alt="News Photo" 
                                     style="width:100%; height:auto; border-radius:6px; border:1px solid #ddd;">
                            </div>
                        @endforeach
                    </div>
                @endif

                <p style="font-family:'Inter', sans-serif; color:#333; line-height:1.6;">{{ $newsItem->content }}</p>

                <a href="{{ route('news.show', $newsItem->id) }}" 
                   style="display:inline-block; margin-top:10px; padding:8px 12px; background:#4CAF50; color:#fff; border-radius:6px; text-decoration:none;">
                    Read More
                </a>
            </div>
        @endforeach

        <!-- Pagination -->
        <div style="margin-top:30px; text-align:center;">
            {{ $allNews->links() }}
        </div>
    </div>
</section>

@endsection
