@extends('layouts.admin')

@section('content')

<style>
    .page-wrapper {
        padding: 20px;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 20px;
    }

    .page-header-left {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .back-btn {
        padding: 8px 12px;
        background: #607D8B;
        color: white;
        border-radius: 6px;
        text-decoration: none;
        font-size: 14px;
        display: inline-block;
    }

    .page-title {
        font-size: 22px;
        font-weight: 600;
        margin: 0;
    }

    .btn-primary {
        padding: 8px 14px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 500;
        background: #0d6efd;
        color: white;
        border: none;
    }

    .alert {
        padding: 10px 15px;
        border-radius: 6px;
        margin-bottom: 15px;
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
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
        background: #f8f9fa;
        text-align: left;
        padding: 12px;
        font-size: 14px;
    }

    table td {
        padding: 12px;
        font-size: 14px;
        border-top: 1px solid #eee;
        vertical-align: middle;
    }

    .actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .btn-sm {
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 12px;
        text-decoration: none;
        border: none;
        cursor: pointer;
    }

    .btn-warning {
        background: #f0ad4e;
        color: white;
    }

    .btn-danger {
        background: #dc3545;
        color: white;
    }

    .btn-view {
        background: #198754;
        color: white;
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

    {{-- HEADER WITH BACK BUTTON --}}
    <div class="page-header">

        <div class="page-header-left">

            <a href="{{ route('admin.departments.index') }}" class="back-btn">
                ← Back
            </a>

            <h2 class="page-title">
                Department Upcoming Events
            </h2>

        </div>

        <a href="{{ route('admin.departments.department_upcoming_events.create', $department->id) }}"
           class="btn-primary">
            + Add Event
        </a>

    </div>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- TABLE --}}
    <div class="table-container">

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Description</th>
                    <th>File</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                @forelse($events as $key => $event)
                    <tr>

                        <td data-label="#"> {{ $events->firstItem() + $key }} </td>

                        <td data-label="Title">{{ $event->title }}</td>

                        <td data-label="Date">{{ $event->formatted_date }}</td>

                        <td data-label="Description">
                            {{ Str::limit($event->description, 60) }}
                        </td>

                        <td data-label="File">
                            @if($event->file)
                                <a href="{{ asset('storage/' . $event->file) }}"
                                   target="_blank"
                                   class="btn-sm btn-view">
                                    View File
                                </a>
                            @else
                                <span>No File</span>
                            @endif
                        </td>

                        <td data-label="Actions">
                            <div class="actions">

                                <a href="{{ route('admin.departments.department_upcoming_events.edit', [$department->id, $event->id]) }}"
                                   class="btn-sm btn-warning">
                                    Edit
                                </a>

                                <form action="{{ route('admin.departments.department_upcoming_events.destroy', [$department->id, $event->id]) }}"
                                      method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this event?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn-sm btn-danger">
                                        Delete
                                    </button>

                                </form>

                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center;">
                            No upcoming events found
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>

    </div>

    {{-- PAGINATION --}}
    <div style="margin-top:15px;">
        {{ $events->links() }}
    </div>

</div>

@endsection