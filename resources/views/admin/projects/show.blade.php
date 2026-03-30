@extends('layouts.admin')

@section('content')
<h2>Project Details</h2>

<div style="max-width:700px; border:1px solid #ddd; padding:20px; border-radius:8px; background:#fff; box-shadow:0 2px 6px rgba(0,0,0,0.1);">

    <h3 style="margin-bottom:10px;">{{ $project->title }}</h3>

    @if($project->image)
        <img src="{{ asset('storage/' . $project->image) }}" alt="Project Image" style="width:100%; max-height:400px; object-fit:cover; margin-bottom:15px; border-radius:6px;">
    @endif

    <p style="margin-bottom:10px;"><strong>Description:</strong></p>
    <p style="margin-bottom:15px;">{!! nl2br(e($project->description)) !!}</p>

    <p><strong>Progress:</strong> {{ $project->progress ?? 'N/A' }}</p>

    <div style="margin-top:20px; display:flex; gap:10px;">
        <a href="{{ route('admin.projects.edit', $project->id) }}" 
           style="background-color:#2196F3; color:#fff; padding:8px 12px; border-radius:6px; text-decoration:none;">Edit</a>

        <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" 
                    onclick="return confirm('Are you sure you want to delete this project?')" 
                    style="background-color:#FF5722; color:#fff; padding:8px 12px; border:none; border-radius:6px; cursor:pointer;">
                Delete
            </button>
        </form>
    </div>

    <a href="{{ route('admin.projects.index') }}" style="display:inline-block; margin-top:20px; color:#4CAF50; text-decoration:none;">&larr; Back to Projects</a>
</div>
@endsection
