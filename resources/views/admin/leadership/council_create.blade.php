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

    .section {
        margin-bottom: 15px;
    }

    .btn-submit {
        background: #2196F3;
        color: #fff;
        padding: 10px 18px;
        border: none;
        border-radius: 6px;
        font-weight: bold;
        cursor: pointer;
    }

    .btn-submit:hover {
        opacity: 0.9;
    }

    .btn-cancel {
        margin-left: 10px;
        color: #555;
        text-decoration: none;
        font-size: 14px;
    }
</style>

<div class="container">

    <!-- BACK -->
    <a href="{{ route('admin.dashboard') }}" class="btn-back">
        ← Back to Dashboard
    </a>

    <h2 style="margin-bottom:15px;">Add Church Council Member</h2>

    @if ($errors->any())
        <div style="background:#f8d7da;color:#721c24;padding:10px;border-radius:6px;margin-bottom:15px;">
            <ul style="margin:0;padding-left:20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">

        <form action="{{ route('admin.leadership.store', 'council') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="section">
                <label>Full Name *</label>
                <input type="text" name="full_name" value="{{ old('full_name') }}" required>
            </div>

            <div class="section">
                <label>Position *</label>
                <input type="text" name="position" value="{{ old('position') }}" required>
            </div>

            <div class="section">
                <label>Contact *</label>
                <input type="text" name="contact" value="{{ old('contact') }}" required>
            </div>

            <div class="section">
                <label>Email *</label>
                <input type="email" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="section">
                <label>Brief Description</label>
                <textarea name="brief_description">{{ old('brief_description') }}</textarea>
            </div>

            <div class="section">
                <label>Message</label>
                <textarea name="message">{{ old('message') }}</textarea>
            </div>

            <div class="section">
                <label>Photo</label>
                <input type="file" name="photo">
            </div>

            <button type="submit" class="btn-submit">
                Add Member
            </button>

            <a href="{{ route('admin.leadership.index', 'council') }}" class="btn-cancel">
                Cancel
            </a>

        </form>

    </div>

</div>

@endsection