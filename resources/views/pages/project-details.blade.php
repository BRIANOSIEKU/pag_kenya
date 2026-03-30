@extends('layouts.app')

@section('content')
<div style="max-width:800px; margin:0 auto; padding:20px;">
    <h2>{{ $project->title }}</h2>

    @if($project->image)
        <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}" style="width:100%; max-height:400px; object-fit:cover; margin-bottom:15px; border-radius:6px;">
    @endif

    <p><strong>Description:</strong></p>
    <p>{!! nl2br(e($project->description)) !!}</p>

    <p><strong>Progress:</strong> {{ $project->progress ?? 'N/A' }}</p>

    <a href="{{ route('projects.public.index') }}" style="display:inline-block; margin-top:20px; color:#4CAF50;">&larr; Back to Projects</a>
</div>
@endsection
