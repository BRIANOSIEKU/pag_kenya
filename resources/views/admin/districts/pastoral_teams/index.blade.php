@extends('layouts.admin')

@section('content')

<h2 class="page-title">Pastoral Team - {{ $district->name }}</h2>

<style>
/* ===== PAGE TITLE ===== */
.page-title {
    font-size: 22px;
    margin-bottom: 15px;
}

/* ===== TOP ACTION BAR ===== */
.top-actions {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 15px;
}

.btn {
    display: inline-block;
    padding: 8px 12px;
    border-radius: 6px;
    text-decoration: none;
    color: #fff;
    font-size: 13px;
}

.btn-back { background: #555; }
.btn-export { background: #4CAF50; }

.btn:hover { opacity: 0.85; }

/* ===== SEARCH ===== */
.search-form {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
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
    background: #2196F3;
    color: #fff;
    border: none;
    border-radius: 6px;
}

/* ===== TABLE WRAPPER ===== */
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
    min-width: 800px;
}

th, td {
    padding: 12px;
    border: 1px solid #eee;
    font-size: 14px;
    text-align: left;
    vertical-align: middle;
}

th {
    background: #f5f5f5;
}

/* ===== IMAGE ===== */
.pastor-img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
}

/* ===== ACTION BUTTONS ===== */
.action-btn {
    display: inline-block;
    padding: 6px 10px;
    border-radius: 5px;
    font-size: 12px;
    text-decoration: none;
    margin-right: 5px;
    color: #fff;
}

.view { background: #03A9F4; }
.edit { background: #FFC107; color: #000; }
.delete {
    background: #F44336;
    border: none;
    color: #fff;
    padding: 6px 10px;
    border-radius: 5px;
    cursor: pointer;
}

/* ===== EMPTY STATE ===== */
.empty {
    text-align: center;
    padding: 15px;
    color: #666;
}

/* ===== MOBILE ===== */
@media (max-width: 768px) {
    .page-title {
        font-size: 18px;
    }

    th, td {
        font-size: 13px;
        padding: 10px;
    }

    .action-btn, .delete {
        font-size: 11px;
        padding: 5px 8px;
    }
}
</style>

<!-- TOP ACTIONS -->
<div class="top-actions">

    <a href="{{ route('admin.districts.index') }}" class="btn btn-back">
        ← Back to Districts
    </a>

    <a href="{{ route('admin.districts.pastoral-teams.export', $district->id) }}" class="btn btn-export">
        📄 Export PDF
    </a>

</div>

<!-- SEARCH -->
<form method="GET" class="search-form">
    <input type="text" name="search"
           value="{{ request('search') }}"
           placeholder="Search pastors...">

    <button type="submit">Search</button>
</form>

<!-- TABLE -->
<div class="table-wrapper">

<table>
    <thead>
        <tr>
            <th>Photo</th>
            <th>Name</th>
            <th>Gender</th>
            <th>Contact</th>
            <th>Assembly</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @forelse($pastors as $pastor)
        <tr>

            <td>
                <img src="{{ $pastor->photo_url }}" class="pastor-img">
            </td>

            <td>
                <a href="{{ route('admin.pastoral-teams.show', $pastor->id) }}"
                   style="color:#2196F3;text-decoration:none;">
                    {{ $pastor->name }}
                </a>
            </td>

            <td>{{ $pastor->gender }}</td>
            <td>{{ $pastor->contact }}</td>
            <td>{{ $pastor->assembly->name ?? 'N/A' }}</td>

            <td>
                <a href="{{ route('admin.pastoral-teams.show', $pastor->id) }}" class="action-btn view">
                    View
                </a>

                <a href="{{ route('admin.pastoral-teams.edit', $pastor->id) }}" class="action-btn edit">
                    Edit
                </a>

                <form action="{{ route('admin.pastoral-teams.destroy', $pastor->id) }}"
                      method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            onclick="return confirm('Delete pastor?')"
                            class="delete">
                        Delete
                    </button>
                </form>
            </td>

        </tr>
        @empty
        <tr>
            <td colspan="6" class="empty">
                No pastors found in this district.
            </td>
        </tr>
        @endforelse
    </tbody>

</table>

</div>

<!-- PAGINATION -->
<div style="margin-top:15px;">
    {{ $pastors->links() }}
</div>

@endsection