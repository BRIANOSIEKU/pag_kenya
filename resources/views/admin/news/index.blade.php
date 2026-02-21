@extends('layouts.admin')

@section('content')
<h1>News & Updates</h1>
<a href="{{ route('admin.news.create') }}" style="padding:8px 12px; background:#4CAF50; color:#fff; border-radius:6px; text-decoration:none; margin-bottom:15px; display:inline-block;">
    + Add News
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
            <th style="padding:8px; border:1px solid #ddd;">Created At</th>
            <th style="padding:8px; border:1px solid #ddd;">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($news as $item)
        <tr>
            <td style="padding:8px; border:1px solid #ddd;">{{ $item->id }}</td>
            <td style="padding:8px; border:1px solid #ddd;">{{ $item->title }}</td>
            <td style="padding:8px; border:1px solid #ddd;">{{ $item->created_at->format('d M Y') }}</td>
            <td style="padding:8px; border:1px solid #ddd;">
                <a href="{{ route('admin.news.show', $item->id) }}" style="margin-right:5px;">View</a>
                <a href="{{ route('admin.news.edit', $item->id) }}" style="margin-right:5px;">Edit</a>
                <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Delete this news?');" style="color:red; background:none; border:none; cursor:pointer;">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div style="margin-top:15px;">
    {{ $news->links() }}
</div>
@endsection
