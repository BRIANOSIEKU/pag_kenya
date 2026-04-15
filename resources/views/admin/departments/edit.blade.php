@extends('layouts.admin')

@section('content')

<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<div style="max-width:1000px;margin:40px auto;background:#fff;padding:30px;border-radius:10px;">

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h2>Edit Department: {{ $department->name }}</h2>
        <a href="{{ route('admin.departments.index') }}" 
           style="padding:8px 14px; background:#2196F3; color:#fff; border-radius:6px; text-decoration:none;">
            ← Back to Departments
        </a>
    </div>

    @if ($errors->any())
        <div style="margin-bottom:15px; padding:10px 14px; background:#E53935; color:#fff; border-radius:6px;">
            <ul style="margin:0; padding-left:20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.departments.update', $department->id) }}" 
          method="POST" 
          enctype="multipart/form-data" 
          id="form">

        @csrf
        @method('PUT')

        <div style="display:flex; gap:20px; flex-wrap:wrap; margin-bottom:20px;">

            <!-- PHOTO -->
            <div style="flex:1; min-width:250px;">
                <label style="font-weight:bold;">Department Photo</label><br>

                @if($department->photo)
                    <img src="{{ asset('storage/'.$department->photo) }}" 
                         style="width:150px;margin-bottom:10px;border-radius:6px;">
                @else
                    <span style="color:#999;">No Photo Uploaded</span>
                @endif

                <input type="file" name="photo" style="margin-top:8px;">
            </div>

            <!-- BASIC INFO -->
            <div style="flex:2; min-width:300px;">

                <label>Name</label>
                <input type="text" name="name" value="{{ $department->name }}"
                       style="width:100%;padding:10px;border:1px solid #ccc;border-radius:6px;margin-bottom:10px;" required>

                <label>Leadership</label>
                <textarea name="leadership" rows="3"
                          style="width:100%;padding:10px;border:1px solid #ccc;border-radius:6px;margin-bottom:10px;">{{ $department->leadership }}</textarea>

                <label>Description</label>
                <textarea name="description" rows="3"
                          style="width:100%;padding:10px;border:1px solid #ccc;border-radius:6px;margin-bottom:10px;">{{ $department->description }}</textarea>

            </div>
        </div>

        <!-- OVERVIEW -->
        <div style="margin-bottom:20px;">
            <label><strong>Overview</strong></label>
            <div id="overview_editor" style="height:250px;background:white;border:1px solid #ccc;"></div>
            <input type="hidden" name="overview" id="overview">
        </div>

        <!-- ACTIVITIES -->
        <div style="margin-bottom:20px;">
            <label><strong>Activities</strong></label>
            <div id="activities_editor" style="height:250px;background:white;border:1px solid #ccc;"></div>
            <input type="hidden" name="activities" id="activities">
        </div>

        <!-- DOCUMENTS -->
        <div style="margin-bottom:20px;">
            <label style="font-weight:bold;">Existing Documents</label>

            @if($department->documents->count() > 0)
                <ul style="list-style:none;padding-left:0;">
                    @foreach($department->documents as $doc)
                        <li style="display:flex;justify-content:space-between;align-items:center;background:#f5f5f5;margin-bottom:5px;padding:6px;border-radius:6px;">
                            <a href="{{ asset('storage/'.$doc->file_path) }}" target="_blank" style="color:#2196F3;">
                                {{ $doc->name ?? 'Document '.$loop->iteration }}
                            </a>

                            <form action="{{ route('admin.departments.deleteDocument', $doc->id) }}" method="POST"
                                  onsubmit="return confirm('Delete this document?');">
                                @csrf
                                @method('DELETE')
                                <button style="background:#E53935;color:#fff;border:none;padding:3px 8px;border-radius:4px;">
                                    Delete
                                </button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            @else
                <span style="color:#999;">No Documents Uploaded</span>
            @endif
        </div>

        <!-- UPLOAD NEW DOCS -->
        <div style="margin-bottom:20px;">
            <label><strong>Upload New Documents</strong></label><br>
            <input type="file" name="documents[]" multiple>
        </div>

        <button type="submit"
                style="background:#4CAF50;color:#fff;padding:10px 18px;border:none;border-radius:6px;">
            Update Department
        </button>

    </form>
</div>

<!-- QUILL JS -->
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<script>
window.onload = function () {

    // OVERVIEW EDITOR
    const overviewQuill = new Quill('#overview_editor', {
        theme: 'snow',
        placeholder: 'Edit overview...',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline'],

                [{ header: [1, 2, 3, false] }],

                // ✅ ALIGNMENT
                [{ align: [] }],

                // ✅ LISTS
                [{ list: 'ordered' }, { list: 'bullet' }],

                // ✅ COLORS
                [{ color: [] }, { background: [] }],

                ['clean']
            ]
        }
    });

    // ACTIVITIES EDITOR
    const activitiesQuill = new Quill('#activities_editor', {
        theme: 'snow',
        placeholder: 'Edit activities...',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline'],

                [{ header: [1, 2, 3, false] }],

                // ✅ ALIGNMENT
                [{ align: [] }],

                // ✅ LISTS
                [{ list: 'ordered' }, { list: 'bullet' }],

                // ✅ COLORS
                [{ color: [] }, { background: [] }],

                ['clean']
            ]
        }
    });

    // LOAD EXISTING DATA
    overviewQuill.root.innerHTML = {!! json_encode($department->overview) !!};
    activitiesQuill.root.innerHTML = {!! json_encode($department->activities) !!};

    // SUBMIT HANDLER
    document.getElementById('form').onsubmit = function () {
        document.getElementById('overview').value = overviewQuill.root.innerHTML;
        document.getElementById('activities').value = activitiesQuill.root.innerHTML;
    };

};
</script>

@endsection