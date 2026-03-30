@extends('layouts.admin')

@section('content')
<!-- Back to Dashboard -->
<a href="{{ route('admin.dashboard') }}" style="padding:8px 12px; background:#2196F3; color:#fff; border-radius:6px; text-decoration:none; margin-bottom:15px; display:inline-block;">
    &larr; Back to Dashboard
</a>

<h1>Devotions</h1>
<a href="{{ route('admin.devotions.create') }}" style="padding:8px 12px; background:#4CAF50; color:#fff; border-radius:6px; text-decoration:none; margin-bottom:15px; display:inline-block;">
    + Add Devotion
</a>

@if(session('success'))
    <div style="margin:10px 0; padding:10px; background:#d4edda; color:#155724; border-radius:6px;">
        {{ session('success') }}
    </div>
@endif

<table style="width:100%; border-collapse:collapse;">
    <thead>
        <tr style="background:#f5f5f5;">
            <th style="padding:8px; border:1px solid #ddd;">#</th>
            <th style="padding:8px; border:1px solid #ddd;">Title</th>
            <th style="padding:8px; border:1px solid #ddd;">Author</th>
            <th style="padding:8px; border:1px solid #ddd;">Date</th>
            <th style="padding:8px; border:1px solid #ddd;">Thumbnail</th>
            <th style="padding:8px; border:1px solid #ddd;">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($devotions as $devotion)
        <tr>
            <td style="padding:8px; border:1px solid #ddd;">{{ $devotion->id }}</td>
            <td style="padding:8px; border:1px solid #ddd;">{{ $devotion->title }}</td>
            <td style="padding:8px; border:1px solid #ddd;">{{ $devotion->author }}</td>
            <td style="padding:8px; border:1px solid #ddd;">{{ \Carbon\Carbon::parse($devotion->date)->format('d M Y') }}</td>
            <td style="padding:8px; border:1px solid #ddd;">
                @if($devotion->thumbnail)
                    <img src="{{ asset($devotion->thumbnail) }}" alt="Thumbnail" style="width:60px; height:60px; object-fit:cover; border-radius:4px;">
                @else
                    N/A
                @endif
            </td>
            <td style="padding:8px; border:1px solid #ddd;">
                <a href="{{ route('admin.devotions.show', $devotion->id) }}" style="margin-right:5px;">View</a>
                <a href="{{ route('admin.devotions.edit', $devotion->id) }}" style="margin-right:5px;">Edit</a>
                <form action="{{ route('admin.devotions.destroy', $devotion->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Delete this devotion?');" style="color:red; background:none; border:none; cursor:pointer;">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div style="margin-top:15px;">
    {{ $devotions->links() }}
</div>
@endsection
