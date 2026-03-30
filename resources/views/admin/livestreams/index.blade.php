@extends('layouts.admin')

@section('content')
<h1>Live Streams</h1>
<a href="{{ route('admin.livestreams.create') }}"
   style="background-color:#4CAF50; color:#fff; padding:8px 16px; border-radius:6px; text-decoration:none; font-weight:bold;">Add New Stream</a>
<br><br>

@if(session('success'))
    <div style="color:green; margin-bottom:10px;">{{ session('success') }}</div>
@endif

<table border="1" cellpadding="10" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Logo</th>
            <th>Title</th>
            <th>Type</th>
            <th>URL</th>
            <th>Active</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($streams as $stream)
        <tr>
            <td>
                @if($stream->logo)
                    <img src="{{ asset('storage/'.$stream->logo) }}" alt="{{ $stream->title }}" width="80">
                @else
                    N/A
                @endif
            </td>
            <td>{{ $stream->title }}</td>
            <td>{{ ucfirst($stream->type) }}</td>
            <td>{{ $stream->url ?? 'N/A' }}</td>
            <td>{{ $stream->is_active ? 'Yes' : 'No' }}</td>
            <td>
                <a href="{{ route('admin.livestreams.edit', $stream->id) }}"
                   style="background-color:#2196F3; color:#fff; padding:4px 8px; border-radius:4px; text-decoration:none;">Edit</a>

                <form action="{{ route('admin.livestreams.destroy', $stream->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        style="background-color:#F44336; color:#fff; padding:4px 8px; border:none; border-radius:4px; cursor:pointer;">Delete</button>
                </form>

                @if(!$stream->is_active)
                    <form action="{{ route('admin.livestreams.setActive', $stream->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        <button type="submit"
                            style="background-color:#FF9800; color:#fff; padding:4px 8px; border:none; border-radius:4px; cursor:pointer;">Set Active</button>
                    </form>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6">No live streams available.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection