@extends('layouts.admin')

@section('content')

<style>
/* ===== PAGE WRAPPER ===== */
.page-wrapper {
    max-width: 1100px;
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
    font-size: 20px;
    margin-bottom: 15px;
    color: #2c3e50;
}

/* ===== ALERT ===== */
.alert-success {
    background: #d4edda;
    color: #155724;
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 15px;
}

/* ===== FILTER FORM ===== */
.filter-form {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 15px;
}

.filter-select {
    padding: 10px;
    width: 250px;
    max-width: 100%;
    border: 1px solid #ccc;
    border-radius: 6px;
}

/* ===== BUTTONS ===== */
.btn {
    padding: 10px 14px;
    border-radius: 6px;
    border: none;
    color: #fff;
    cursor: pointer;
    text-decoration: none;
    font-size: 13px;
}

.btn-blue { background: #2196F3; }
.btn-gray { background: #607D8B; }
.btn-green { background: #4CAF50; }
.btn-red { background: #F44336; }

.btn:hover { opacity: 0.85; }

/* ===== TABLE ===== */
.table-wrapper {
    width: 100%;
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    min-width: 700px;
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

th {
    background: #f5f5f5;
    padding: 10px;
    border: 1px solid #eee;
    text-align: left;
}

td {
    padding: 10px;
    border: 1px solid #eee;
    font-size: 14px;
}

/* ===== STATUS ===== */
.status {
    color: orange;
    font-weight: bold;
}

/* ===== ACTIONS ===== */
.actions {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

/* ===== MOBILE ===== */
@media (max-width: 768px) {
    .filter-form {
        flex-direction: column;
    }

    .filter-select {
        width: 100%;
    }

    table {
        min-width: 600px;
    }

    .actions {
        flex-direction: column;
        align-items: stretch;
    }
}
</style>

<div class="page-wrapper">

    {{-- BACK --}}
    <a href="{{ route('admin.districts.dashboard') }}" class="btn-back">
        ← Back to District Dashboard
    </a>

    {{-- TITLE --}}
    <h2 class="page-title">New Assembly Requests</h2>

    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- FILTER --}}
    <form method="GET"
          action="{{ route('admin.assembly.requests') }}"
          class="filter-form">

        <select name="district_id" class="filter-select">
            <option value="">-- Filter by District --</option>

            @foreach($districts as $district)
                <option value="{{ $district->id }}"
                    {{ request('district_id') == $district->id ? 'selected' : '' }}>
                    {{ $district->name }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-blue">
            Search
        </button>

        <a href="{{ route('admin.assembly.requests') }}" class="btn btn-gray">
            Reset
        </a>

    </form>

    {{-- TABLE --}}
    <div class="table-wrapper">

        <table>

            <thead>
                <tr>
                    <th>District</th>
                    <th>Proposed Assembly</th>
                    <th>Physical Address</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($requests as $request)
                <tr>

                    <td>{{ $request->district->name ?? 'N/A' }}</td>

                    <td>{{ $request->name }}</td>

                    <td>{{ $request->physical_address }}</td>

                    <td class="status">
                        {{ ucfirst($request->status) }}
                    </td>

                    <td>

                        <div class="actions">

                            <!-- APPROVE -->
                            <form action="{{ route('admin.assembly.approve', $request->id) }}"
                                  method="POST">
                                @csrf
                                <button class="btn btn-green">
                                    Approve
                                </button>
                            </form>

                            <!-- REJECT -->
                            <form action="{{ route('admin.assembly.reject', $request->id) }}"
                                  method="POST">
                                @csrf
                                <button class="btn btn-red">
                                    Reject
                                </button>
                            </form>

                        </div>

                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center; padding:15px;">
                        No pending assembly requests.
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>

    </div>

</div>

@endsection