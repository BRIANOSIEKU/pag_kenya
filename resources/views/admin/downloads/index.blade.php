@extends('layouts.admin')

@section('content')

<style>
/* ===== PAGE WRAPPER ===== */
.page-wrapper {
    max-width: 1200px;
    margin: auto;
    padding: 15px;
}

/* ===== HEADER ===== */
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 15px;
}

/* ===== TITLE ===== */
.page-title {
    color: #1e3c72;
    margin: 0;
    font-size: 20px;
}

/* ===== SEARCH ===== */
.search-box {
    width: 280px;
    max-width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 8px;
    outline: none;
}

/* ===== BACK BUTTON ===== */
.btn-back {
    display: inline-block;
    background: #607D8B;
    color: white;
    padding: 10px 14px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 13px;
    font-weight: bold;
    margin-bottom: 15px;
}

.btn-back:hover { opacity: 0.85; }

/* ===== BUTTONS ===== */
.btn {
    padding: 10px 14px;
    border-radius: 6px;
    color: white;
    border: none;
    cursor: pointer;
    text-decoration: none;
    font-size: 13px;
    display: inline-block;
}

.btn-primary { background: #2196F3; }
.btn-view { background: #28a745; }
.btn-edit { background: #FF9800; }
.btn-danger { background: #e74c3c; }

.btn:hover { opacity: 0.85; }

/* ===== CARD ===== */
.card {
    background: #fff;
    padding: 15px;
    border-radius: 12px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.05);
}

/* ===== TABLE ===== */
.table-wrapper {
    width: 100%;
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    min-width: 800px;
}

th {
    background: #1e3c72;
    color: white;
    padding: 12px;
    text-align: left;
}

td {
    padding: 12px;
    border-bottom: 1px solid #eee;
    font-size: 14px;
}

/* ===== FILE LINK ===== */
.file-link {
    color: #2196F3;
    text-decoration: none;
    font-weight: bold;
}

/* ===== ALERT ===== */
.alert-success {
    background: #d4edda;
    color: #155724;
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 10px;
}

/* ===== RIGHT SECTION ===== */
.right {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    align-items: center;
}

/* ===== MOBILE ===== */
@media (max-width: 768px) {
    .header {
        flex-direction: column;
        align-items: stretch;
    }

    .search-box {
        width: 100%;
    }

    table {
        min-width: 600px;
    }

    .right {
        flex-direction: column;
        align-items: stretch;
    }
}
</style>

<div class="page-wrapper">

    {{-- BACK --}}
    <a href="{{ route('admin.districts.dashboard') }}" class="btn-back">
        ← Back to District Dashboard
    </a>

    {{-- HEADER --}}
    <div class="header">

        <h2 class="page-title">Downloads Management</h2>

        <div class="right">

            <input type="text"
                   id="searchInput"
                   class="search-box"
                   placeholder="Search title, file name...">

            <a href="{{ route('admin.downloads.create') }}"
               class="btn btn-primary">
                + Upload File
            </a>

        </div>

    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- TABLE --}}
    <div class="card">

        <div class="table-wrapper">

            <table id="downloadsTable">

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

                            <div style="display:flex; gap:8px; flex-wrap:wrap;">

                                <a href="{{ route('admin.downloads.show', $download->id) }}"
                                   class="btn btn-view">
                                    View
                                </a>

                                <a href="{{ route('admin.downloads.edit', $download->id) }}"
                                   class="btn btn-edit">
                                    Edit
                                </a>

                                <form action="{{ route('admin.downloads.destroy', $download->id) }}"
                                      method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-danger"
                                            onclick="return confirm('Delete this file?')">
                                        Delete
                                    </button>
                                </form>

                            </div>

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