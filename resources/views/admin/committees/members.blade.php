@extends('layouts.admin')

@section('content')

<h1>{{ $committee->name }} - Members</h1>

<!-- Add New Member Button -->
<a href="{{ route('admin.committees.members.create', $committee->id) }}" 
   style="padding:8px 12px; background:#4CAF50; color:#fff; border-radius:6px; text-decoration:none; margin-bottom:15px; display:inline-block;">
    + Add New Member
</a>

@if(session('success'))
    <div style="margin:10px 0; padding:10px; background:#d4edda; color:#155724; border-radius:6px;">
        {{ session('success') }}
    </div>
@endif

<!-- Search Form -->
<form action="{{ route('admin.committees.members.index', $committee->id) }}" method="GET" style="margin-bottom:15px; display:flex; gap:8px; flex-wrap:wrap;">
    <input type="text" name="search" placeholder="Search by name or phone..." 
           value="{{ request('search') }}" 
           style="padding:6px 10px; border-radius:4px; border:1px solid #ccc; flex:1; min-width:200px;">
    <button type="submit" style="padding:6px 12px; background:#2196F3; color:#fff; border:none; border-radius:4px;">Search</button>
</form>

<table style="width:100%; border-collapse:collapse; box-shadow:0 2px 8px rgba(0,0,0,0.1);">
    <thead>
        <tr style="background:#f5f5f5; text-align:left;">
            <th style="padding:10px; border:1px solid #ddd;">#</th>
            <th style="padding:10px; border:1px solid #ddd;">Name</th>
            <th style="padding:10px; border:1px solid #ddd;">Gender</th>
            <th style="padding:10px; border:1px solid #ddd;">Member ID</th>
            <th style="padding:10px; border:1px solid #ddd;">Phone</th>
            <th style="padding:10px; border:1px solid #ddd;">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($members as $index => $member)
        <tr>
            <td style="padding:10px; border:1px solid #ddd;">{{ $index + 1 }}</td>
            <td style="padding:10px; border:1px solid #ddd;">{{ $member->member_name }}</td>
            <td style="padding:10px; border:1px solid #ddd;">{{ $member->member_gender ?? '-' }}</td>
            <td style="padding:10px; border:1px solid #ddd;">{{ $member->member_id ?? '-' }}</td>
            <td style="padding:10px; border:1px solid #ddd;">{{ $member->phone ?? '-' }}</td>

            <!-- Actions -->
            <td style="padding:10px; border:1px solid #ddd;">
                <a href="{{ route('admin.committees.members.edit', [$committee->id, $member->id]) }}" 
                   style="margin-right:5px; color:#fff; background:#FFC107; padding:4px 8px; border-radius:4px; text-decoration:none;">
                    Edit
                </a>
                <form action="{{ route('admin.committees.members.destroy', [$committee->id, $member->id]) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Delete this member?');" 
                            style="color:#fff; background:#F44336; padding:4px 8px; border:none; border-radius:4px; cursor:pointer;">
                        Delete
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Pagination -->
@if(method_exists($members, 'links'))
    <div style="margin-top:15px;">
        {{ $members->links() }}
    </div>
@endif

@endsection