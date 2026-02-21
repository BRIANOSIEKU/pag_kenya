@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Edit Devotion</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.devotions.update', $devotion->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" value="{{ $devotion->title }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Author</label>
                    <input type="text" name="author" class="form-control" value="{{ $devotion->author }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Date</label>
                    <input type="date" name="date" class="form-control" value="{{ $devotion->date }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Content</label>
                    <textarea name="content" rows="6" class="form-control" required>{{ $devotion->content }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Thumbnail (optional)</label>
                    <input type="file" name="thumbnail" class="form-control" accept="image/*">

                    @if($devotion->thumbnail)
                        <img id="thumbnailPreview" src="{{ asset($devotion->thumbnail) }}" alt="Current Thumbnail" style="max-width:200px; margin-top:10px;">
                    @endif
                </div>

                <button type="submit" class="btn btn-success">Update Devotion</button>
                <a href="{{ route('admin.devotions.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

<!-- JS for live thumbnail preview -->
<script>
document.querySelector('input[name="thumbnail"]').addEventListener('change', function(event){
    const file = event.target.files[0];
    if(file){
        const reader = new FileReader();
        reader.onload = function(e){
            let imgPreview = document.getElementById('thumbnailPreview');
            if(!imgPreview){
                imgPreview = document.createElement('img');
                imgPreview.id = 'thumbnailPreview';
                imgPreview.style.maxWidth = '200px';
                imgPreview.style.marginTop = '10px';
                event.target.parentNode.appendChild(imgPreview);
            }
            imgPreview.src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});
</script>

@endsection
