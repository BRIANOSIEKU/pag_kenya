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
    padding: 5px 10px;
    font-size: 12px;
    border-radius: 4px;
    border: none;
    color: #fff;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    margin-right: 5px;
    margin-bottom: 5px;
}

.btn-view { background: #2196F3; }
.btn-edit { background: #FFC107; }
.btn-delete { background: #e53935; }
.btn-gallery { background: #8E24AA; }
.btn-leadership { background: #4CAF50; }

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
                           class="small-btn btn-gallery">
                            Gallery
                        </a>

                        <a href="{{ route('admin.departments.other-leaders.index', $department->id) }}"
                           class="small-btn btn-leadership">
                            Other Leaders
                        </a>
                        <a href="{{ route('admin.departments.department_upcoming_events.index', ['department' => $department->id]) }}"
                           class="small-btn btn-leadership">
                            Upcoming Events
                        </a>
                        <a href="{{ route('admin.departments.finance.dashboard',['department' => $department->id]) }}"
   class="small-btn"
   style="background:#0D47A1;">
    Finance
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