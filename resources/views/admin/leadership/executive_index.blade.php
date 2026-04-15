@extends('layouts.admin')

@section('content')

<style>
/* ===== PAGE WRAPPER ===== */
.page-wrapper {
    max-width: 1200px;
    margin: auto;
    padding: 15px;
}

/* ===== BACK BUTTON ===== */
.btn-back {
    display: inline-block;
    background: #2196F3;
    color: #fff;
    padding: 10px 14px;
    border-radius: 6px;
    text-decoration: none;
    margin-bottom: 15px;
    font-size: 13px;
    font-weight: bold;
}

.btn-back:hover { opacity: 0.85; }

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
.title {
    font-size: 22px;
    color: #1e3c72;
    margin: 0;
}

/* ===== ADD BUTTON ===== */
.btn-add {
    background: #4CAF50;
    color: #fff;
    padding: 10px 14px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 13px;
}

/* ===== SUCCESS ALERT ===== */
.alert-success {
    background: #d4edda;
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 10px;
    color: #155724;
}

/* ===== TABLE WRAPPER ===== */
.table-wrapper {
    width: 100%;
    overflow-x: auto;
}

/* ===== TABLE ===== */
table {
    width: 100%;
    border-collapse: collapse;
    min-width: 800px;
    background: #fff;
}

th {
    background: #f1f1f1;
    padding: 10px;
    text-align: left;
    font-size: 14px;
}

td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    font-size: 14px;
}

/* ===== PHOTO ===== */
.photo {
    width: 50px;
    height: 50px;
    border-radius: 6px;
    object-fit: cover;
}

/* ===== BUTTONS ===== */
.btn {
    padding: 6px 10px;
    border-radius: 4px;
    color: #fff;
    text-decoration: none;
    font-size: 13px;
    border: none;
    cursor: pointer;
}

.btn-edit { background: #2196F3; }
.btn-delete { background: #f44336; }

.btn:hover { opacity: 0.85; }

/* ===== ACTIONS ===== */
.actions {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
}

/* ===== EMPTY STATE ===== */
.empty {
    text-align: center;
    padding: 20px;
    color: #777;
}

/* ===== MOBILE ===== */
@media (max-width: 768px) {
    table {
        min-width: 600px;
    }

    .title {
        font-size: 18px;
    }
}
</style>

<div class="page-wrapper">

    {{-- BACK --}}
    <a href="{{ route('admin.dashboard') }}" class="btn-back">
        ← Back to Dashboard
    </a>

    @php
        $typeLabel = [
            'executive' => 'Executive Committee',
            'council' => 'Church Council',
            'hq' => 'PAG Kenya HQ Staff'
        ][$type] ?? ucfirst($type);
    @endphp

    {{-- HEADER --}}
    <div class="header">

        <h2 class="title">{{ $typeLabel }}</h2>

        <a href="{{ route('admin.leadership.create', $type) }}" class="btn-add">
            + Add Leader
        </a>

    </div>

    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- TABLE --}}
    <div class="table-wrapper">

        <table>

            <thead>
                <tr>
                    <th>#</th>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                @forelse($leaders as $i => $leader)
                <tr>

                    <td>{{ $i + 1 }}</td>

                    <td>
                        @if($leader->photo)
                            <img src="{{ asset($leader->photo) }}" class="photo">
                        @else
                            <img src="https://via.placeholder.com/50" class="photo">
                        @endif
                    </td>

                    <td>{{ $leader->full_name }}</td>

                    <td>{{ $leader->position }}</td>

                    <td>{{ $leader->contact }}</td>

                    <td>{{ $leader->email }}</td>

                    <td>
                        <div class="actions">

                            <a href="{{ route('admin.leadership.edit', [$type, $leader->id]) }}"
                               class="btn btn-edit">
                                Edit
                            </a>

                            <form action="{{ route('admin.leadership.destroy', [$type, $leader->id]) }}"
                                  method="POST">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-delete"
                                        onclick="return confirm('Delete this leader?')">
                                    Delete
                                </button>
                            </form>

                        </div>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="7" class="empty">
                        No leaders found.
                    </td>
                </tr>
                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection