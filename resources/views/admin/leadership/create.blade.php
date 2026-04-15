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
        max-width: 900px;
        margin: auto;
    }

    .card {
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.08);
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    td {
        padding: 12px;
        border-bottom: 1px solid #eee;
        vertical-align: top;
    }

    td.label {
        width: 30%;
        background: #f7f7f7;
        font-weight: bold;
    }

    input, textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 14px;
        outline: none;
    }

    textarea {
        resize: vertical;
    }

    .btn-save {
        background: #2196F3;
        color: #fff;
        padding: 10px 18px;
        border: none;
        border-radius: 6px;
        font-weight: bold;
        cursor: pointer;
    }

    .btn-save:hover {
        opacity: 0.9;
    }

    .preview-img {
        margin-top: 10px;
        width: 180px;
        height: 180px;
        object-fit: cover;
        border-radius: 8px;
        display: none;
        border: 1px solid #ddd;
    }
</style>

<div class="container">

    <!-- BACK -->
    <a href="{{ route('admin.dashboard') }}" class="btn-back">
        ← Back to Dashboard
    </a>

    <h2 style="margin-bottom:15px;">
        Add New {{ ucfirst($type) }} Leader
    </h2>

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

        <form action="{{ route('admin.leadership.store', $type) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <table>

                <tr>
                    <td class="label">Full Name</td>
                    <td>
                        <input type="text" name="full_name" value="{{ old('full_name') }}">
                    </td>
                </tr>

                <tr>
                    <td class="label">Position</td>
                    <td>
                        <input type="text" name="position" value="{{ old('position') }}">
                    </td>
                </tr>

                <tr>
                    <td class="label">Contact</td>
                    <td>
                        <input type="text" name="contact" value="{{ old('contact') }}">
                    </td>
                </tr>

                <tr>
                    <td class="label">Email Address</td>
                    <td>
                        <input type="email" name="email" value="{{ old('email') }}">
                    </td>
                </tr>

                <tr>
                    <td class="label">Brief Description</td>
                    <td>
                        <textarea name="brief_description" rows="6">{{ old('brief_description') }}</textarea>
                    </td>
                </tr>

                <tr>
                    <td class="label">Message</td>
                    <td>
                        <textarea name="message" rows="8">{{ old('message') }}</textarea>
                    </td>
                </tr>

                <tr>
                    <td class="label">Photo</td>
                    <td>
                        <input type="file" name="photo" id="photoInput">

                        <img id="photoPreview" class="preview-img">
                    </td>
                </tr>

            </table>

            <div style="margin-top:15px;">
                <button type="submit" class="btn-save">
                    Save Leader
                </button>
            </div>

        </form>

    </div>
</div>

<script>
document.getElementById('photoInput').addEventListener('change', function (event) {
    const file = event.target.files[0];
    const preview = document.getElementById('photoPreview');

    if (file) {
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    }
});
</script>

@endsection