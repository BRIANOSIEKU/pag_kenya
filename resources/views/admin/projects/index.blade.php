@extends('layouts.admin')

@section('content')
<h2>Projects</h2>

<a href="{{ route('admin.projects.create') }}" 
   style="background-color:#4CAF50; color:#fff; padding:8px 12px; border-radius:6px; text-decoration:none;">
   Add New Project
</a>

@if(session('success'))
    <p style="color:green; margin-top:10px;">{{ session('success') }}</p>
@endif

<table border="1" cellpadding="8" cellspacing="0" style="width:100%; margin-top:15px; border-collapse:collapse;">
    <thead>
        <tr style="background-color:#f2f2f2;">
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Image</th>
            <th>Progress</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($projects as $project)
        <tr>
            <td>{{ $project->id }}</td>
            
            <!-- Make title clickable to Show page -->
            <td>
                <a href="{{ route('admin.projects.show', $project->id) }}" 
                   style="color:#4CAF50; text-decoration:underline;">
                   {{ $project->title }}
                </a>
            </td>
            
            <td>{{ \Illuminate\Support\Str::limit($project->description, 50) }}</td>
            
            <td>
                @if($project->image)
                    <img src="{{ asset('storage/' . $project->image) }}" width="80" alt="Project Image" style="border-radius:4px;">
                @endif
            </td>
            
            <td>{{ $project->progress ?? '-' }}</td>
            
            <td>
                <a href="{{ route('admin.projects.edit', $project->id) }}" 
                   style="margin-right:5px; color:#2196F3;">Edit</a>
                <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Delete this project?')" style="color:#FF5722; background:none; border:none; cursor:pointer;">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" style="text-align:center;">No projects found.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
