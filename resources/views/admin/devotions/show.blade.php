@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <!-- Back to Devotions button at the top -->
<a href="{{ route('admin.devotions.index') }}" style="padding:8px 12px; background:#2196F3; color:#fff; border-radius:6px; text-decoration:none; margin-bottom:15px; display:inline-block;">
    &larr; Back to Devotions
</a>
    <div class="card shadow-sm">
        <div class="card-body">
            <h2 class="card-title">{{ $devotion->title }}</h2>
            <p class="text-muted">
                <strong>Author:</strong> {{ $devotion->author }} | 
                <strong>Date:</strong> {{ \Carbon\Carbon::parse($devotion->date)->format('M d, Y') }}
            </p>

            @if($devotion->thumbnail)
                <div class="mb-3">
                    <img src="{{ asset($devotion->thumbnail) }}" alt="Thumbnail" class="img-fluid rounded shadow-sm">
                </div>
            @endif

            <div class="card-text" style="white-space: pre-line;">
                {{ $devotion->content }}
            </div>
        </div>
    </div>
</div>
@endsection
