@extends('layouts.admin')

@section('content')
<h2>Edit Project</h2>

@if($errors->any())
    <ul style="color:red;">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="{{ route('admin.projects.update', $project->id) }}" method="POST" enctype="multipart/form-data" style="max-width:600px;">
    @csrf
    @method('PUT')

    <label for="title">Title</label><br>
    <input type="text" name="title" id="title" value="{{ old('title', $project->title) }}" required style="width:100%; padding:6px; margin-bottom:10px;"><br>

    <label for="description">Description</label><br>
    <textarea name="description" id="description" rows="5" required style="width:100%; padding:6px; margin-bottom:10px;">{{ old('description', $project->description) }}</textarea><br>

    <label for="image">Image (optional)</label><br>
    @if($project->image)
        <img src="{{ asset('storage/' . $project->image) }}" width="120" alt="Project Image" style="display:block; margin-bottom:10px;">
    @endif
    <input type="file" name="image" id="image" accept="image/*" style="margin-bottom:10px;"><br>

    <label for="progress">Progress (optional)</label><br>
    <input type="text" name="progress" id="progress" value="{{ old('progress', $project->progress) }}" placeholder="e.g., 50% Complete" style="width:100%; padding:6px; margin-bottom:10px;"><br>

    <button type="submit" style="background-color:#2196F3; color:#fff; padding:8px 12px; border:none; border-radius:6px;">Update Project</button>
</form>
@endsection
