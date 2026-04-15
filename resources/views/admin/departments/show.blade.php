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
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 20px;
}

.btn {
    padding: 8px 14px;
    border-radius: 6px;
    font-weight: bold;
    text-decoration: none;
    color: #fff;
    font-size: 14px;
    border: none;
    cursor: pointer;
}

.btn-back {
    background: #9C27B0;
}

.btn-primary {
    background: #2196F3;
}

.btn-success {
    background: #4CAF50;
}

.btn-danger {
    background: #e53935;
}

.card {
    background: #fff;
    padding: 15px;
    border-radius: 10px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.05);
    margin-bottom: 20px;
}

.section-title {
    font-size: 18px;
    font-weight: bold;
    margin: 20px 0 10px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

table th {
    background: #1e3c72;
    color: #fff;
    padding: 12px;
    text-align: left;
}

table td {
    padding: 12px;
    border-bottom: 1px solid #eee;
    vertical-align: top;
}

.small-btn {
    padding: 4px 8px;
    font-size: 12px;
    border-radius: 4px;
    color: #fff;
    border: none;
    cursor: pointer;
}
</style>

<div class="container">

    {{-- HEADER --}}
    <div class="header">

        <a href="{{ route('admin.departments.index') }}" class="btn btn-back">
            ← Back to Departments
        </a>

        <h2 style="margin:0;">Department Details: {{ $department->name }}</h2>

    </div>

    {{-- MAIN CARD --}}
    <div class="card" style="display:flex; gap:30px; flex-wrap:wrap;">

        {{-- PHOTO --}}
        <div>
            @if($department->photo)
                <img src="{{ asset('storage/departments_photos/'.$department->photo) }}"
                     style="width:250px; border-radius:8px; border:1px solid #ddd;">
            @else
                <p>No Photo Available</p>
            @endif
        </div>

        {{-- DETAILS --}}
        <div style="flex:1;">

            <p><b>Name:</b> {{ $department->name }}</p>
            <p><b>Leadership:</b> {{ $department->leadership }}</p>

            <hr>

            <div class="section-title">Overview</div>
            {!! nl2br(e($department->overview)) !!}

            <div class="section-title">Activities</div>
            {!! nl2br(e($department->activities)) !!}

            <div class="section-title">Description</div>
            {!! nl2br(e($department->description)) !!}

        </div>

    </div>

    {{-- DOCUMENTS --}}
    <div class="card">

        <div class="section-title">Documents</div>

        <ul>
            @foreach($department->documents as $doc)
                <li style="margin-bottom:8px;">

                    <a href="{{ asset('storage/departments_documents/'.$doc->file_path) }}"
                       target="_blank"
                       style="color:#2196F3; font-weight:bold;">
                        {{ $doc->name }}
                    </a>

                    <form action="{{ route('admin.departments.deleteDocument', $doc->id) }}"
                          method="POST"
                          style="display:inline;">
                        @csrf
                        @method('DELETE')

                        <button class="small-btn btn-danger">
                            Delete
                        </button>
                    </form>

                </li>
            @endforeach
        </ul>

        <form action="{{ route('admin.departments.uploadDocument', $department->id) }}"
              method="POST"
              enctype="multipart/form-data"
              style="margin-top:10px;">

            @csrf

            <input type="file" name="document" required>
            <input type="text" name="name" placeholder="Document Name" required>

            <button class="btn btn-success">
                Upload
            </button>

        </form>

    </div>

    {{-- ACHIEVEMENTS --}}
    <div class="card">

        <div style="display:flex; justify-content:space-between; align-items:center;">
            <div class="section-title">Achievements</div>

            <button id="toggleAchievementForm" class="btn btn-success">
                + Add Achievement
            </button>
        </div>

        {{-- FORM --}}
        <div id="achievementForm" style="display:none; margin-top:15px;">

            <form action="{{ route('admin.departments.achievements.store', $department->id) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <input type="text" name="name" placeholder="Name" required>
                <textarea name="description" placeholder="Description"></textarea>
                <input type="date" name="date">
                <input type="file" name="photo">

                <button class="btn btn-primary">
                    Save
                </button>

            </form>

        </div>

        {{-- TABLE --}}
        <table style="margin-top:15px;">

            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                @forelse($department->achievements as $achievement)

                <tr>

                    <td>
                        @if($achievement->photo)
                            <img src="{{ Storage::url('departments_achievements/'.$achievement->photo) }}"
                                 style="width:60px;height:60px;border-radius:6px;">
                        @else
                            No Photo
                        @endif
                    </td>

                    <td>{{ $achievement->name }}</td>
                    <td>{{ $achievement->description }}</td>

                    <td>
                        {{ $achievement->date ? \Carbon\Carbon::parse($achievement->date)->format('d M Y') : '-' }}
                    </td>

                    <td>

                        <form action="{{ route('admin.departments.achievements.destroy', $achievement->id) }}"
                              method="POST">
                            @csrf
                            @method('DELETE')

                            <button class="small-btn btn-danger">
                                Delete
                            </button>

                        </form>

                    </td>

                </tr>

                @empty
                    <tr>
                        <td colspan="5" style="text-align:center;">No achievements yet</td>
                    </tr>
                @endforelse

            </tbody>

        </table>

    </div>

</div>

<script>
document.getElementById('toggleAchievementForm').addEventListener('click', function () {
    const form = document.getElementById('achievementForm');
    form.style.display = (form.style.display === 'none' || form.style.display === '')
        ? 'block'
        : 'none';
});
</script>

@endsection