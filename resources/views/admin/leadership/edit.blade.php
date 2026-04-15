@extends('layouts.admin')

@section('content')

<style>
    .btn-back {
        background: #607D8B;
        color: white;
        padding: 8px 12px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 13px;
        font-weight: bold;
        display: inline-block;
        margin-bottom: 15px;
    }

    .btn-back:hover {
        opacity: 0.85;
    }

    .container {
        max-width: 800px;
        margin: auto;
    }

    .card {
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.08);
    }

    label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
    }

    input, textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        outline: none;
        font-size: 14px;
    }

    textarea {
        resize: vertical;
    }

    .row {
        display: flex;
        gap: 10px;
    }

    .col {
        flex: 1;
    }

    .btn-update {
        background: #2196F3;
        color: white;
        padding: 10px 18px;
        border: none;
        border-radius: 6px;
        font-weight: bold;
        cursor: pointer;
    }

    .btn-update:hover {
        opacity: 0.9;
    }

    .preview {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 10px;
        border: 1px solid #ddd;
        margin-top: 10px;
    }

    .section {
        margin-bottom: 15px;
    }
</style>

<div class="container">

    <!-- BACK -->
    <a href="{{ route('admin.dashboard') }}" class="btn-back">
        ← Back to Dashboard
    </a>

    <h2 style="margin-bottom:15px;">Edit Leader</h2>

    <div class="card">

        <form action="{{ route('admin.leadership.update', [$type, $leader->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Full Name -->
            <div class="section">
                <label>Full Name</label>
                <input type="text" name="full_name"
                       value="{{ old('full_name', $leader->full_name) }}" required>
            </div>

            <!-- Position -->
            <div class="section">
                <label>Position</label>
                <input type="text" name="position"
                       value="{{ old('position', $leader->position) }}" required>
            </div>

            <!-- Contact & Email -->
            <div class="row section">
                <div class="col">
                    <label>Contact</label>
                    <input type="text" name="contact"
                           value="{{ old('contact', $leader->contact) }}" required>
                </div>

                <div class="col">
                    <label>Email</label>
                    <input type="email" name="email"
                           value="{{ old('email', $leader->email) }}" required>
                </div>
            </div>

            <!-- Brief Description -->
            <div class="section">
                <label>Brief Description</label>
                <textarea name="brief_description" rows="4" required>{{ old('brief_description', $leader->brief_description) }}</textarea>
            </div>

            <!-- Message -->
            <div class="section">
                <label>Message (Optional)</label>
                <textarea name="message" rows="4">{{ old('message', $leader->message) }}</textarea>
            </div>

            <!-- PHOTO -->
            <div class="section">
                <label>Photo</label>
                <input type="file" name="photo" accept="image/*" onchange="previewImage(event)">
                
                <img id="photoPreview"
                     src="{{ $leader->photo ? asset($leader->photo) : 'https://via.placeholder.com/150' }}"
                     class="preview">
            </div>

            <!-- BUTTON -->
            <button type="submit" class="btn-update">
                Update Leader
            </button>

        </form>

    </div>
</div>

<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function () {
        document.getElementById('photoPreview').src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>

@endsection