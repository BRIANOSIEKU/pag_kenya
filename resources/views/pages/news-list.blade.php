@extends('layouts.app') <!-- Your public layout -->

@section('content')

<!-- ================= NEWS LIST ================= -->
<section id="news" style="padding:60px 20px; background:#f9f9f9;">
    <div style="max-width:1100px; margin:0 auto;">

        <h1 style="font-family:'Playfair Display', serif; font-weight:700; color:#0f3c78; margin-bottom:40px; text-align:center;">
            News & Updates
        </h1>

        <div style="display:flex; flex-wrap:wrap; gap:30px; justify-content:center;">

            @foreach($news as $item)
                <div style="flex:1 1 300px; max-width:350px; background:#fff; border-radius:8px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.1); transition:transform 0.3s;">
                    
                    <!-- Thumbnail -->
                    @php
                        $firstPhoto = $item->photos->first();
                    @endphp
                    @if($firstPhoto)
                        <img src="{{ asset('uploads/news/' . $firstPhoto->image) }}" 
                             alt="News Image" 
                             style="width:100%; height:200px; object-fit:cover;">
                    @else
                        <div style="width:100%; height:200px; background:#ccc; display:flex; align-items:center; justify-content:center; color:#555;">
                            No Image
                        </div>
                    @endif

                    <div style="padding:15px;">
                        <!-- Clickable Title -->
                        <a href="{{ route('news.show', $item->id) }}" 
                           style="font-family:'Playfair Display', serif; font-weight:700; font-size:1.1rem; color:#0f3c78; text-decoration:none; display:block; margin-bottom:10px; transition:color 0.3s;"
                           onmouseover="this.style.color='#d4af37';"
                           onmouseout="this.style.color='#0f3c78';">
                            {{ $item->title }}
                        </a>

                        <!-- Short excerpt -->
                        <p style="font-family:'Inter', sans-serif; color:#555; line-height:1.5; font-size:0.95rem;">
                            {{ Str::limit($item->content, 100) }}
                        </p>

                        <!-- Posted Date -->
                        <p style="font-family:'Inter', sans-serif; font-size:0.8rem; color:#999;">
                            {{ $item->created_at->format('d M Y') }}
                        </p>
                    </div>
                </div>
            @endforeach

        </div>

        <!-- Pagination -->
        <div style="margin-top:30px; display:flex; justify-content:center;">
            {{ $news->links() }}
        </div>

    </div>
</section>

@endsection
