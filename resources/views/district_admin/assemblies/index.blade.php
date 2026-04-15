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
h1 {
    margin-bottom: 10px;
    color: #1e3c72;
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

/* ===== SEARCH INPUT ===== */
#searchInput {
    padding: 8px 10px;
    border-radius: 6px;
    border: 1px solid #ccc;
    width: 100%;
    max-width: 400px;
    margin-bottom: 15px;
}

/* ===== TABLE WRAPPER (IMPORTANT FOR MOBILE) ===== */
.table-container {
    width: 100%;
    overflow-x: auto;
}

/* ===== TABLE ===== */
table {
    width: 100%;
    border-collapse: collapse;
    min-width: 750px; /* prevents layout breaking */
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    background: #fff;
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
    padding: 6px 10px;
    border-radius: 4px;
    text-decoration: none;
    color: #fff;
    display: inline-block;
    margin-right: 5px;
    font-size: 13px;
}

.btn-purple { background: #9C27B0; }
.btn-blue { background: #03A9F4; }

/* ===== STATUS ===== */
.status-pending {
    color: orange;
    font-weight: bold;
}

.status-approved {
    color: green;
    font-weight: bold;
}

/* ===== PAGINATION ===== */
.pagination {
    margin-top: 15px;
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

    th, td {
        font-size: 13px;
    }

    .action-btn {
        display: block;
        margin-bottom: 5px;
        text-align: center;
    }

    #searchInput {
        max-width: 100%;
    }
}
</style>

<div class="page-wrapper">

    <!-- BACK -->
    <a href="{{ route('district.admin.dashboard') }}" class="btn-back">
        ← Back to Dashboard
    </a>

    <!-- TITLE -->
    <h1>Assemblies</h1>

    <!-- ADD BUTTON -->
    <a href="{{ route('district.admin.assemblies.create') }}" class="btn-add">
        + Add Assembly
    </a>

    <!-- SUCCESS -->
    @if(session('success'))
        <div class="success-box">
            {{ session('success') }}
        </div>
    @endif

    <!-- SEARCH -->
    <input type="text" id="searchInput" placeholder="Search assemblies...">

    <!-- TABLE -->
    <div class="table-container">

        <table>

            <thead>
                <tr>
                    <th>#</th>
                    <th>Assembly Name</th>
                    <th>Address</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                @forelse($assemblies as $index => $assembly)
                <tr class="assembly-row">

                    <td>{{ $index + 1 }}</td>

                    <td class="name">
                        {{ $assembly->name }}
                    </td>

                    <td class="address">
                        {{ $assembly->physical_address }}
                    </td>

                    <td>
                        @if($assembly->status == 'pending')
                            <span class="status-pending">Pending</span>
                        @else
                            <span class="status-approved">Approved</span>
                        @endif
                    </td>

                    <td>

                        <!-- LEADERS -->
                        <a href="{{ route('district.assemblies.leaders.index', $assembly->id) }}"
                           class="action-btn btn-purple">
                            Leaders
                        </a>

                        <!-- MEMBERS -->
                        <a href="{{ route('district.assemblies.members.index', $assembly->id) }}"
                           class="action-btn btn-blue">
                            Members
                        </a>

                    </td>

                </tr>
                @empty

                <tr>
                    <td colspan="5" style="text-align:center;padding:15px;">
                        No assemblies found.
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <!-- PAGINATION -->
    @if(method_exists($assemblies, 'links'))
        <div class="pagination">
            {{ $assemblies->links() }}
        </div>
    @endif

</div>

<!-- SEARCH SCRIPT -->
<script>
document.getElementById('searchInput').addEventListener('keyup', function () {

    let value = this.value.toLowerCase();
    let rows = document.querySelectorAll('.assembly-row');

    rows.forEach(function(row) {

        let name = row.querySelector('.name').innerText.toLowerCase();
        let address = row.querySelector('.address').innerText.toLowerCase();

        row.style.display = (name.includes(value) || address.includes(value)) ? '' : 'none';

    });

});
</script>

@endsection