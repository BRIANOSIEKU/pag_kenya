@extends('layouts.admin')

@section('content')
<h1>Edit Hero Slide</h1>
<hr><br>

@if(session('success'))
    <div style="background:#4CAF50; color:#fff; padding:10px; border-radius:5px;">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div style="background:#f44336; color:#fff; padding:10px; border-radius:5px; margin-bottom:10px;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.hero-slides.update', $slide->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div style="margin-bottom:15px;">
        <label>Title / Caption (optional)</label><br>
        <input type="text" name="title" value="{{ old('title', $slide->title) }}" style="width:100%; padding:8px; border-radius:4px; border:1px solid #ccc;">
    </div>

    <div style="margin-bottom:15px;">
        <label>Current Image</label><br>
        @if($slide->image)
            <img src="{{ asset('storage/' . $slide->image) }}" alt="Slide Image" style="width:200px; border-radius:6px;">
        @else
            No Image
        @endif
    </div>

    <div style="margin-bottom:15px;">
        <label>Change Image (optional)</label><br>
        <input type="file" name="image">
    </div>

    <button type="submit" style="background:#4CAF50; color:#fff; padding:10px 15px; border:none; border-radius:5px;">Update Slide</button>
    <a href="{{ route('admin.hero.index') }}" style="padding:10px 15px; background:#ccc; border-radius:5px; text-decoration:none; color:#000; margin-left:10px;">Cancel</a>
</form>
@endsection