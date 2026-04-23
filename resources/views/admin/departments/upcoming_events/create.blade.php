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

    .page-title {
        font-size: 22px;
        font-weight: 600;
        margin: 0;
    }

    .card {
        background: #fff;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .form-group {
        margin-bottom: 15px;
    }

    label {
        font-weight: 600;
        font-size: 14px;
        display: block;
        margin-bottom: 6px;
    }

    input, textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
        outline: none;
    }

    input:focus, textarea:focus {
        border-color: #0d6efd;
    }

    .btn {
        padding: 10px 14px;
        border-radius: 6px;
        font-size: 14px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
    }

    .btn-success {
        background: #198754;
        color: white;
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-group {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 10px;
    }

    /* MOBILE */
    @media (max-width: 768px) {
        .card {
            padding: 15px;
        }

        .btn {
            width: 100%;
            text-align: center;
        }

        .btn-group {
            flex-direction: column;
        }
    }
</style>

<div class="page-wrapper">

    {{-- HEADER --}}
    <div class="page-header">
        <h2 class="page-title">Add Upcoming Event</h2>
    </div>

    {{-- FORM CARD --}}
    <div class="card">

        <form action="{{ route('admin.departments.department_upcoming_events.store', $department->id) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            {{-- TITLE --}}
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" placeholder="Enter event title" required>
            </div>

            {{-- DATE --}}
            <div class="form-group">
                <label>Event Date</label>
                <input type="date" name="event_date" required>
            </div>

            {{-- DESCRIPTION --}}
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="5" placeholder="Write event details..."></textarea>
            </div>

            {{-- FILE --}}
            <div class="form-group">
                <label>File (Image / PDF / DOC)</label>
                <input type="file" name="file">
            </div>

            {{-- BUTTONS --}}
            <div class="btn-group">

                <button type="submit" class="btn btn-success">
                    Save Event
                </button>

                <a href="{{ route('admin.departments.department_upcoming_events.index', $department->id) }}"
                   class="btn btn-secondary">
                    Back
                </a>

            </div>

        </form>

    </div>

</div>

@endsection