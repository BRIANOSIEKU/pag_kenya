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
    background: #607D8B;
    color: white;
    padding: 10px 14px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 13px;
    font-weight: bold;
    margin-bottom: 15px;
}

.btn-back:hover { opacity: 0.85; }

/* ===== TITLE ===== */
.page-title {
    font-size: 22px;
    color: #1e3c72;
    margin-bottom: 15px;
}

/* ===== ALERT ===== */
.alert-success {
    background: #d4edda;
    color: #155724;
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 10px;
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
    min-width: 900px;
    background: #fff;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

th {
    background: #f5f5f5;
    padding: 10px;
    border: 1px solid #ddd;
    text-align: left;
    font-size: 14px;
}

td {
    padding: 10px;
    border: 1px solid #ddd;
    font-size: 14px;
}

/* ===== BUTTONS ===== */
.btn {
    padding: 6px 10px;
    border-radius: 4px;
    color: white;
    border: none;
    cursor: pointer;
    font-size: 13px;
    text-decoration: none;
    display: inline-block;
}

.btn-view { background: #03A9F4; }
.btn-approve { background: #4CAF50; }
.btn-reject { background: #F44336; }

.btn:hover { opacity: 0.85; }

/* ===== STATUS BADGE ===== */
.badge-pending {
    background: orange;
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
}

/* ===== PHOTO ===== */
.photo {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    object-fit: cover;
}

/* ===== MOBILE ===== */
@media (max-width: 768px) {
    table {
        min-width: 700px;
    }

    .page-title {
        font-size: 18px;
    }
}
</style>

<div class="page-wrapper">

    {{-- BACK --}}
    <a href="{{ route('admin.districts.dashboard') }}" class="btn-back">
        ← Back to District Dashboard
    </a>

    {{-- TITLE --}}
    <h2 class="page-title">National Pastoral Approval</h2>

    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- EMPTY STATE --}}
    @if($pastors->count() == 0)
        <p>No pending pastoral submissions at the national level.</p>
    @else

    <div class="table-wrapper">

        <table>

            <thead>
                <tr>
                    <th>District</th>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>National ID</th>
                    <th>Assembly</th>
                    <th>Contact</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                @foreach($pastors as $p)
                <tr>

                    <td style="font-weight:bold; color:#1e3c72;">
                        {{ $p->district_name }}
                    </td>

                    <td>
                        @if($p->photo)
                            <img src="{{ asset('storage/'.$p->photo) }}" class="photo">
                        @else
                            N/A
                        @endif
                    </td>

                    <td>{{ $p->name }}</td>

                    <td>{{ $p->national_id }}</td>

                    <td>{{ $p->assembly_name ?? $p->assembly_id ?? 'N/A' }}</td>

                    <td>{{ $p->contact }}</td>

                    <td>
                        <span class="badge-pending">Pending</span>
                    </td>

                    <td>
                        <div style="display:flex; gap:6px; flex-wrap:wrap;">

                            <a href="{{ route('admin.national.pastoral.approvals.view', $p->id) }}"
                               class="btn btn-view">
                                View
                            </a>

                            <form method="POST"
                                  action="{{ route('admin.national.pastoral.approvals.approve', $p->id) }}">
                                @csrf
                                <button class="btn btn-approve">
                                    Approve
                                </button>
                            </form>

                            <form method="POST"
                                  action="{{ route('admin.national.pastoral.approvals.reject', $p->id) }}">
                                @csrf
                                <button class="btn btn-reject"
                                        onclick="return confirm('Reject this pastor?')">
                                    Reject
                                </button>
                            </form>

                        </div>
                    </td>

                </tr>
                @endforeach

            </tbody>

        </table>

    </div>

    @endif

</div>

@endsection