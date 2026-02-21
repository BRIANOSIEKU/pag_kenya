@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 style="margin-bottom:20px;">Daily Devotions</h1>

    @if($devotions->count() > 0)
        @foreach($devotions as $devotion)
            <div style="border:1px solid #ddd; border-radius:8px; padding:15px; margin-bottom:15px; box-shadow:0 2px 6px rgba(0,0,0,0.05);">
                
                @if($devotion->thumbnail)
                    <div style="margin-bottom:10px;">
                        <img src="{{ asset($devotion->thumbnail) }}" alt="Thumbnail" style="max-width:100%; border-radius:6px;">
                    </div>
                @endif

                <h3 style="margin-bottom:5px;">{{ $devotion->title }}</h3>
                <p style="color:#555; font-size:0.9rem; margin-bottom:10px;">
                    <strong>Author:</strong> {{ $devotion->author }} | 
                    <strong>Date:</strong> {{ \Carbon\Carbon::parse($devotion->date)->format('M d, Y') }}
                </p>

                <div style="white-space: pre-line; line-height:1.6; color:#333;">
                    {{ $devotion->content }}
                </div>
            </div>
        @endforeach
    @else
        <p>No devotions available at the moment. Check back soon!</p>
    @endif
</div>
@endsection
