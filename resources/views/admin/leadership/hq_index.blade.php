@extends('layouts.admin')

@section('content')

<style>
.container {
    max-width: 1200px;
    margin: auto;
    padding: 20px;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 20px;
}

.btn {
    padding: 8px 14px;
    border-radius: 6px;
    font-weight: bold;
    text-decoration: none;
    color: #fff;
    font-size: 14px;
    border: none;
    cursor: pointer;
    transition: 0.3s;
}

.btn:hover {
    opacity: 0.85;
}

.btn-back {
    background: #607D8B;
}

.btn-add {
    background: #FF9800;
}

.card {
    background: #fff;
    padding: 15px;
    border-radius: 10px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.05);
    overflow-x: auto;
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table th {
    background: #1e3c72;
    color: #fff;
    padding: 12px;
    text-align: left;
}

.table td {
    padding: 12px;
    border-bottom: 1px solid #eee;
    vertical-align: middle;
}

.small-btn {
    padding: 5px 10px;
    font-size: 12px;
    border-radius: 4px;
    color: #fff;
    border: none;
    cursor: pointer;
    text-decoration: none;
}

.btn-edit { background: #FFC107; }
.btn-delete { background: #F44336; }
</style>

<div class="container">

    {{-- HEADER --}}
    <div class="header">

        <a href="{{ route('admin.dashboard') }}" class="btn btn-back">
            ← Back to Dashboard
        </a>

        <a href="{{ route('admin.leadership.create', 'hq') }}" class="btn btn-add">
            + Add HQ Staff
        </a>

    </div>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div style="background:#4CAF50; color:#fff; padding:10px; border-radius:6px; margin-bottom:15px;">
            {{ session('success') }}
        </div>
    @endif

    {{-- TABLE --}}
    <div class="card">

        <table class="table">

            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Full Name</th>
                    <th>Position</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                @forelse($leaders as $leader)

                <tr>

                    {{-- PHOTO --}}
                    <td>
                        @if($leader->photo)
                            <img src="{{ asset($leader->photo) }}"
                                 style="height:60px;width:60px;border-radius:6px;object-fit:cover;">
                        @else
                            <span style="color:#888;">No Photo</span>
                        @endif
                    </td>

                    {{-- NAME --}}
                    <td>{{ $leader->full_name }}</td>

                    {{-- POSITION --}}
                    <td>{{ $leader->position }}</td>

                    {{-- CONTACT --}}
                    <td>{{ $leader->contact }}</td>

                    {{-- EMAIL --}}
                    <td>{{ $leader->email }}</td>

                    {{-- ACTIONS --}}
                    <td style="display:flex; gap:6px;">

                        <a href="{{ route('admin.leadership.edit', ['hq', $leader->id]) }}"
                           class="small-btn btn-edit">
                            Edit
                        </a>

                        <form action="{{ route('admin.leadership.destroy', ['hq', $leader->id]) }}"
                              method="POST"
                              onsubmit="return confirm('Delete this HQ staff member?')">

                            @csrf
                            @method('DELETE')

                            <button class="small-btn btn-delete">
                                Delete
                            </button>

                        </form>

                    </td>

                </tr>

                @empty
                    <tr>
                        <td colspan="6" style="text-align:center; padding:15px;">
                            No HQ Staff found.
                        </td>
                    </tr>
                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection