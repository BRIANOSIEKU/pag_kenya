@extends('layouts.admin')

@section('content')
<h1>Add New Live Stream</h1>

@if($errors->any())
    <ul style="color:red;">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="{{ route('admin.livestreams.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <label>Title</label><br>
    <input type="text" name="title" value="{{ old('title') }}" required><br><br>

    <label>Type</label><br>
    <select name="type" required>
        <option value="radio" {{ old('type')=='radio'?'selected':'' }}>Radio</option>
        <option value="youtube" {{ old('type')=='youtube'?'selected':'' }}>YouTube</option>
        <option value="facebook" {{ old('type')=='facebook'?'selected':'' }}>Facebook</option>
        <option value="other" {{ old('type')=='other'?'selected':'' }}>Other</option>
    </select><br><br>

    <label>URL</label><br>
    <input type="url" name="url" value="{{ old('url') }}"><br><br>

    <label>Description</label><br>
    <textarea name="description">{{ old('description') }}</textarea><br><br>

    <label>Logo</label><br>
    <input type="file" name="logo"><br><br>

    <label>Active?</label>
    <input type="checkbox" name="is_active" value="1" {{ old('is_active')?'checked':'' }}><br><br>

    <button type="submit" style="background-color:#4CAF50; color:#fff; padding:8px 16px; border-radius:6px; border:none;">Save</button>
</form>
@endsection