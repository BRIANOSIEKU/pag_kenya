@extends('layouts.admin')

@section('content')
<h2>Manage Announcements</h2>

<a href="{{ route('admin.announcements.create') }}"
   style="background-color:#FFA500; color:#fff; padding:8px 16px; border-radius:6px; font-weight:bold; text-decoration:none; margin-bottom:15px; display:inline-block;">
   + Add New Announcement
</a>

@if(session('success'))
    <div style="margin:10px 0; padding:10px; background-color:#d4edda; color:#155724; border-radius:6px;">
        {{ session('success') }}
    </div>
@endif

<table style="width:100%; border-collapse:collapse; margin-top:10px;">
    <thead>
        <tr style="background-color:#f5f5f5;">
            <th style="padding:8px; border:1px solid #ddd;">#</th>
            <th style="padding:8px; border:1px solid #ddd;">Title</th>
            <th style="padding:8px; border:1px solid #ddd;">Type</th>
            <th style="padding:8px; border:1px solid #ddd;">Description</th>
            <th style="padding:8px; border:1px solid #ddd;">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($announcements as $announcement)
        <tr>
            <td style="padding:8px; border:1px solid #ddd;">{{ $loop->iteration + ($announcements->currentPage()-1)*$announcements->perPage() }}</td>
            <td style="padding:8px; border:1px solid #ddd;">{{ $announcement->title }}</td>
            <td style="padding:8px; border:1px solid #ddd; text-transform:capitalize;">{{ $announcement->type }}</td>
            <td style="padding:8px; border:1px solid #ddd;">{{ Str::limit($announcement->description, 50) }}</td>
            <td style="padding:8px; border:1px solid #ddd; display:flex; gap:6px;">
                <a href="{{ route('admin.announcements.show', $announcement->id) }}"
                   style="background-color:#2196F3; color:#fff; padding:6px 10px; border-radius:6px; font-weight:bold; text-decoration:none;">
                   View
                </a>
                <a href="{{ route('admin.announcements.edit', $announcement->id) }}"
                   style="background-color:#4CAF50; color:#fff; padding:6px 10px; border-radius:6px; font-weight:bold; text-decoration:none;">
                   Edit
                </a>
                <form action="{{ route('admin.announcements.destroy', $announcement->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            style="background-color:#F44336; color:#fff; padding:6px 10px; border-radius:6px; font-weight:bold; border:none; cursor:pointer;">
                        Delete
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div style="margin-top:15px;">
    {{ $announcements->links() }}
</div>
@endsection