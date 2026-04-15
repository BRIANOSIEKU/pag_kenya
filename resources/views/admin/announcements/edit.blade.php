@extends('layouts.admin')

@section('content')

<style>
    .container-box {
        max-width: 900px;
        margin: auto;
        padding: 20px;
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
        margin-bottom: 20px;
    }

    .btn-submit {
        background: #4CAF50;
        border: none;
        padding: 10px 16px;
        cursor: pointer;
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

    .preview-box {
        margin-top: 8px;
        font-size: 13px;
    }

    img {
        max-width: 150px;
        border-radius: 6px;
        margin-top: 5px;
    }

    a.file-link {
        color: #2196F3;
        text-decoration: none;
        font-weight: bold;
    }

    a.file-link:hover {
        text-decoration: underline;
    }
</style>

<div class="container-box">

    <h2>Edit Announcement</h2>

    <a href="{{ route('admin.announcements.index') }}" class="btn btn-back">
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

    <form action="{{ route('admin.announcements.update', $announcement->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Title -->
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" value="{{ old('title', $announcement->title) }}" required>
        </div>

        <!-- Description -->
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="5">{{ old('description', $announcement->description) }}</textarea>
        </div>

        <!-- Type -->
        <div class="form-group">
            <label>Type</label>
            <select name="type" required>
                <option value="">Select Type</option>
                <option value="text" {{ old('type', $announcement->type) == 'text' ? 'selected' : '' }}>Text</option>
                <option value="video" {{ old('type', $announcement->type) == 'video' ? 'selected' : '' }}>Video</option>
                <option value="document" {{ old('type', $announcement->type) == 'document' ? 'selected' : '' }}>Document</option>
            </select>
        </div>

        <!-- File -->
        <div class="form-group">
            <label>Upload File (PDF / Video)</label>
            <input type="file" name="file" accept=".pdf,.mp4,.doc,.docx">

            @if($announcement->file)
                <div class="preview-box">
                    Current file:
                    <a class="file-link" href="{{ asset('storage/'.$announcement->file) }}" target="_blank">
                        {{ basename($announcement->file) }}
                    </a>
                </div>
            @endif
        </div>

        <!-- Photo -->
        <div class="form-group">
            <label>Photo</label>
            <input type="file" name="photo" accept="image/*">

            @if($announcement->photo)
                <div class="preview-box">
                    Current photo:
                    <img src="{{ asset('storage/'.$announcement->photo) }}" alt="Announcement Photo">
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-submit">
            Update Announcement
        </button>

    </form>

</div>

@endsection