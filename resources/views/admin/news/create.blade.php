@extends('layouts.admin')

@section('content')
<h1>Create News</h1>

@if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div>
        <label>Title:</label>
        <input type="text" name="title" value="{{ old('title') }}" required>
    </div>

    <div>
        <label>Content:</label>
        <textarea name="content" rows="5" required>{{ old('content') }}</textarea>
    </div>

    <div>
        <label>Images:</label>
        <input type="file" name="images[]" multiple accept="image/*">
        <p>You can select multiple images.</p>
    </div>

    <button type="submit">Create News</button>
</form>
@endsection
