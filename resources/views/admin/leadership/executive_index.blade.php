@extends('layouts.admin')

@section('content')

@php
$typeLabel = [
    'executive' => 'Executive Committee',
    'council' => 'Church Council',
    'hq' => 'PAG Kenya HQ Staff'
][$type] ?? ucfirst($type);
@endphp

<h2>{{ $typeLabel }}</h2>
<a href="{{ route('admin.leadership.create', $type) }}" 
   style="background:#4CAF50; color:#fff; padding:8px 16px; border-radius:6px; text-decoration:none;">
    + Add Leader
</a>

@if(session('success'))
    <div style="background:#d4edda; padding:10px; border-radius:6px; margin-top:15px;">
        {{ session('success') }}
    </div>
@endif

<table style="width:100%; margin-top:20px; border-collapse: collapse;">
    <thead>
        <tr style="background:#f1f1f1;">
            <th>#</th>
            <th>Photo</th>
            <th>Name</th>
            <th>Position</th>
            <th>Contact</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    @forelse($leaders as $i => $leader)
        <tr style="border-bottom:1px solid #ddd;">
            <td>{{ $i + 1 }}</td>
            <td>
                @if($leader->photo)
                    <img src="{{ asset($leader->photo) }}" 
                         alt="Photo" style="width:50px; height:50px; object-fit:cover; border-radius:6px;">
                @else
                    <img src="https://via.placeholder.com/50" alt="No Photo" style="width:50px; height:50px; object-fit:cover; border-radius:6px;">
                @endif
            </td>
            <td>{{ $leader->full_name }}</td>
            <td>{{ $leader->position }}</td>
            <td>{{ $leader->contact }}</td>
            <td>{{ $leader->email }}</td>
            <td style="display:flex; gap:5px;">
                <a href="{{ route('admin.leadership.edit', [$type, $leader->id]) }}" 
                   style="background:#2196F3; color:#fff; padding:4px 8px; border-radius:4px;">Edit</a>
                <form action="{{ route('admin.leadership.destroy', [$type, $leader->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            onclick="return confirm('Delete this leader?')" 
                            style="background:#f44336; color:#fff; padding:4px 8px; border-radius:4px;">Delete</button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7" style="text-align:center;">No leaders found.</td>
        </tr>
    @endforelse
    </tbody>
</table>

@endsection
