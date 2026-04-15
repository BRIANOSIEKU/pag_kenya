@extends('layouts.admin')

@section('content')

<style>
.container {
    max-width: 700px;
    margin: auto;
    padding: 20px;
}

.card {
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

.form-control {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    outline: none;
}

textarea.form-control {
    resize: vertical;
}

.btn {
    padding: 10px 15px;
    border-radius: 6px;
    color: #fff;
    border: none;
    cursor: pointer;
    font-weight: bold;
}

.btn-primary { background: #2196F3; }

.alert-error {
    background: #f8d7da;
    color: #721c24;
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 15px;
}

.project-img {
    width: 120px;
    border-radius: 6px;
    margin-bottom: 10px;
}
</style>

<div class="container">

    <h2 style="margin-bottom:15px;">Edit Project</h2>

    <!-- ERRORS -->
    @if($errors->any())
        <div class="alert-error">
            <ul style="margin:0; padding-left:18px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- FORM -->
    <div class="card">

        <form action="{{ route('admin.projects.update', $project->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- TITLE -->
            <div class="form-group">
                <label>Title</label>
                <input type="text"
                       name="title"
                       value="{{ old('title', $project->title) }}"
                       class="form-control"
                       required>
            </div>

            <!-- DESCRIPTION -->
            <div class="form-group">
                <label>Description</label>
                <textarea name="description"
                          rows="5"
                          class="form-control"
                          required>{{ old('description', $project->description) }}</textarea>
            </div>

            <!-- IMAGE -->
            <div class="form-group">
                <label>Project Image (Optional)</label>

                @if($project->image)
                    <img src="{{ asset('storage/' . $project->image) }}" class="project-img">
                @endif

                <input type="file"
                       name="image"
                       accept="image/*"
                       class="form-control">
            </div>

            <!-- PROGRESS -->
            <div class="form-group">
                <label>Progress (Optional)</label>
                <input type="text"
                       name="progress"
                       value="{{ old('progress', $project->progress) }}"
                       placeholder="e.g., 50% Complete"
                       class="form-control">
            </div>

            <!-- BUTTON -->
            <button type="submit" class="btn btn-primary">
                Update Project
            </button>

        </form>

    </div>

</div>

@endsection