@extends('layouts.admin')

@section('content')

<style>
.container {
    max-width: 800px;
    margin: auto;
}

.card {
    background: #fff;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

h2 {
    color: #1e3c72;
    margin-bottom: 15px;
}

.info {
    margin-bottom: 10px;
    color: #555;
}

.file-box {
    margin-top: 20px;
    padding: 15px;
    border: 1px solid #eee;
    border-radius: 8px;
    background: #f9f9f9;
}

.btn {
    display: inline-block;
    padding: 10px 15px;
    border-radius: 6px;
    text-decoration: none;
    color: #fff;
    font-weight: bold;
    margin-top: 15px;
}

.btn-download { background: #4CAF50; }
.btn-back { background: #2196F3; }
</style>

<div class="container">

    <div class="card">

        <h2>{{ $download->title }}</h2>

        <p class="info">
            <strong>Description:</strong><br>
            {{ $download->description ?? 'No description provided.' }}
        </p>

        <p class="info">
            <strong>File Name:</strong> {{ $download->file_name }}
        </p>

        <p class="info">
            <strong>File Type:</strong> {{ $download->file_type }}
        </p>

        <p class="info">
            <strong>Uploaded At:</strong> {{ $download->created_at }}
        </p>

        <div class="file-box">
            <a class="btn btn-download"
               href="{{ asset('storage/' . $download->file_path) }}"
               target="_blank">
                Download / Open File
            </a>
        </div>

        <a href="{{ route('admin.downloads.index') }}" class="btn btn-back">
            ← Back
        </a>

    </div>

</div>

@endsection