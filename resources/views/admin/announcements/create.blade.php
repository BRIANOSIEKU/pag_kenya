@extends('layouts.admin')

@section('content')

<style>
    .container-box {
        max-width: 900px;
        margin: auto;
        padding: 20px;
    }

    .header {
        margin-bottom: 20px;
    }

    .btn {
        display: inline-block;
        padding: 8px 14px;
        border-radius: 6px;
        text-decoration: none;
        color: #fff;
        font-weight: bold;
        transition: 0.2s;
    }

    .btn:hover {
        opacity: 0.85;
    }

    .btn-back {
        background: #9C27B0;
    }

    .btn-save {
        background: #4CAF50;
        border: none;
        cursor: pointer;
        padding: 10px 16px;
    }

    .form-group {
        margin-bottom: 14px;
    }

    label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
    }

    input, textarea, select {
        width: 100%;
        padding: 8px;
        border-radius: 6px;
        border: 1px solid #ccc;
    }

    .alert {
        padding: 10px;
        border-radius: 6px;
        margin-bottom: 15px;
    }

    .alert-error {
        background: #F44336;
        color: #fff;
    }
</style>

<div class="container-box">

    <h1>Create Announcement</h1>

    <a href="{{ route('admin.announcements.index') }}" class="btn btn-back" style="margin-bottom:20px;">
        ← Back to Announcements
    </a>

    @if ($errors->any())
        <div class="alert alert-error">
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
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" value="{{ old('title') }}" required>
        </div>

        <!-- Description -->
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="5" placeholder="Write the announcement description...">{{ old('description') }}</textarea>
        </div>

        <!-- Type -->
        <div class="form-group">
            <label>Type</label>
            <select name="type" id="type" required>
                <option value="">Select Type</option>
                <option value="text">Text</option>
                <option value="video">Video</option>
                <option value="document">Document</option>
                <option value="photo">Photo</option>
            </select>
        </div>

        <!-- Video -->
        <div class="form-group">
            <label>Video Upload</label>
            <input type="file" name="video" id="video" accept=".mp4,.avi,.mov">
        </div>

        <!-- Document -->
        <div class="form-group">
            <label>Document Upload</label>
            <input type="file" name="document" id="document" accept=".pdf,.doc,.docx">
        </div>

        <!-- Photo -->
        <div class="form-group">
            <label>Photo (Optional)</label>
            <input type="file" name="photo" accept="image/*">
        </div>

        <button type="submit" class="btn btn-save">
            Save Announcement
        </button>

    </form>

</div>

<script>
    const typeSelect = document.getElementById('type');
    const videoInput = document.getElementById('video');
    const documentInput = document.getElementById('document');

    function toggleInputs() {
        const type = typeSelect.value;

        if (type === 'video') {
            videoInput.disabled = false;
            documentInput.disabled = true;
            documentInput.value = '';
        } 
        else if (type === 'document') {
            documentInput.disabled = false;
            videoInput.disabled = true;
            videoInput.value = '';
        } 
        else {
            videoInput.disabled = true;
            documentInput.disabled = true;
            videoInput.value = '';
            documentInput.value = '';
        }
    }

    typeSelect.addEventListener('change', toggleInputs);
    window.addEventListener('load', toggleInputs);
</script>

@endsection