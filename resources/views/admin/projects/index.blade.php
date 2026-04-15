@extends('layouts.admin')

@section('content')

<style>
.container {
    max-width: 1100px;
    margin: auto;
    padding: 20px;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 15px;
}

.btn {
    padding: 8px 12px;
    border-radius: 6px;
    color: #fff;
    text-decoration: none;
    font-size: 14px;
    font-weight: bold;
    border: none;
    cursor: pointer;
}

.btn-primary { background: #4CAF50; }
.btn-edit { background: #2196F3; }
.btn-danger { background: #FF5722; }

.table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.table th {
    background: #f2f2f2;
    padding: 10px;
    border: 1px solid #ddd;
    text-align: left;
}

.table td {
    padding: 10px;
    border: 1px solid #ddd;
}

.badge-success {
    color: green;
    margin-bottom: 10px;
}

.project-img {
    width: 80px;
    border-radius: 4px;
}
</style>

<div class="container">

    <!-- HEADER -->
    <div class="header">
        <h2>Projects</h2>

        <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">
            + Add New Project
        </a>
    </div>

    <!-- SUCCESS MESSAGE -->
    @if(session('success'))
        <div class="badge-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- TABLE -->
    <table class="table">

        <thead>
            <tr>
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

                    <!-- CLICKABLE TITLE -->
                    <td>
                        <a href="{{ route('admin.projects.show', $project->id) }}"
                           style="color:#4CAF50; font-weight:bold; text-decoration:none;">
                            {{ $project->title }}
                        </a>
                    </td>

                    <td>{{ \Illuminate\Support\Str::limit($project->description, 50) }}</td>

                    <td>
                        @if($project->image)
                            <img src="{{ asset('storage/' . $project->image) }}" class="project-img">
                        @endif
                    </td>

                    <td>{{ $project->progress ?? '-' }}</td>

                    <td style="display:flex; gap:6px; flex-wrap:wrap;">

                        <a href="{{ route('admin.projects.edit', $project->id) }}" class="btn btn-edit">
                            Edit
                        </a>

                        <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="btn btn-danger"
                                    onclick="return confirm('Delete this project?')">
                                Delete
                            </button>
                        </form>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center; padding:15px;">
                        No projects found.
                    </td>
                </tr>
            @endforelse
        </tbody>

    </table>

</div>

@endsection