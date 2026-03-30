@extends('layouts.admin')

@section('content')
<h1>Edit Live Stream</h1>

@if($errors->any())
    <ul style="color:red;">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="{{ route('admin.livestreams.update', $stream->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <label>Title</label><br>
    <input type="text" name="title" value="{{ old('title', $stream->title) }}" required><br><br>

    <label>Type</label><br>
    <select name="type" required>
        <option value="radio" {{ old('type', $stream->type)=='radio'?'selected':'' }}>Radio</option>
        <option value="youtube" {{ old('type', $stream->type)=='youtube'?'selected':'' }}>YouTube</option>
        <option value="facebook" {{ old('type', $stream->type)=='facebook'?'selected':'' }}>Facebook</option>
        <option value="other" {{ old('type', $stream->type)=='other'?'selected':'' }}>Other</option>
    </select><br><br>

    <label>URL</label><br>
    <input type="url" name="url" value="{{ old('url', $stream->url) }}"><br><br>

    <label>Description</label><br>
    <textarea name="description">{{ old('description', $stream->description) }}</textarea><br><br>

    <label>Current Logo</label><br>
    @if($stream->logo)
        <img src="{{ asset('storage/'.$stream->logo) }}" width="80"><br><br>
    @endif

    <label>Change Logo</label><br>
    <input type="file" name="logo"><br><br>

    <label>Active?</label>
    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $stream->is_active)?'checked':'' }}><br><br>

    <button type="submit" style="background-color:#2196F3; color:#fff; padding:8px 16px; border-radius:6px; border:none;">Update</button>
</form>
@endsection