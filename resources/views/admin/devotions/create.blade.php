@extends('layouts.admin')

@section('content')

<style>
.container {
    max-width: 900px;
    margin: auto;
    padding: 15px;
}

/* HEADER */
.header {
    margin-bottom: 20px;
}

/* BACK BUTTON */
.btn-back {
    background: #607D8B;
    color: white;
    padding: 8px 12px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 13px;
    font-weight: bold;
    display: inline-block;
    margin-bottom: 15px;
}
.btn-back:hover {
    opacity: 0.85;
}

/* CARD */
.card {
    background: #fff;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
}

/* FORM */
.form-group {
    margin-bottom: 15px;
}
.form-group label {
    font-weight: 600;
    display: block;
    margin-bottom: 5px;
}
.form-group input,
.form-group textarea {
    width: 100%;
    padding: 10px;
    border-radius: 6px;
    border: 1px solid #ddd;
    font-size: 14px;
}

/* BUTTONS */
.btn {
    padding: 10px 16px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    font-weight: bold;
}
.btn-success {
    background: #4CAF50;
    color: white;
}
.btn-secondary {
    background: #9E9E9E;
    color: white;
    text-decoration: none;
}
.btn:hover {
    opacity: 0.85;
}

/* RESPONSIVE */
@media(max-width:768px){
    .card {
        padding: 15px;
    }
}
</style>

<div class="container">

    <!-- HEADER -->
    <div class="header">
        <a href="{{ route('admin.devotions.index') }}" class="btn-back">
            ← Back to Devotions
        </a>
        <h2>Create New Devotion</h2>
    </div>

    <!-- CARD -->
    <div class="card">

        <form action="{{ route('admin.devotions.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- TITLE -->
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" placeholder="Enter devotion title" required>
            </div>

            <!-- AUTHOR -->
            <div class="form-group">
                <label>Author</label>
                <input type="text" name="author" placeholder="Enter author name" required>
            </div>

            <!-- DATE -->
            <div class="form-group">
                <label>Date</label>
                <input type="date" name="date" required>
            </div>

            <!-- CONTENT -->
            <div class="form-group">
                <label>Content</label>
                <textarea name="content" rows="6" placeholder="Write the devotional content..." required></textarea>
            </div>

            <!-- THUMBNAIL -->
            <div class="form-group">
                <label>Thumbnail (optional)</label>
                <input type="file" name="thumbnail" id="thumbnailInput" accept="image/*">

                <div style="margin-top:10px;">
                    <img id="thumbnailPreview" 
                         style="display:none; max-width:200px; border-radius:6px;">
                </div>
            </div>

            <!-- BUTTONS -->
            <div style="margin-top:15px;">
                <button type="submit" class="btn btn-success">Save Devotion</button>
                <a href="{{ route('admin.devotions.index') }}" class="btn btn-secondary">Cancel</a>
            </div>

        </form>

    </div>

</div>

<!-- PREVIEW SCRIPT -->
<script>
document.getElementById('thumbnailInput').addEventListener('change', function(event){
    const file = event.target.files[0];
    const preview = document.getElementById('thumbnailPreview');

    if(file){
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    }
});
</script>

@endsection