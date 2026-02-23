@extends('layouts.admin')

@section('content')
<h2>Edit Announcement</h2>

<a href="{{ route('admin.announcements.index') }}" 
   style="padding:8px 14px; background:#9C27B0; color:#fff; border-radius:6px; text-decoration:none; margin-bottom:20px; display:inline-block;">
   ← Back to Announcements
</a>

@if ($errors->any())
<div style="margin-bottom:15px; padding:10px; background:#F44336; color:#fff; border-radius:6px;">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('admin.announcements.update', $announcement->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- Title -->
    <div style="margin-bottom:12px;">
        <label for="title"><strong>Title</strong></label><br>
        <input type="text" name="title" id="title" value="{{ old('title', $announcement->title) }}" required
               style="width:100%; padding:8px; border-radius:6px; border:1px solid #ccc;">
    </div>

    <!-- Description -->
    <div style="margin-bottom:12px;">
        <label for="description"><strong>Description</strong></label><br>
        <textarea name="description" id="description" rows="5"
                  style="width:100%; padding:8px; border-radius:6px; border:1px solid #ccc;" 
                  placeholder="Write the announcement description here...">{{ old('description', $announcement->description) }}</textarea>
    </div>

    <!-- Type -->
    <div style="margin-bottom:12px;">
        <label for="type"><strong>Type</strong></label><br>
        <select name="type" id="type" style="width:100%; padding:8px; border-radius:6px; border:1px solid #ccc;" required>
            <option value="">Select Type</option>
            <option value="text" {{ old('type', $announcement->type) == 'text' ? 'selected' : '' }}>Text</option>
            <option value="video" {{ old('type', $announcement->type) == 'video' ? 'selected' : '' }}>Video</option>
            <option value="document" {{ old('type', $announcement->type) == 'document' ? 'selected' : '' }}>Document</option>
        </select>
    </div>

    <!-- Upload File -->
    <div style="margin-bottom:12px;">
        <label for="file"><strong>Upload File (PDF/Video)</strong></label><br>
        <input type="file" name="file" id="file" accept=".pdf,.mp4,.doc,.docx"
               style="width:100%; padding:6px;">
        @if($announcement->file)
            <p style="margin-top:5px;">Current file: <a href="{{ asset('storage/'.$announcement->file) }}" target="_blank">{{ basename($announcement->file) }}</a></p>
        @endif
    </div>

    <!-- Upload Photo -->
    <div style="margin-bottom:12px;">
        <label for="photo"><strong>Photo</strong></label><br>
        <input type="file" name="photo" id="photo" accept="image/*"
               style="width:100%; padding:6px;">
        @if($announcement->photo)
            <p style="margin-top:5px;">Current photo: <img src="{{ asset('storage/'.$announcement->photo) }}" alt="Announcement Photo" style="max-width:150px; display:block; margin-top:5px; border-radius:6px;"></p>
        @endif
    </div>

    <button type="submit" 
            style="padding:10px 16px; background:#4CAF50; color:#fff; border-radius:6px; border:none; cursor:pointer;">
        Update Announcement
    </button>
</form>
@endsection