@extends('layouts.admin')

@section('content')
<div style="max-width:800px; margin:auto;">

    <h1>Edit News</h1>

    {{-- Flash Message --}}
    @if(session('success'))
        <div style="color:green; margin-bottom:15px;">
            {{ session('success') }}
        </div>
    @endif

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div style="color:red; margin-bottom:15px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Title --}}
        <div style="margin-bottom:10px;">
            <label for="title"><strong>Title:</strong></label><br>
            <input type="text" id="title" name="title" 
                   value="{{ old('title', $news->title) }}" 
                   required style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
        </div>

        {{-- Content --}}
        <div style="margin-bottom:10px;">
            <label for="content"><strong>Content:</strong></label><br>
            <textarea id="content" name="content" rows="6" required
                style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">{{ old('content', $news->content) }}</textarea>
        </div>

        {{-- Upload New Images --}}
        <div style="margin-bottom:15px;">
            <label for="images"><strong>Upload New Images:</strong></label><br>
            <input type="file" name="images[]" id="images" multiple accept="image/*">
            <p style="font-size:0.9em; color:#555;">You can select multiple images. Existing images are displayed below.</p>
        </div>

        {{-- Existing Images --}}
        @if($news->photos->count() > 0)
            <div style="margin-bottom:15px;">
                <h4>Existing Images:</h4>
                <div style="display:flex; gap:10px; flex-wrap:wrap;">
                    @foreach($news->photos as $photo)
                        <div style="position:relative; display:inline-block;">
                            <img src="{{ asset('uploads/news/'.$photo->image) }}" 
                                 alt="News Image" 
                                 width="120" 
                                 style="border:1px solid #ccc; padding:3px; border-radius:4px; display:block;">

                            {{-- Delete Photo Button --}}
                            <form action="{{ route('admin.news.photo.destroy', $photo->id) }}" method="POST" 
                                  style="position:absolute; top:0; right:0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        style="background:red; color:white; border:none; border-radius:50%; width:22px; height:22px; cursor:pointer; font-weight:bold;">×</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Submit Button --}}
        <button type="submit" 
                style="padding:10px 20px; background:#007BFF; color:white; border:none; border-radius:4px; cursor:pointer;">
            Update News
        </button>

    </form>
</div>
@endsection
