@extends('layouts.admin')

@section('content')

<!-- Top Buttons -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <!-- Back to Dashboard Button (Left) -->
    <a href="{{ route('admin.dashboard') }}" style="
        background-color:#607D8B;
        color:#fff;
        padding:10px 16px;
        border-radius:6px;
        font-weight:bold;
        text-decoration:none;
        transition:0.3s;
    "
    onmouseover="this.style.opacity='0.8'"
    onmouseout="this.style.opacity='1'"
    >&larr; Back to Dashboard</a>

    <!-- Add Department Button (Right) -->
    <a href="{{ route('admin.departments.create') }}" style="
        background-color:#9C27B0;
        color:#fff;
        padding:10px 16px;
        border-radius:6px;
        font-weight:bold;
        text-decoration:none;
        transition:0.3s;
    "
    onmouseover="this.style.opacity='0.8'"
    onmouseout="this.style.opacity='1'"
    >Add Department</a>
</div>

@if(session('success'))
    <div style="background-color:#4CAF50; color:white; padding:10px 15px; border-radius:6px; margin-bottom:20px;">
        {{ session('success') }}
    </div>
@endif

<table style="width:100%; border-collapse: collapse;">
    <thead>
        <tr style="background:#f5f5f5; text-align:left;">
            <th style="padding:10px; border-bottom:1px solid #ddd;">Photo</th>
            <th style="padding:10px; border-bottom:1px solid #ddd;">Name</th>
            <th style="padding:10px; border-bottom:1px solid #ddd;">Leadership</th>
            <th style="padding:10px; border-bottom:1px solid #ddd;">Documents</th>
            <th style="padding:10px; border-bottom:1px solid #ddd;">Actions</th>
        </tr>
    </thead>
    <tbody>
    @foreach($departments as $department)
        <tr>
            <!-- Photo -->
            <td style="padding:10px; border-bottom:1px solid #ddd; text-align:center;">
                @if($department->photo && Storage::disk('public')->exists('departments_photos/'.$department->photo))
                    <img src="{{ Storage::url('departments_photos/'.$department->photo) }}" 
                         alt="Photo" style="width:80px; height:80px; object-fit:cover; border-radius:6px;">
                @else
                    <span style="color:#888;">No Photo</span>
                @endif
            </td>

            <!-- Name -->
            <td style="padding:10px; border-bottom:1px solid #ddd;">{{ $department->name }}</td>

            <!-- Leadership -->
            <td style="padding:10px; border-bottom:1px solid #ddd;">{{ $department->leadership ?? '-' }}</td>

            <!-- Documents -->
            <td style="padding:10px; border-bottom:1px solid #ddd;">
                @if($department->documents->count())
                    <ul style="padding-left:18px; margin:0;">
                        @foreach($department->documents as $doc)
                            <li style="margin-bottom:5px;">
                                <a href="{{ Storage::url('departments_documents/'.$doc->file_path) }}" target="_blank">{{ $doc->name }}</a>
                                <!-- Delete Document -->
                                <form action="{{ route('admin.departments.deleteDocument', $doc->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="
                                        background: #e53935;
                                        color: #fff;
                                        border:none;
                                        padding:2px 6px;
                                        border-radius:4px;
                                        cursor:pointer;
                                        font-size:0.75rem;
                                        margin-left:5px;
                                    ">Delete</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <span style="color:#888;">No Documents</span>
                @endif

                <!-- Inline Upload Form -->
                <form action="{{ route('admin.departments.uploadDocument', $department->id) }}" method="POST" enctype="multipart/form-data" style="margin-top:8px;">
                    @csrf
                    <input type="text" name="name" placeholder="Document Name" style="padding:4px 6px; font-size:0.85rem; width:100%; margin-bottom:4px;" required>
                    <input type="file" name="document" required style="font-size:0.85rem; margin-bottom:4px;">
                    <button type="submit" style="
                        background:#4CAF50;
                        color:#fff;
                        padding:4px 8px;
                        font-size:0.85rem;
                        border-radius:4px;
                        cursor:pointer;
                    ">Upload</button>
                </form>
            </td>

            <!-- Actions -->
            <td style="padding:10px; border-bottom:1px solid #ddd;">
                <a href="{{ route('admin.departments.show', $department->id) }}" style="
                    background:#2196F3;
                    color:#fff;
                    padding:6px 10px;
                    border-radius:4px;
                    font-size:0.85rem;
                    text-decoration:none;
                    display:inline-block;
                    margin-bottom:4px;
                ">View</a>
                <a href="{{ route('admin.departments.edit', $department->id) }}" style="
                    background:#FFC107;
                    color:#fff;
                    padding:6px 10px;
                    border-radius:4px;
                    font-size:0.85rem;
                    text-decoration:none;
                    display:inline-block;
                    margin-bottom:4px;
                ">Edit</a>
                <form action="{{ route('admin.departments.destroy', $department->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="
                        background:#e53935;
                        color:#fff;
                        padding:6px 10px;
                        border:none;
                        border-radius:4px;
                        cursor:pointer;
                        font-size:0.85rem;
                    ">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<!-- Pagination -->
<div style="margin-top:20px;">
    {{ $departments->links('pagination::bootstrap-5') }}
</div>

@endsection
