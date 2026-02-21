@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Create New Devotion</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.devotions.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" placeholder="Enter devotion title" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Author</label>
                    <input type="text" name="author" class="form-control" placeholder="Enter author name" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Date</label>
                    <input type="date" name="date" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Content</label>
                    <textarea name="content" rows="6" class="form-control" placeholder="Write the devotional content..." required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Thumbnail (optional)</label>
                    <input type="file" name="thumbnail" class="form-control" accept="image/*">
                </div>

                <button type="submit" class="btn btn-success">Save Devotion</button>
                <a href="{{ route('admin.devotions.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

<!-- Optional JS for file preview -->
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
