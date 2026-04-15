@extends('layouts.admin')

@section('content')

<style>
    .btn-back {
        background: #607D8B;
        color: white;
        padding: 8px 12px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 13px;
        font-weight: bold;
        display: inline-block;
        margin-bottom: 15px;
    }

    .btn-back:hover {
        opacity: 0.85;
    }

    .container {
        max-width: 1100px;
        margin: auto;
    }

    .card {
        background: #fff;
        padding: 15px;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.08);
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        background: #1e3c72;
        color: #fff;
        padding: 12px;
        text-align: left;
        font-size: 14px;
    }

    td {
        padding: 10px;
        border-bottom: 1px solid #eee;
        font-size: 14px;
    }

    .btn {
        padding: 6px 10px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 13px;
        color: #fff;
        display: inline-block;
    }

    .btn-edit {
        background: #FFC107;
    }

    .btn-delete {
        background: #F44336;
        border: none;
        cursor: pointer;
    }

    .actions {
        display: flex;
        gap: 6px;
        justify-content: center;
        align-items: center;
    }

    img.avatar {
        height: 60px;
        border-radius: 6px;
        object-fit: cover;
    }

</style>

<div class="container">

    <!-- BACK -->
    <a href="{{ route('admin.dashboard') }}" class="btn-back">
        ← Back to Dashboard
    </a>

    <h2 style="margin-bottom:15px;">Church Council Members</h2>

    <!-- SUCCESS -->
    @if(session('success'))
        <div style="background:#d4edda;color:#155724;padding:10px;border-radius:6px;margin-bottom:15px;">
            {{ session('success') }}
        </div>
    @endif

    <!-- ADD BUTTON -->
    <a href="{{ route('admin.leadership.create', 'council') }}"
       style="background:#2196F3;color:#fff;padding:10px 15px;border-radius:6px;text-decoration:none;display:inline-block;margin-bottom:15px;">
        + Add New Member
    </a>

    <div class="card">

        <table>

            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Full Name</th>
                    <th>Position</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th style="width:160px;">Actions</th>
                </tr>
            </thead>

            <tbody>

                @forelse($leaders as $leader)

                    <tr>

                        <td>
                            @if($leader->photo)
                                <img src="{{ asset($leader->photo) }}"
                                     class="avatar"
                                     alt="{{ $leader->full_name }}">
                            @endif
                        </td>

                        <td>{{ $leader->full_name }}</td>

                        <td>{{ $leader->position }}</td>

                        <td>{{ $leader->contact }}</td>

                        <td>{{ $leader->email }}</td>

                        <td class="actions">

                            <a href="{{ route('admin.leadership.edit', ['council', $leader->id]) }}"
                               class="btn btn-edit">
                                Edit
                            </a>

                            <form action="{{ route('admin.leadership.destroy', ['council', $leader->id]) }}"
                                  method="POST">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn btn-delete"
                                        onclick="return confirm('Are you sure you want to delete this member?')">
                                    Delete
                                </button>
                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6" style="text-align:center;padding:15px;">
                            No Church Council members found.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection