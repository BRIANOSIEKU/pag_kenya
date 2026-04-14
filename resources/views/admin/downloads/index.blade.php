@extends('layouts.admin')

@section('content')

<style>
.container {
    max-width: 1200px;
    margin: auto;
}

.header {
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:15px;
    flex-wrap:wrap;
    gap:10px;
}

.left, .right {
    display:flex;
    gap:10px;
    align-items:center;
    flex-wrap:wrap;
}

.search-box {
    width:280px;
    padding:10px;
    border:1px solid #ccc;
    border-radius:8px;
    outline:none;
}

.card {
    background:#fff;
    padding:15px;
    border-radius:10px;
    box-shadow:0 3px 10px rgba(0,0,0,0.05);
}

.table {
    width:100%;
    border-collapse:collapse;
}

.table th {
    background:#1e3c72;
    color:white;
    padding:12px;
    text-align:left;
}

.table td {
    padding:12px;
    border-bottom:1px solid #eee;
}

.btn {
    padding:6px 10px;
    border-radius:6px;
    color:white;
    text-decoration:none;
    cursor:pointer;
    font-size:13px;
    border:none;
}

.btn-primary { background:#2196F3; }
.btn-view { background:#28a745; }
.btn-edit { background:#FF9800; }
.btn-danger { background:#e74c3c; }

.file-link {
    color:#2196F3;
    text-decoration:none;
    font-weight:bold;
}
</style>

<style>
    .btn-back {
    background: #607D8B;
    color: white;
    padding: 8px 12px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 13px;
    font-weight: bold;
}

.btn-back:hover {
    opacity: 0.85;
}
</style>

   <a href="{{ route('admin.districts.dashboard') }}" class="btn-back">
            ← Back to District Dashboard
        </a>

<div class="container">

    {{-- HEADER --}}
    <div class="header">

        {{-- LEFT --}}
        <div class="left">
            <h2 style="color:#1e3c72;">Downloads Management</h2>
        </div>

        {{-- RIGHT --}}
        <div class="right">

            {{-- SEARCH --}}
            <input type="text"
                   id="searchInput"
                   class="search-box"
                   placeholder="Search title, file name...">

            {{-- UPLOAD BUTTON --}}
            <a href="{{ route('admin.downloads.create') }}"
               class="btn btn-primary">
                + Upload File
            </a>

        </div>
    </div>

    {{-- ALERTS --}}
    @if(session('success'))
        <div style="background:#d4edda; padding:10px; color:#155724; margin-bottom:10px; border-radius:6px;">
            {{ session('success') }}
        </div>
    @endif

    {{-- TABLE CARD --}}
    <div class="card">

        <table class="table" id="downloadsTable">

            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>File</th>
                    <th>Type</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($downloads as $download)
                <tr class="download-row">

                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $download->title }}</td>

                    <td>
                        <a class="file-link"
                           href="{{ asset('storage/' . $download->file_path) }}"
                           target="_blank">
                            {{ $download->file_name }}
                        </a>
                    </td>

                    <td>{{ $download->file_type }}</td>

                    <td>{{ $download->created_at }}</td>

                    <td>

                        {{-- VIEW --}}
                        <a href="{{ route('admin.downloads.show', $download->id) }}"
                           class="btn btn-view">
                            View
                        </a>

                        {{-- EDIT --}}
                        <a href="{{ route('admin.downloads.edit', $download->id) }}"
                           class="btn btn-edit">
                            Edit
                        </a>

                        {{-- DELETE --}}
                        <form action="{{ route('admin.downloads.destroy', $download->id) }}"
                              method="POST"
                              style="display:inline;">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="btn btn-danger"
                                    onclick="return confirm('Delete this file?')">
                                Delete
                            </button>
                        </form>

                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center; padding:20px;">
                        No downloads available
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>

    </div>
</div>

{{-- LIVE SEARCH --}}
<script>
document.getElementById("searchInput").addEventListener("keyup", function () {

    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll(".download-row");

    rows.forEach(row => {
        let text = row.innerText.toLowerCase();
        row.style.display = text.includes(filter) ? "" : "none";
    });

});
</script>

@endsection