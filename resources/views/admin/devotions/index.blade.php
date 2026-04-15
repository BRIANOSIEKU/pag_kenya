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

.btn-primary { background: #2196F3; }
.btn-success { background: #4CAF50; }
.btn-view { background: #03A9F4; }
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

.thumbnail {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 4px;
}

.alert-success {
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

        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
            ← Back to Dashboard
        </a>

        <h2>Devotions</h2>

        <a href="{{ route('admin.devotions.create') }}" class="btn btn-success">
            + Add Devotion
        </a>

    </div>

    <!-- SUCCESS -->
    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- TABLE -->
    <table class="table">

        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Author</th>
                <th>Date</th>
                <th>Thumbnail</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse($devotions as $devotion)
                <tr>
                    <td>{{ $devotion->id }}</td>
                    <td>{{ $devotion->title }}</td>
                    <td>{{ $devotion->author }}</td>
                    <td>{{ \Carbon\Carbon::parse($devotion->date)->format('d M Y') }}</td>

                    <td>
                        @if($devotion->thumbnail)
                            <img src="{{ asset($devotion->thumbnail) }}" class="thumbnail">
                        @else
                            N/A
                        @endif
                    </td>

                    <td style="display:flex; gap:6px; flex-wrap:wrap;">

                        <a href="{{ route('admin.devotions.show', $devotion->id) }}" class="btn btn-view">
                            View
                        </a>

                        <a href="{{ route('admin.devotions.edit', $devotion->id) }}" class="btn btn-edit">
                            Edit
                        </a>

                        <form action="{{ route('admin.devotions.destroy', $devotion->id) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="btn btn-danger"
                                    onclick="return confirm('Delete this devotion?')">
                                Delete
                            </button>
                        </form>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center; padding:15px;">
                        No devotions available.
                    </td>
                </tr>
            @endforelse
        </tbody>

    </table>

    <!-- PAGINATION -->
    <div style="margin-top:15px;">
        {{ $devotions->links() }}
    </div>

</div>

@endsection