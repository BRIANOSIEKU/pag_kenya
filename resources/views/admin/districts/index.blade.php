@extends('layouts.admin')

@section('content')

<h1 class="page-title">Districts</h1>

<style>
/* ===== PAGE WRAPPER ===== */
.page-title {
    font-size: 22px;
    margin-bottom: 15px;
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
    margin-bottom: 10px;
}

.btn-back:hover { opacity: 0.85; }

/* ===== ACTION BUTTONS ===== */
.btn {
    display: inline-block;
    padding: 8px 12px;
    border-radius: 6px;
    text-decoration: none;
    color: #fff;
    font-size: 13px;
    margin: 4px 4px 4px 0;
    white-space: nowrap;
}

.btn-black { background: #000; }
.btn-blue { background: #1976D2; }
.btn-green { background: #4CAF50; }
.btn-cyan { background: #03A9F4; }
.btn-purple { background: #9C27B0; }
.btn-yellow { background: #FFC107; color: #000; }
.btn-red { background: #F44336; }
.btn-grey { background: #607D8B; }

.btn:hover { opacity: 0.85; }

/* ===== SEARCH ===== */
.search-form {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 15px;
}

.search-form input {
    flex: 1;
    min-width: 180px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
}

.search-form button {
    padding: 10px 14px;
    border: none;
    border-radius: 6px;
    background: #2196F3;
    color: #fff;
}

/* ===== TABLE WRAPPER (MOBILE FIX) ===== */
.table-wrapper {
    width: 100%;
    overflow-x: auto;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
}

/* ===== TABLE ===== */
table {
    width: 100%;
    border-collapse: collapse;
    min-width: 600px;
}

th, td {
    padding: 12px;
    border: 1px solid #eee;
    text-align: left;
    font-size: 14px;
}

th {
    background: #f5f5f5;
}

/* ===== SUCCESS MESSAGE ===== */
.alert-success {
    margin: 10px 0;
    padding: 10px;
    background: #d4edda;
    color: #155724;
    border-radius: 6px;
}

/* ===== MOBILE OPTIMIZATION ===== */
@media (max-width: 768px) {
    .page-title {
        font-size: 18px;
    }

    th, td {
        font-size: 13px;
        padding: 10px;
    }

    .btn {
        font-size: 12px;
        padding: 6px 10px;
    }
}
</style>

<!-- BACK -->
<a href="{{ route('admin.districts.dashboard') }}" class="btn-back">
    ← Back to District Module Dashboard
</a>

<!-- ACTION BUTTONS -->
<div style="margin-bottom:10px;">
    <a href="{{ route('admin.districts.export.form') }}" class="btn btn-black">
        Export District Leadership
    </a>

    <a href="{{ route('admin.pastors.export') }}" class="btn btn-blue">
        Export All Pastors
    </a>

    <a href="{{ route('admin.districts.create') }}" class="btn btn-green">
        + Add District
    </a>
</div>

<!-- SUCCESS -->
@if(session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif

<!-- SEARCH -->
<form action="{{ route('admin.districts.index') }}" method="GET" class="search-form">
    <input type="text" name="search" placeholder="Search districts..."
           value="{{ request('search') }}">
    <button type="submit">Search</button>
</form>

<!-- TABLE -->
<div class="table-wrapper">
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>District Name</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach($districts as $index => $district)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $district->name }}</td>
            <td>

                <a href="{{ route('admin.districts.pastoral-teams.index', $district->id) }}" class="btn btn-cyan">
                    Pastoral Team
                </a>

                <a href="{{ route('admin.districts.pastoral-teams.export', $district->id) }}" class="btn btn-grey">
                    Export Pastors
                </a>

                <a href="{{ route('admin.districts.leadership.index', $district->id) }}" class="btn btn-purple">
                    Leadership
                </a>

                <a href="{{ route('admin.districts.edit', $district->id) }}" class="btn btn-yellow">
                    Edit
                </a>

                <form action="{{ route('admin.districts.destroy', $district->id) }}"
                      method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')

                    <button type="submit"
                        onclick="return confirm('Delete this district?');"
                        class="btn btn-red">
                        Delete
                    </button>
                </form>

            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>

<!-- PAGINATION -->
@if(method_exists($districts, 'links'))
    <div style="margin-top:15px;">
        {{ $districts->links() }}
    </div>
@endif

@endsection