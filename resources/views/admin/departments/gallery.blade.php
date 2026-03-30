@extends('layouts.admin')

@section('content')

<!-- Top Buttons -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <a href="{{ route('admin.departments.index') }}" style="
        background-color:#607D8B;
        color:#fff;
        padding:10px 16px;
        border-radius:6px;
        font-weight:bold;
        text-decoration:none;
        transition:0.3s;
    " onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
        &larr; Back to Departments
    </a>

    <form action="{{ route('admin.departments.uploadGallery', $department->id) }}" method="POST" enctype="multipart/form-data" style="display:flex; gap:8px;">
        @csrf
        <input type="file" name="image" required style="padding:6px; font-size:0.85rem;">
        <input type="text" name="caption" placeholder="Caption" style="padding:6px; font-size:0.85rem;">
        <button type="submit" style="
            background:#4CAF50;
            color:#fff;
            padding:6px 10px;
            font-size:0.85rem;
            border-radius:4px;
            cursor:pointer;
        ">Upload</button>
    </form>
</div>

@if(session('success'))
    <div style="background-color:#4CAF50; color:white; padding:10px 15px; border-radius:6px; margin-bottom:20px;">
        {{ session('success') }}
    </div>
@endif

<!-- Gallery Thumbnails -->
<div style="display:flex; flex-wrap:wrap; gap:10px;">
    @forelse($images as $index => $img)
        <div style="position:relative; width:50px; height:50px; border:1px solid #ccc; border-radius:4px; overflow:hidden; text-align:center;">
            <!-- Number badge -->
            <span style="
                position:absolute;
                top:0; left:0;
                background:#8E24AA;
                color:#fff;
                font-size:0.65rem;
                font-weight:bold;
                padding:1px 3px;
                border-bottom-right-radius:4px;
            ">{{ $index + 1 }}</span>

            <!-- Thumbnail -->
            <img src="{{ asset('storage/departments_gallery/'.$img->image_path) }}" 
                 alt="{{ $img->caption ?? 'Gallery Image' }}" 
                 title="{{ $img->caption ?? '' }}"
                 style="width:100%; height:100%; object-fit:cover; cursor:pointer;"
                 onclick="window.open('{{ asset('storage/departments_gallery/'.$img->image_path) }}', '_blank')">

            <!-- Delete button -->
            <form action="{{ route('admin.departments.deleteGallery', $img->id) }}" method="POST" style="
                position:absolute;
                top:0; right:0;
                margin:0;
            ">
                @csrf
                @method('DELETE')
                <button type="submit" style="
                    background:#e53935;
                    color:#fff;
                    font-size:0.65rem;
                    border:none;
                    padding:1px 4px;
                    border-bottom-left-radius:4px;
                    cursor:pointer;
                ">X</button>
            </form>
        </div>
    @empty
        <p style="color:#888;">No images uploaded yet.</p>
    @endforelse
</div>

@endsection