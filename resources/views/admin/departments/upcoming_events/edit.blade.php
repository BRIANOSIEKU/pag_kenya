@extends('layouts.admin')

@section('content')

<style>
    .page-wrapper {
        padding: 20px;
    }

    .page-header {
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

    .file-preview {
        margin-top: 10px;
        font-size: 14px;
    }

    .file-preview a {
        color: #0d6efd;
        text-decoration: none;
        font-weight: 500;
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

    .btn-primary {
        background: #0d6efd;
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

    /* MOBILE VIEW */
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
        <h2 class="page-title">Edit Upcoming Event</h2>
    </div>

    {{-- FORM CARD --}}
    <div class="card">

        <form action="{{ route('admin.departments.department_upcoming_events.update', [$department->id, $event->id]) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            {{-- TITLE --}}
            <div class="form-group">
                <label>Title</label>
                <input type="text"
                       name="title"
                       value="{{ $event->title }}"
                       required>
            </div>

            {{-- DATE --}}
            <div class="form-group">
                <label>Event Date</label>
                <input type="date"
                       name="event_date"
                       value="{{ $event->event_date }}"
                       required>
            </div>

            {{-- DESCRIPTION --}}
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="5">{{ $event->description }}</textarea>
            </div>

            {{-- FILE --}}
            <div class="form-group">
                <label>Replace File</label>
                <input type="file" name="file">
            </div>

            {{-- CURRENT FILE --}}
            @if($event->file)
                <div class="file-preview">
                    📎 Current File:
                    <a href="{{ asset('storage/' . $event->file) }}" target="_blank">
                        View File
                    </a>
                </div>
            @endif

            {{-- BUTTONS --}}
            <div class="btn-group">

                <button type="submit" class="btn btn-primary">
                    Update Event
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