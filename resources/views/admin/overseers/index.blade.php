@extends('layouts.admin')

@section('content')
<h1>Church Overseers</h1>

<a href="{{ route('admin.overseers.create') }}" 
   style="padding:8px 12px; background:#4CAF50; color:#fff; border-radius:6px; text-decoration:none; margin-bottom:15px; display:inline-block;">
    + Add Overseer
</a>

@if(session('success'))
    <div style="margin:10px 0; padding:10px; background:#d4edda; color:#155724; border-radius:6px;">
        {{ session('success') }}
    </div>
@endif

<!-- Search Form -->
<form action="{{ route('admin.overseers.index') }}" method="GET" style="margin-bottom:15px; display:flex; gap:8px; flex-wrap:wrap;">
    <input type="text" name="search" placeholder="Search by name, district, email..." 
           value="{{ request('search') }}" 
           style="padding:6px 10px; border-radius:4px; border:1px solid #ccc; flex:1; min-width:200px;">
    <button type="submit" style="padding:6px 12px; background:#2196F3; color:#fff; border:none; border-radius:4px;">Search</button>
</form>

<table style="width:100%; border-collapse:collapse; box-shadow:0 2px 8px rgba(0,0,0,0.1);">
    <thead>
        <tr style="background:#f5f5f5; text-align:left;">
            <th style="padding:10px; border:1px solid #ddd;">#</th>
            <th style="padding:10px; border:1px solid #ddd;">Photo</th>
            <th style="padding:10px; border:1px solid #ddd;">Name</th>
            <th style="padding:10px; border:1px solid #ddd;">District</th>
            <th style="padding:10px; border:1px solid #ddd;">Email</th>
            <th style="padding:10px; border:1px solid #ddd;">Phone</th>
            <th style="padding:10px; border:1px solid #ddd;">Gender</th>
            <th style="padding:10px; border:1px solid #ddd;">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($overseers as $index => $overseer)
        <tr>
            <td style="padding:10px; border:1px solid #ddd;">{{ $index + 1 }}</td>
            <td style="padding:10px; border:1px solid #ddd; text-align:center;">
                @if($overseer->photo)
                    <img src="{{ asset('storage/'.$overseer->photo) }}" alt="{{ $overseer->name }}" style="width:60px; height:60px; object-fit:cover; border-radius:50%;">
                @else
                    <div style="width:60px; height:60px; border-radius:50%; background:#e0e0e0; display:flex; align-items:center; justify-content:center; color:#888;">
                        N/A
                    </div>
                @endif
            </td>
            <td style="padding:10px; border:1px solid #ddd;">{{ $overseer->name }}</td>
            <td style="padding:10px; border:1px solid #ddd;">{{ $overseer->district_name }}</td>
            <td style="padding:10px; border:1px solid #ddd;">{{ $overseer->email ?? '-' }}</td>
            <td style="padding:10px; border:1px solid #ddd;">{{ $overseer->phone ?? '-' }}</td>
            <td style="padding:10px; border:1px solid #ddd;">{{ ucfirst($overseer->gender) }}</td>
            <td style="padding:10px; border:1px solid #ddd;">
                <a href="{{ route('admin.overseers.edit', $overseer->id) }}" style="margin-right:5px; color:#fff; background:#FFC107; padding:4px 8px; border-radius:4px; text-decoration:none;">Edit</a>
                <form action="{{ route('admin.overseers.destroy', $overseer->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Delete this overseer?');" 
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
@if(method_exists($overseers, 'links'))
    <div style="margin-top:15px;">
        {{ $overseers->links() }}
    </div>
@endif

@endsection