@extends('layouts.admin')

@section('content')

<style>
.container {
    max-width: 800px;
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

/* BUTTON */
.btn {
    padding: 10px 16px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    font-weight: bold;
}
.btn-primary {
    background: #2196F3;
    color: white;
}
.btn:hover {
    opacity: 0.85;
}

/* IMAGE PREVIEW */
.preview-img {
    max-width: 150px;
    margin-top: 10px;
    border-radius: 6px;
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
        <a href="{{ route('admin.partners.index') }}" class="btn-back">
            ← Back to Partners
        </a>
        <h2>Add Partner</h2>
    </div>

    <!-- CARD -->
    <div class="card">

        <form action="{{ route('admin.partners.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- NAME -->
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" required>
            </div>

            <!-- LOGO -->
            <div class="form-group">
                <label>Logo</label>
                <input type="file" name="logo" id="logoInput" accept="image/*">

                <img id="logoPreview" class="preview-img" style="display:none;">
            </div>

            <!-- DESCRIPTION -->
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="5"></textarea>
            </div>

            <!-- BUTTON -->
            <div style="margin-top:15px;">
                <button type="submit" class="btn btn-primary">
                    Save Partner
                </button>
            </div>

        </form>

    </div>

</div>

<!-- IMAGE PREVIEW SCRIPT -->
<script>
document.getElementById('logoInput').addEventListener('change', function(event){
    const file = event.target.files[0];
    const preview = document.getElementById('logoPreview');

    if(file){
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    }
});
</script>

@endsection