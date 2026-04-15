@extends('layouts.admin')

@section('content')

<style>
    .container-box {
        max-width: 1100px;
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
        text-decoration: none;
        font-weight: bold;
        color: #fff;
        display: inline-block;
        transition: 0.2s;
    }

    .btn:hover {
        opacity: 0.85;
    }

    .btn-add {
        background: #FFA500;
    }

    .btn-view {
        background: #2196F3;
    }

    .btn-edit {
        background: #4CAF50;
    }

    .btn-delete {
        background: #F44336;
        border: none;
        cursor: pointer;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
    }

    th, td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: left;
    }

    thead {
        background: #f5f5f5;
    }

    tr:hover {
        background: #fafafa;
    }

    .alert {
        padding: 10px;
        border-radius: 6px;
        margin-bottom: 15px;
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
    }

    .actions {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }
</style>

<div class="container-box">

    <div class="header">
        <h2>Manage Announcements</h2>

        <a href="{{ route('admin.announcements.create') }}" class="btn btn-add">
            + Add New Announcement
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Type</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse($announcements as $announcement)
                <tr>
                    <td>
                        {{ $loop->iteration + ($announcements->currentPage()-1)*$announcements->perPage() }}
                    </td>

                    <td>{{ $announcement->title }}</td>

                    <td style="text-transform: capitalize;">
                        {{ $announcement->type }}
                    </td>

                    <td>{{ Str::limit($announcement->description, 50) }}</td>

                    <td>
                        <div class="actions">
                            <a href="{{ route('admin.announcements.show', $announcement->id) }}" class="btn btn-view">
                                View
                            </a>

                            <a href="{{ route('admin.announcements.edit', $announcement->id) }}" class="btn btn-edit">
                                Edit
                            </a>

                            <form action="{{ route('admin.announcements.destroy', $announcement->id) }}" method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete this announcement?');">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-delete">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center; padding:15px;">
                        No announcements found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top:15px;">
        {{ $announcements->links() }}
    </div>

</div>

@endsection