@extends('layouts.admin')

@section('content')

<style>
.container {
    max-width: 700px;
    margin: auto;
}

.card {
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

h2 {
    color: #1e3c72;
    margin-bottom: 20px;
}

label {
    font-weight: bold;
    display: block;
    margin-top: 10px;
}

input, textarea {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #ddd;
    border-radius: 6px;
}

button {
    margin-top: 15px;
    padding: 10px 15px;
    border: none;
    border-radius: 6px;
    background: #4CAF50;
    color: white;
    font-weight: bold;
    cursor: pointer;
}

button:hover {
    opacity: 0.9;
}

.back {
    display: inline-block;
    margin-bottom: 15px;
    text-decoration: none;
    color: #2196F3;
}
</style>

<div class="container">

    <a href="{{ route('admin.downloads.index') }}" class="back">
        ← Back to Downloads
    </a>

    <div class="card">

        <h2>Upload New File</h2>

        @if(session('success'))
            <p style="color:green;">{{ session('success') }}</p>
        @endif

        <form action="{{ route('admin.downloads.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <label>Title</label>
            <input type="text" name="title" required>

            <label>Description (optional)</label>
            <textarea name="description"></textarea>

            <label>Choose File</label>
            <input type="file" name="file" required>

            <button type="submit">Upload File</button>
        </form>

    </div>

</div>

@endsection