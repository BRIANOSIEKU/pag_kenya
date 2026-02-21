@extends('layouts.admin')

@section('content')

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <h1>Edit Department: {{ $department->name }}</h1>
    <a href="{{ route('admin.departments.index') }}" style="padding:8px 14px; background:#2196F3; color:#fff; border-radius:6px; text-decoration:none;">
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

<form action="{{ route('admin.departments.update', $department->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div style="display:flex; gap:20px; flex-wrap:wrap; margin-bottom:20px;">
        <!-- Photo -->
        <div style="flex:1; min-width:250px;">
            <label style="font-weight:bold;">Department Photo</label><br>
            @if($department->photo)
                <img src="{{ asset('storage/'.$department->photo) }}" alt="Photo" style="width:150px; margin-bottom:10px; display:block; border-radius:4px;">
            @else
                <span style="color:#999;">No Photo Uploaded</span>
            @endif
            <input type="file" name="photo" style="margin-top:8px;">
        </div>

        <!-- Department Info -->
        <div style="flex:2; min-width:300px;">
            <label>Name</label>
            <input type="text" name="name" value="{{ $department->name }}" class="form-control" style="width:100%; padding:6px; margin-bottom:10px;" required>

            <label>Overview</label>
            <textarea name="overview" class="form-control" style="width:100%; padding:6px; margin-bottom:10px;" rows="3">{{ $department->overview }}</textarea>

            <label>Leadership</label>
            <textarea name="leadership" class="form-control" style="width:100%; padding:6px; margin-bottom:10px;" rows="3">{{ $department->leadership }}</textarea>

            <label>Activities</label>
            <textarea name="activities" class="form-control" style="width:100%; padding:6px; margin-bottom:10px;" rows="3">{{ $department->activities }}</textarea>

            <label>Description</label>
            <textarea name="description" class="form-control" style="width:100%; padding:6px; margin-bottom:10px;" rows="3">{{ $department->description }}</textarea>
        </div>
    </div>

    <!-- Existing Documents -->
    <div style="margin-bottom:20px;">
        <label style="font-weight:bold;">Existing Documents</label>
        @if($department->documents->count() > 0)
            <ul style="list-style:none; padding-left:0;">
                @foreach($department->documents as $doc)
                    <li style="display:flex; align-items:center; justify-content:space-between; margin-bottom:4px; padding:4px 6px; background:#f0f0f0; border-radius:4px;">
                        <a href="{{ asset('storage/'.$doc->file_path) }}" target="_blank" style="color:#2196F3; text-decoration:none;">
                            {{ $doc->name ?? 'Document '.$loop->iteration }}
                        </a>

                        <form action="{{ route('admin.departments.deleteDocument', $doc->id) }}" method="POST" onsubmit="return confirm('Delete this document?');" style="margin:0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background:#E53935; color:#fff; border:none; padding:2px 6px; border-radius:4px; cursor:pointer;">Delete</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @else
            <span style="color:#999;">No Documents Uploaded</span>
        @endif
    </div>

    <!-- Upload New Documents -->
    <div style="margin-bottom:20px;">
        <label style="font-weight:bold;">Upload New Documents (Multiple allowed)</label><br>
        <input type="file" name="documents[]" multiple>
    </div>

    <button type="submit" style="background:#4CAF50; color:#fff; padding:8px 14px; border:none; border-radius:6px; cursor:pointer;">
        Update Department
    </button>
</form>

@endsection
