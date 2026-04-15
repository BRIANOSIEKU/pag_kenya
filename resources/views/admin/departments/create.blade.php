@extends('layouts.admin')

@section('content')

<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<div style="max-width:900px;margin:40px auto;background:#fff;padding:30px;border-radius:10px;">

    <h2>Create Department</h2>

    <a href="{{ route('admin.departments.index') }}" 
       style="padding:8px 14px; background:#9C27B0; color:#fff; border-radius:6px; text-decoration:none; margin-bottom:20px; display:inline-block;">
       ← Back to Departments
    </a>

    @if ($errors->any())
        <div style="margin-bottom:15px; padding:10px; background:#F44336; color:#fff; border-radius:6px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.departments.store') }}" method="POST" enctype="multipart/form-data" id="form">
        @csrf

        <!-- NAME -->
        <div style="margin-bottom:20px;">
            <label><strong>Name</strong></label>
            <input type="text" name="name" value="{{ old('name') }}" required
                   style="width:100%;padding:10px;border:1px solid #ccc;border-radius:6px;">
        </div>

        <!-- LEADERSHIP -->
        <div style="margin-bottom:20px;">
            <label><strong>Leadership</strong></label>
            <textarea name="leadership" rows="3"
                      style="width:100%;padding:10px;border:1px solid #ccc;border-radius:6px;">{{ old('leadership') }}</textarea>
        </div>

        <!-- OVERVIEW -->
        <div style="margin-bottom:20px;">
            <label><strong>Overview</strong></label>

            <div id="overview_editor" style="height:300px;background:white;border:1px solid #ccc;"></div>
            <input type="hidden" name="overview" id="overview">
        </div>

        <!-- ACTIVITIES -->
        <div style="margin-bottom:20px;">
            <label><strong>Activities</strong></label>

            <div id="activities_editor" style="height:300px;background:white;border:1px solid #ccc;"></div>
            <input type="hidden" name="activities" id="activities">
        </div>

        <!-- DESCRIPTION -->
        <div style="margin-bottom:20px;">
            <label><strong>Description</strong></label>
            <textarea name="description" rows="3"
                      style="width:100%;padding:10px;border:1px solid #ccc;border-radius:6px;">{{ old('description') }}</textarea>
        </div>

        <!-- DOWNLOAD -->
        <div style="margin-bottom:20px;">
            <label><strong>Downloadable Document</strong></label>
            <input type="file" name="downloads" accept=".pdf,.doc,.docx"
                   style="width:100%;padding:6px;">
        </div>

        <!-- PHOTO -->
        <div style="margin-bottom:20px;">
            <label><strong>Photo</strong></label>
            <input type="file" name="photo" accept="image/*"
                   style="width:100%;padding:6px;">
        </div>

        <button type="submit"
                style="background:#4CAF50;color:white;padding:10px 18px;border:none;border-radius:6px;">
            Create Department
        </button>

    </form>
</div>

<!-- QUILL -->
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<script>
window.onload = function () {

    // OVERVIEW EDITOR
    const overviewQuill = new Quill('#overview_editor', {
        theme: 'snow',
        placeholder: 'Write department overview...',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline'],

                [{ header: [1, 2, 3, false] }],

                // ✅ ALIGNMENT
                [{ align: [] }],

                // ✅ LISTS
                [{ list: 'ordered' }, { list: 'bullet' }],

                // ✅ COLOR OPTIONS
                [{ color: [] }, { background: [] }],

                ['clean']
            ]
        }
    });

    // ACTIVITIES EDITOR
    const activitiesQuill = new Quill('#activities_editor', {
        theme: 'snow',
        placeholder: 'Write department activities...',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline'],

                [{ header: [1, 2, 3, false] }],

                // ✅ ALIGNMENT
                [{ align: [] }],

                // ✅ LISTS
                [{ list: 'ordered' }, { list: 'bullet' }],

                // ✅ COLOR OPTIONS
                [{ color: [] }, { background: [] }],

                ['clean']
            ]
        }
    });

    // SUBMIT HANDLER
    document.getElementById('form').onsubmit = function () {
        document.getElementById('overview').value = overviewQuill.root.innerHTML;
        document.getElementById('activities').value = activitiesQuill.root.innerHTML;
    };

};
</script>

@endsection