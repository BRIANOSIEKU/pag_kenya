@extends('layouts.district_admin')

@section('content')

<style>
.container {
    max-width: 1100px;
    margin: auto;
}

.header {
    margin-bottom: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* BACK BUTTON */
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

.file-link {
    color:#2196F3;
    text-decoration:none;
    font-weight:bold;
}

.btn {
    padding:6px 10px;
    border-radius:6px;
    text-decoration:none;
    color:white;
    font-size:13px;
}

.btn-view {
    background:#4CAF50;
}
</style>

<div class="container">

    <div class="header">

        <!-- BACK BUTTON -->
        <a href="{{ route('district.admin.dashboard') }}" class="btn-back">
            ← Back to Dashboard
        </a>

        <h2 style="color:#1e3c72;">District Downloads</h2>

        <div></div>
    </div>

    <div class="card">

        <table class="table">

            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>File</th>
                    <th>Type</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($downloads as $download)
                    <tr>

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
                            <a href="{{ asset('storage/' . $download->file_path) }}"
                               class="btn btn-view"
                               target="_blank">
                                Click to View & Download
                            </a>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center;">
                            No downloads available
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>

    </div>

</div>

@endsection