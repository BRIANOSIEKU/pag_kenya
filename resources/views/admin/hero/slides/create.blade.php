@extends('layouts.admin')

@section('content')
<h1>Add New Hero Slide</h1>
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

<form action="{{ route('admin.hero-slides.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div style="margin-bottom:15px;">
        <label>Title / Caption (optional)</label><br>
        <input type="text" name="title" value="{{ old('title') }}" style="width:100%; padding:8px; border-radius:4px; border:1px solid #ccc;">
    </div>

    <div style="margin-bottom:15px;">
        <label>Slide Image *</label><br>
        <input type="file" name="image" required>
    </div>

    <button type="submit" style="background:#009688; color:#fff; padding:10px 15px; border:none; border-radius:5px;">Upload Slide</button>
    <a href="{{ route('admin.hero.index') }}" style="padding:10px 15px; background:#ccc; border-radius:5px; text-decoration:none; color:#000; margin-left:10px;">Cancel</a>
</form>
@endsection