@extends('layouts.district_admin')

@section('content')

<style>
/* ===== GLOBAL SAFETY FIX ===== */
* {
    box-sizing: border-box;
}

body {
    margin: 0;
    padding: 0;
    overflow-x: hidden;
}

/* ===== PAGE WRAPPER ===== */
.page-wrapper {
    padding: 15px;
    max-width: 100%;
    overflow-x: hidden;
}

/* ===== BACK BUTTON ===== */
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

/* ===== TITLE ===== */
h2 {
    color: #1e3c72;
    margin-bottom: 10px;
}

/* ===== ADD BUTTON ===== */
.btn-add {
    padding: 8px 12px;
    background: #4CAF50;
    color: #fff;
    border-radius: 6px;
    text-decoration: none;
    display: inline-block;
    margin-bottom: 15px;
}

/* ===== SUCCESS BOX ===== */
.success-box {
    margin: 10px 0;
    padding: 10px;
    background: #d4edda;
    color: #155724;
    border-radius: 6px;
}

/* ===== TABLE WRAPPER ===== */
.table-container {
    width: 100%;
    overflow-x: auto;
}

/* ===== TABLE ===== */
table {
    width: 100%;
    border-collapse: collapse;
    min-width: 750px; /* prevents breaking */
    background: #fff;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

th, td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: left;
    white-space: nowrap;
}

thead tr {
    background: #f5f5f5;
}

/* ===== ACTION BUTTONS ===== */
.action-btn {
    padding: 5px 8px;
    border-radius: 4px;
    text-decoration: none;
    color: #fff;
    font-size: 13px;
    display: inline-block;
    margin-right: 5px;
}

.view-btn { background: #03A9F4; }
.edit-btn { background: #FFC107; color: #000; }
.delete-btn {
    background: #F44336;
    border: none;
    color: #fff;
    padding: 5px 8px;
    border-radius: 4px;
    cursor: pointer;
}

/* ===== INLINE FORM ===== */
.inline-form {
    display: inline-block;
}

/* ===== MOBILE ===== */
@media (max-width: 768px) {
    table {
        min-width: 650px;
    }
}

@media (max-width: 480px) {
    .page-wrapper {
        padding: 10px;
    }

    .action-btn {
        display: block;
        margin-bottom: 5px;
        text-align: center;
    }

    th, td {
        font-size: 13px;
    }
}
</style>

<div class="page-wrapper">

    <!-- BACK -->
    <a href="{{ route('district.admin.assemblies.index') }}" class="btn-back">
        ← Back to Assemblies
    </a>

    <!-- TITLE -->
    <h2>Assembly Members - {{ $assembly->name }}</h2>

    <!-- ADD -->
    <a href="{{ route('district.assemblies.members.create', $assembly->id) }}"
       class="btn-add">
        + Add Member
    </a>

    <!-- SUCCESS -->
    @if(session('success'))
    <div class="success-box">
        {{ session('success') }}
    </div>
    @endif

    <!-- TABLE -->
    <div class="table-container">

        <table>

            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Contact</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                @forelse($members as $index => $member)
                <tr>

                    <!-- INDEX -->
                    <td>{{ $index + 1 }}</td>

                    <!-- NAME -->
                    <td>{{ $member->name }}</td>

                    <!-- GENDER -->
                    <td>{{ $member->gender }}</td>

                    <!-- CONTACT -->
                    <td>{{ $member->contact }}</td>

                    <!-- ACTIONS -->
                    <td>

                        <a href="{{ route('district.assemblies.members.show', [$assembly->id, $member->id]) }}"
                           class="action-btn view-btn">
                            View
                        </a>

                        <a href="{{ route('district.assemblies.members.edit', [$assembly->id, $member->id]) }}"
                           class="action-btn edit-btn">
                            Edit
                        </a>

                        <form action="{{ route('district.assemblies.members.destroy', [$assembly->id, $member->id]) }}"
                              method="POST"
                              class="inline-form">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="action-btn delete-btn"
                                    onclick="return confirm('Delete member?')">
                                Delete
                            </button>

                        </form>

                    </td>

                </tr>

                @empty
                <tr>
                    <td colspan="5" style="text-align:center;padding:15px;">
                        No members found.
                    </td>
                </tr>
                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection