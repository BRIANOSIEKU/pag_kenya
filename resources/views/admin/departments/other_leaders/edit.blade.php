@extends('layouts.admin')

@section('content')

<style>
    .page-wrapper {
        padding: 20px;
    }

    .top-bar {
        margin-bottom: 15px;
    }

    .btn {
        padding: 9px 14px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 14px;
        border: none;
        cursor: pointer;
        color: white;
    }

    .btn-back {
        background: #607D8B;
    }

    .card {
        max-width: 800px;
        margin: auto;
        background: #fff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
    }

    h2 {
        font-size: 20px;
        margin-bottom: 15px;
        font-weight: 600;
    }

    .form-group {
        margin-bottom: 15px;
    }

    label {
        display: block;
        font-weight: 600;
        margin-bottom: 6px;
        font-size: 14px;
    }

    input, select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 14px;
        outline: none;
    }

    input:focus, select:focus {
        border-color: #0d6efd;
    }

    .preview-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        margin-top: 8px;
        border: 1px solid #eee;
    }

    .btn-submit {
        background: #0d6efd;
        width: 100%;
        margin-top: 10px;
    }

    /* MOBILE */
    @media (max-width: 768px) {
        .card {
            padding: 15px;
        }

        .btn-submit {
            width: 100%;
        }
    }
</style>

<div class="page-wrapper">

    {{-- TOP --}}
    <div class="top-bar">
        <a href="{{ route('admin.departments.other-leaders.index', $leader->department_id) }}"
           class="btn btn-back">
            ← Back
        </a>
    </div>

    {{-- FORM CARD --}}
    <div class="card">

        <h2>Edit Leader</h2>

        <form action="{{ route('admin.departments.other-leaders.update', [$leader->department_id, $leader->id]) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            {{-- DEPARTMENT --}}
            <div class="form-group">
                <label>Department</label>
                <select name="department_id" required>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}"
                            {{ $leader->department_id == $dept->id ? 'selected' : '' }}>
                            {{ $dept->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- NAME --}}
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" value="{{ $leader->name }}" required>
            </div>

            {{-- POSITION --}}
            <div class="form-group">
                <label>Position</label>
                <input type="text" name="position" value="{{ $leader->position }}">
            </div>

            {{-- PHONE --}}
            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone" value="{{ $leader->phone }}">
            </div>

            {{-- EMAIL --}}
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ $leader->email }}">
            </div>

            {{-- PHOTO --}}
            <div class="form-group">
                <label>Photo</label>
                <input type="file" name="photo">

                @if($leader->photo)
                    <img src="{{ asset('storage/' . $leader->photo) }}"
                         class="preview-img">
                @endif
            </div>

            {{-- SUBMIT --}}
            <button type="submit" class="btn btn-submit">
                Update Leader
            </button>

        </form>

    </div>

</div>

@endsection