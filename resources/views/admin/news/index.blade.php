@extends('layouts.admin')

@section('content')

<style>
.container {
    max-width: 1100px;
    margin: auto;
    padding: 20px;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 15px;
}

.btn {
    padding: 8px 12px;
    border-radius: 6px;
    color: #fff;
    text-decoration: none;
    font-size: 14px;
    font-weight: bold;
    border: none;
    cursor: pointer;
}

.btn-primary { background: #4CAF50; }
.btn-view { background: #2196F3; }
.btn-edit { background: #FF9800; }
.btn-danger { background: #F44336; }

.table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.table th {
    background: #f5f5f5;
    padding: 10px;
    border: 1px solid #ddd;
    text-align: left;
}

.table td {
    padding: 10px;
    border: 1px solid #ddd;
}

.badge-success {
    background: #d4edda;
    color: #155724;
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 15px;
}
</style>

<div class="container">

    <!-- HEADER -->
    <div class="header">
        <h2>News & Updates</h2>

        <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
            + Add News
        </a>
    </div>

    <!-- SUCCESS -->
    @if(session('success'))
        <div class="badge-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- TABLE -->
    <table class="table">

        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse($news as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->created_at->format('d M Y') }}</td>
                    <td style="display:flex; gap:6px; flex-wrap:wrap;">

                        <a href="{{ route('admin.news.show', $item->id) }}" class="btn btn-view">
                            View
                        </a>

                        <a href="{{ route('admin.news.edit', $item->id) }}" class="btn btn-edit">
                            Edit
                        </a>

                        <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="btn btn-danger"
                                    onclick="return confirm('Delete this news?')">
                                Delete
                            </button>
                        </form>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align:center; padding:15px;">
                        No news available.
                    </td>
                </tr>
            @endforelse
        </tbody>

    </table>

    <!-- PAGINATION -->
    <div style="margin-top:15px;">
        {{ $news->links() }}
    </div>

</div>

@endsection