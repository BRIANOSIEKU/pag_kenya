@extends('layouts.admin')

@section('content')
<h1>Committees</h1>

<!-- Add Committee Button -->
<a href="{{ route('admin.committees.create') }}" 
   style="padding:8px 12px; background:#4CAF50; color:#fff; border-radius:6px; text-decoration:none; margin-bottom:15px; display:inline-block;">
    + Add Committee
</a>

@if(session('success'))
    <div style="margin:10px 0; padding:10px; background:#d4edda; color:#155724; border-radius:6px;">
        {{ session('success') }}
    </div>
@endif

<!-- Search Form -->
<form action="{{ route('admin.committees.index') }}" method="GET" style="margin-bottom:15px; display:flex; gap:8px; flex-wrap:wrap;">
    <input type="text" name="search" placeholder="Search by committee name..." 
           value="{{ request('search') }}" 
           style="padding:6px 10px; border-radius:4px; border:1px solid #ccc; flex:1; min-width:200px;">
    <button type="submit" style="padding:6px 12px; background:#2196F3; color:#fff; border:none; border-radius:4px;">Search</button>
</form>

<!-- Committees Table -->
<table style="width:100%; border-collapse:collapse; box-shadow:0 2px 8px rgba(0,0,0,0.1);">
    <thead>
        <tr style="background:#f5f5f5; text-align:left;">
            <th style="padding:10px; border:1px solid #ddd;">#</th>
            <th style="padding:10px; border:1px solid #ddd;">Name</th>
            <th style="padding:10px; border:1px solid #ddd;">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($committees as $index => $committee)
        <tr>
            <td style="padding:10px; border:1px solid #ddd;">{{ $index + 1 }}</td>
            <td style="padding:10px; border:1px solid #ddd;">{{ $committee->name }}</td>
            <td style="padding:10px; border:1px solid #ddd; display:flex; flex-wrap:wrap; gap:5px;">
                
                <!-- Committee Sub-links -->
                <a href="{{ route('admin.committees.leadership', $committee->id) }}" 
                   style="color:#fff; background:#9C27B0; padding:4px 8px; border-radius:4px; text-decoration:none;">
                   Leadership
                </a>

                <a href="{{ route('admin.committees.members.index', $committee->id) }}" 
                   style="color:#fff; background:#4CAF50; padding:4px 8px; border-radius:4px; text-decoration:none;">
                   Members
                </a>

                <a href="{{ route('admin.committees.reports.index', $committee->id) }}" 
                   style="color:#fff; background:#FFC107; padding:4px 8px; border-radius:4px; text-decoration:none;">
                   Reports
                </a>

                <a href="{{ route('admin.committees.duties', $committee->id) }}" 
                   style="color:#fff; background:#3F51B5; padding:4px 8px; border-radius:4px; text-decoration:none;">
                   Duties
                </a>

                <a href="{{ route('admin.committees.edit', $committee->id) }}" 
                   style="color:#fff; background:#2196F3; padding:4px 8px; border-radius:4px; text-decoration:none;">
                   Edit
                </a>

            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Pagination -->
@if(method_exists($committees, 'links'))
    <div style="margin-top:15px;">
        {{ $committees->links() }}
    </div>
@endif

@endsection