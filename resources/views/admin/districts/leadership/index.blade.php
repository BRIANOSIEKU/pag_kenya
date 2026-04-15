@extends('layouts.admin')

@section('content')

<style>
/* ===== PAGE TITLE ===== */
.page-title {
    font-size: 22px;
    margin-bottom: 15px;
}

/* ===== ACTION BAR ===== */
.top-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 15px;
}

/* ===== BUTTONS ===== */
.btn {
    display: inline-block;
    padding: 10px 14px;
    border-radius: 6px;
    text-decoration: none;
    color: #fff;
    font-size: 13px;
}

.btn-green { background: #4CAF50; }
.btn:hover { opacity: 0.85; }

/* ===== SUCCESS MESSAGE ===== */
.alert-success {
    margin: 10px 0;
    padding: 10px;
    background: #d4edda;
    color: #155724;
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
.leader-img {
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

.delete-btn {
    background: #F44336;
    border: none;
    color: #fff;
    padding: 6px 10px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 12px;
}

/* ===== POSITION BADGE ===== */
.position {
    font-weight: 600;
    color: #003366;
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

    .action-btn, .delete-btn {
        font-size: 11px;
        padding: 5px 8px;
    }
}
</style>

<h1 class="page-title">District Leadership - {{ $district->name }}</h1>

<!-- TOP BAR -->
<div class="top-bar">

    <a href="{{ route('admin.districts.leadership.create', $district->id) }}"
       class="btn btn-green">
        + Add Leader
    </a>

</div>

<!-- SUCCESS -->
@if(session('success'))
<div class="alert-success">
    {{ session('success') }}
</div>
@endif

<!-- TABLE -->
<div class="table-wrapper">

<table>

    <thead>
        <tr>
            <th>Photo</th>
            <th>Name</th>
            <th>Position</th>
            <th>Contact</th>
            <th>Gender</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @forelse($leaders as $leader)
        <tr>

            <td>
                @if($leader->photo)
                    <img src="{{ asset('storage/'.$leader->photo) }}" class="leader-img">
                @else
                    N/A
                @endif
            </td>

            <td>{{ $leader->name }}</td>

            <td class="position">
                {{ $leader->position ?? 'N/A' }}
            </td>

            <td>{{ $leader->contact }}</td>
            <td>{{ $leader->gender }}</td>

            <td>

                <a href="{{ route('admin.districts.leadership.show', [$district->id, $leader->id]) }}"
                   class="action-btn view">
                    View
                </a>

                <a href="{{ route('admin.districts.leadership.edit', [$district->id, $leader->id]) }}"
                   class="action-btn edit">
                    Edit
                </a>

                <form action="{{ route('admin.districts.leadership.destroy', [$district->id, $leader->id]) }}"
                      method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            onclick="return confirm('Delete leader?')"
                            class="delete-btn">
                        Delete
                    </button>
                </form>

            </td>

        </tr>
        @empty
        <tr>
            <td colspan="6" class="empty">
                No leaders found in this district.
            </td>
        </tr>
        @endforelse
    </tbody>

</table>

</div>

@endsection