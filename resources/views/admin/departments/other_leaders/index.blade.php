@extends('layouts.admin')

@section('content')

<style>
    .page-wrapper {
        padding: 20px;
    }

    .top-actions {
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
        text-decoration: none;
        font-size: 14px;
        display: inline-block;
        color: white;
        border: none;
        cursor: pointer;
    }

    .btn-back { background: #607D8B; }
    .btn-add { background: #198754; }
    .btn-view { background: #0d6efd; }
    .btn-edit { background: #f0ad4e; }
    .btn-delete { background: #dc3545; }

    .alert {
        padding: 10px;
        border-radius: 6px;
        margin-bottom: 15px;
        background: #198754;
        color: white;
    }

    .table-container {
        background: #fff;
        border-radius: 10px;
        padding: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 800px;
    }

    table th {
        background: #1e3c72;
        color: white;
        padding: 12px;
        text-align: left;
        font-size: 14px;
    }

    table td {
        padding: 12px;
        border-top: 1px solid #eee;
        font-size: 14px;
        vertical-align: middle;
    }

    .actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .photo {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 6px;
    }

    /* MOBILE VIEW */
    @media (max-width: 768px) {

        table thead {
            display: none;
        }

        table, tbody, tr, td {
            display: block;
            width: 100%;
        }

        tr {
            margin-bottom: 15px;
            border: 1px solid #eee;
            border-radius: 10px;
            padding: 10px;
            background: #fff;
        }

        td {
            display: flex;
            justify-content: space-between;
            padding: 8px 5px;
            border-bottom: 1px solid #f1f1f1;
        }

        td:last-child {
            border-bottom: none;
        }

        td::before {
            content: attr(data-label);
            font-weight: 600;
        }

        .actions {
            justify-content: flex-end;
        }
    }
</style>

<div class="page-wrapper">

    {{-- TOP ACTIONS --}}
    <div class="top-actions">

        <a href="{{ route('admin.departments.index') }}" class="btn btn-back">
            ← Back to Departments
        </a>

        <a href="{{ route('admin.departments.other-leaders.create', $department->id) }}"
           class="btn btn-add">
            + Add Leader
        </a>

    </div>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="alert">
            {{ session('success') }}
        </div>
    @endif

    {{-- TABLE --}}
    <div class="table-container">

        <table>

            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Position</th>
                    <th>Photo</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                @forelse($leaders as $key => $leader)

                    <tr>

                        <td data-label="#"> {{ $leaders->firstItem() + $key }} </td>

                        <td data-label="Name">{{ $leader->name }}</td>

                        <td data-label="Department">{{ $leader->department->name ?? '-' }}</td>

                        <td data-label="Position">{{ $leader->position }}</td>

                        <td data-label="Photo">
                            @if($leader->photo)
                                <img src="{{ asset('storage/' . $leader->photo) }}"
                                     class="photo">
                            @else
                                -
                            @endif
                        </td>

                        <td data-label="Actions">

                            <div class="actions">

                                <a href="{{ route('admin.departments.other-leaders.show', [$department->id, $leader->id]) }}"
                                   class="btn btn-view">
                                    View
                                </a>

                                <a href="{{ route('admin.departments.other-leaders.edit', [$department->id, $leader->id]) }}"
                                   class="btn btn-edit">
                                    Edit
                                </a>

                                <form action="{{ route('admin.departments.other-leaders.destroy', [$department->id, $leader->id]) }}"
                                      method="POST"
                                      onsubmit="return confirm('Delete this leader?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-delete">
                                        Delete
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6" style="text-align:center;">
                            No leaders found.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    {{-- PAGINATION --}}
    <div style="margin-top:15px;">
        {{ $leaders->links() }}
    </div>

</div>

@endsection