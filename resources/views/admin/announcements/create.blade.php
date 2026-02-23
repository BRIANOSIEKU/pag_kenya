@extends('layouts.admin')

@section('content')
<h1>Create Announcement</h1>

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

<form action="{{ route('admin.announcements.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- Title -->
    <div style="margin-bottom:12px;">
        <label for="title"><strong>Title</strong></label><br>
        <input type="text" name="title" id="title" value="{{ old('title') }}" required
               style="width:100%; padding:8px; border-radius:6px; border:1px solid #ccc;">
    </div>

    <!-- Description -->
    <div style="margin-bottom:12px;">
        <label for="description"><strong>Description</strong></label><br>
        <textarea name="description" id="description" rows="5"
                  style="width:100%; padding:8px; border-radius:6px; border:1px solid #ccc;" 
                  placeholder="Write the announcement description here...">{{ old('description') }}</textarea>
    </div>

    <!-- Type -->
    <div style="margin-bottom:12px;">
        <label for="type"><strong>Type</strong></label><br>
        <select name="type" id="type" style="width:100%; padding:8px; border-radius:6px; border:1px solid #ccc;" required>
            <option value="">Select Type</option>
            <option value="text" {{ old('type') == 'text' ? 'selected' : '' }}>Text</option>
            <option value="video" {{ old('type') == 'video' ? 'selected' : '' }}>Video</option>
            <option value="document" {{ old('type') == 'document' ? 'selected' : '' }}>Document</option>
            <option value="photo" {{ old('type') == 'photo' ? 'selected' : '' }}>Photo</option>
        </select>
    </div>

    <!-- Video -->
    <div style="margin-bottom:12px;">
        <label for="video"><strong>Upload Video</strong></label><br>
        <input type="file" name="video" id="video" accept=".mp4,.avi,.mov" style="width:100%; padding:6px;">
    </div>

    <!-- Document -->
    <div style="margin-bottom:12px;">
        <label for="document"><strong>Upload Document (PDF/DOC/DOCX)</strong></label><br>
        <input type="file" name="document" id="document" accept=".pdf,.doc,.docx" style="width:100%; padding:6px;">
    </div>

    <!-- Photo -->
    <div style="margin-bottom:12px;">
        <label for="photo"><strong>Photo (Optional)</strong></label><br>
        <input type="file" name="photo" id="photo" accept="image/*" style="width:100%; padding:6px;">
    </div>

    <button type="submit" 
            style="padding:10px 16px; background:#4CAF50; color:#fff; border-radius:6px; border:none; cursor:pointer;">
        Save Announcement
    </button>
</form>

<script>
    // Optional: show/hide file inputs based on type
    const typeSelect = document.getElementById('type');
    const videoInput = document.getElementById('video');
    const documentInput = document.getElementById('document');

    function updateFileInputs() {
        if(typeSelect.value === 'video') {
            videoInput.disabled = false;
            documentInput.disabled = true;
            documentInput.value = '';
        } else if(typeSelect.value === 'document') {
            documentInput.disabled = false;
            videoInput.disabled = true;
            videoInput.value = '';
        } else {
            videoInput.disabled = true;
            documentInput.disabled = true;
            videoInput.value = '';
            documentInput.value = '';
        }
    }

    typeSelect.addEventListener('change', updateFileInputs);
    window.addEventListener('load', updateFileInputs);
</script>
@endsection