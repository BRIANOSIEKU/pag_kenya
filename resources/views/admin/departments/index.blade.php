@extends('layouts.admin')

@section('content')

<style>
.container {
    max-width: 1200px;
    margin: auto;
    padding: 20px;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    flex-wrap: wrap;
    gap: 10px;
}

.btn {
    padding: 8px 14px;
    border-radius: 6px;
    font-weight: bold;
    text-decoration: none;
    color: #fff;
    font-size: 14px;
    display: inline-block;
    transition: 0.3s;
}

.btn:hover {
    opacity: 0.85;
}

.btn-dashboard {
    background: #607D8B;
}

.btn-add {
    background: #9C27B0;
}

.card {
    background: #fff;
    padding: 15px;
    border-radius: 10px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.05);
    overflow-x: auto;
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table th {
    background: #1e3c72;
    color: #fff;
    padding: 12px;
    text-align: left;
}

.table td {
    padding: 12px;
    border-bottom: 1px solid #eee;
    vertical-align: top;
}

.small-btn {
    padding: 4px 8px;
    font-size: 12px;
    border-radius: 4px;
    border: none;
    color: #fff;
    cursor: pointer;
}

.btn-view { background: #2196F3; }
.btn-edit { background: #FFC107; }
.btn-delete { background: #e53935; }
.btn-upload { background: #4CAF50; }
.btn-gallery { background: #8E24AA; }

input, textarea {
    width: 100%;
    padding: 6px;
    margin-bottom: 5px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 13px;
}
</style>

<div class="container">

    {{-- HEADER --}}
    <div class="header">

        <a href="{{ route('admin.dashboard') }}" class="btn btn-dashboard">
            ← Back to Dashboard
        </a>

        <a href="{{ route('admin.departments.create') }}" class="btn btn-add">
            + Add Department
        </a>

    </div>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div style="background:#4CAF50; color:#fff; padding:10px; border-radius:6px; margin-bottom:15px;">
            {{ session('success') }}
        </div>
    @endif

    {{-- TABLE --}}
    <div class="card">

        <table class="table">

            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Leadership</th>
                    <th>Documents</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                @foreach($departments as $department)

                <tr>

                    {{-- PHOTO --}}
                    <td>
                        @if($department->photo && Storage::disk('public')->exists('departments_photos/'.$department->photo))
                            <img src="{{ Storage::url('departments_photos/'.$department->photo) }}"
                                 style="width:80px;height:80px;object-fit:cover;border-radius:6px;">
                        @else
                            <span style="color:#888;">No Photo</span>
                        @endif
                    </td>

                    {{-- NAME --}}
                    <td>{{ $department->name }}</td>

                    {{-- LEADERSHIP --}}
                    <td>{{ $department->leadership ?? '-' }}</td>

                    {{-- DOCUMENTS --}}
                    <td>

                        @if($department->documents->count())

                            <ul style="padding-left:18px; margin:0;">

                                @foreach($department->documents as $doc)
                                    <li style="margin-bottom:6px;">

                                        <a href="{{ Storage::url('departments_documents/'.$doc->file_path) }}"
                                           target="_blank"
                                           style="color:#2196F3; font-weight:bold;">
                                            {{ $doc->name }}
                                        </a>

                                        <form action="{{ route('admin.departments.deleteDocument', $doc->id) }}"
                                              method="POST"
                                              style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="small-btn btn-delete">
                                                Delete
                                            </button>
                                        </form>

                                    </li>
                                @endforeach

                            </ul>

                        @else
                            <span style="color:#888;">No Documents</span>
                        @endif

                        {{-- UPLOAD DOCUMENT --}}
                        <form action="{{ route('admin.departments.uploadDocument', $department->id) }}"
                              method="POST"
                              enctype="multipart/form-data"
                              style="margin-top:8px;">

                            @csrf

                            <input type="text" name="name" placeholder="Document Name" required>
                            <input type="file" name="document" required>

                            <button type="submit" class="small-btn btn-upload">
                                Upload
                            </button>

                        </form>

                    </td>

                    {{-- ACTIONS --}}
                    <td>

                        <a href="{{ route('admin.departments.show', $department->id) }}"
                           class="small-btn btn-view">
                            View
                        </a>

                        <a href="{{ route('admin.departments.edit', $department->id) }}"
                           class="small-btn btn-edit">
                            Edit
                        </a>

                        <form action="{{ route('admin.departments.destroy', $department->id) }}"
                              method="POST"
                              style="display:inline;">
                            @csrf
                            @method('DELETE')

                            <button class="small-btn btn-delete"
                                    onclick="return confirm('Delete this department?')">
                                Delete
                            </button>

                        </form>

                        <a href="{{ route('admin.departments.gallery', $department->id) }}"
                           class="small-btn btn-gallery"
                           style="margin-top:5px; display:inline-block;">
                            Gallery
                        </a>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

    {{-- PAGINATION --}}
    <div style="margin-top:20px;">
        {{ $departments->links('pagination::bootstrap-5') }}
    </div>

</div>

@endsection