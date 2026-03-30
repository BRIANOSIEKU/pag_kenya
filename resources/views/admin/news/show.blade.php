@extends('layouts.admin')

@section('content')
<h1>{{ $news->title }}</h1>

@if($news->photos && $news->photos->count() > 0)
    <div style="display:flex; flex-wrap:wrap; gap:10px; margin-bottom:15px;">
        @foreach($news->photos as $photo)
            <div style="flex: 1 1 150px; max-width:150px;">
                <img src="{{ asset('uploads/news/' . $photo->image) }}" alt="News Photo" style="width:100%; height:auto; border-radius:6px; border:1px solid #ddd;">
            </div>
        @endforeach
    </div>
@endif

<p>{{ $news->content }}</p>
<p><small>Posted on {{ $news->created_at->format('d M Y') }}</small></p>

<a href="{{ route('admin.news.index') }}" style="padding:6px 10px; background:#2196F3; color:#fff; border-radius:6px; text-decoration:none;">Back to News</a>
@endsection
