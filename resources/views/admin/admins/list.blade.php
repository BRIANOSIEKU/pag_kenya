@extends('layouts.admin')

@section('title', 'Admins List')

@section('content')

<style>
.container {
    max-width: 1100px;
    margin: auto;
    padding: 15px;
}

/* HEADER */
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

/* TITLE */
h2 {
    font-size: 24px;
    font-weight: bold;
}

/* BUTTON */
.btn {
    padding: 10px 14px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: bold;
    font-size: 13px;
    display: inline-block;
}
.btn-primary {
    background: #2196F3;
    color: #fff;
}
.btn-primary:hover {
    opacity: 0.85;
}

/* ALERT */
.alert-success {
    background: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 15px;
}

/* TABLE WRAPPER */
.table-container {
    background: #fff;
    border-radius: 12px;
    overflow-x: auto;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
}

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
    min-width: 700px;
}

thead {
    background: #f5f5f5;
}

th, td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #eee;
    font-size: 14px;
}

tr:hover {
    background: #fafafa;
}

/* ROLE BADGE */
.badge {
    display: inline-block;
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 12px;
    background: #e3f2fd;
    color: #1565c0;
    margin: 2px;
}

/* ACTION BUTTON */
.btn-warning {
    background: #FFC107;
    color: #fff;
    padding: 6px 10px;
    border-radius: 6px;
    font-size: 12px;
    text-decoration: none;
}
.btn-warning:hover {
    opacity: 0.85;
}

/* EMPTY STATE */
.empty {
    text-align: center;
    padding: 20px;
    color: #777;
}

/* RESPONSIVE */
@media(max-width:768px){
    .header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
}
</style>

<div class="container">

    <!-- HEADER -->
    <div class="header">
        <h2>Admins List</h2>

        <a href="{{ route('admin.admins.create') }}" class="btn btn-primary">
            + Add New Admin
        </a>
    </div>

    <!-- SUCCESS MESSAGE -->
    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- TABLE -->
    <div class="table-container">

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th style="text-align:center;">Actions</th>
                </tr>
            </thead>

            <tbody>

                @forelse($admins as $admin)
                <tr>
                    <td>{{ $admin->id }}</td>
                    <td>{{ $admin->name }}</td>
                    <td>{{ $admin->email }}</td>

                    <!-- ROLE -->
                    <td>
                        @if($admin->roles->isNotEmpty())
                            @foreach($admin->roles as $role)
                                <span class="badge">
                                    {{ str_replace('_', ' ', ucwords($role->name)) }}
                                </span>
                            @endforeach
                        @else
                            <span style="color:#999;font-style:italic;">No Role Assigned</span>
                        @endif
                    </td>

                    <!-- ACTIONS -->
                    <td style="text-align:center;">

                        @if(Auth::user()->hasRole('super_admin') && !$admin->hasRole('super_admin'))
                            <a href="{{ route('admin.admins.reset_password.form', $admin->id) }}"
                               class="btn-warning">
                                Reset Password
                            </a>

                        @elseif($admin->hasRole('super_admin'))
                            <span style="color:#999;font-size:12px;">Protected</span>

                        @else
                            <span style="color:#bbb;font-size:12px;">-</span>
                        @endif

                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="empty">
                        No admin accounts found in the system.
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>

    </div>

</div>

@endsection