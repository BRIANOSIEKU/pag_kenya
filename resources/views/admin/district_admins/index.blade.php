@extends('layouts.admin')

@section('content')

<style>
/* ===== PAGE WRAPPER ===== */
.page-wrapper {
    max-width: 1100px;
    margin: auto;
    padding: 15px;
}

/* ===== TITLE ===== */
.page-title {
    text-align: center;
    font-size: 24px;
    color: #1e3c72;
    margin-bottom: 5px;
}

/* ===== ACCENT LINE ===== */
.title-line {
    width: 120px;
    height: 4px;
    background: #4CAF50;
    margin: 0 auto 20px auto;
    border-radius: 2px;
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

/* ===== TOP BAR ===== */
.top-bar {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 15px;
}

/* ===== SEARCH ===== */
.search-input {
    padding: 10px;
    width: 280px;
    max-width: 100%;
    border: 1px solid #ccc;
    border-radius: 6px;
}

/* ===== BUTTONS ===== */
.btn {
    display: inline-block;
    padding: 10px 14px;
    border-radius: 6px;
    text-decoration: none;
    color: #fff;
    font-size: 13px;
}

.btn-green { background: #4CAF50; }
.btn-blue { background: #2196F3; }
.btn-orange { background: #FF9800; }
.btn-red { background: #F44336; }

.btn:hover { opacity: 0.85; }

/* ===== SUCCESS ===== */
.alert-success {
    padding: 10px;
    background: #d4edda;
    color: #155724;
    margin-bottom: 12px;
    border-radius: 6px;
}

/* ===== TABLE WRAPPER ===== */
.table-wrapper {
    width: 100%;
    overflow-x: auto;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
}

/* ===== TABLE ===== */
table {
    width: 100%;
    border-collapse: collapse;
    min-width: 750px;
}

th, td {
    padding: 10px;
    border: 1px solid #eee;
    font-size: 14px;
    text-align: left;
    vertical-align: middle;
}

th {
    background: #f5f5f5;
}

/* ===== ACTIONS ===== */
.actions {
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
    align-items: center;
}

.small-input {
    width: 90px;
    padding: 6px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 12px;
}

/* ===== EMPTY ===== */
.empty {
    text-align: center;
    padding: 12px;
    color: #777;
}

/* ===== MOBILE ===== */
@media (max-width: 768px) {
    .page-title {
        font-size: 18px;
    }

    .top-bar {
        flex-direction: column;
        align-items: stretch;
    }

    .search-input {
        width: 100%;
    }

    table {
        min-width: 650px;
    }
}
</style>

<div class="page-wrapper">

    <!-- TITLE -->
    <h1 class="page-title">District Admins</h1>
    <div class="title-line"></div>

    <!-- BACK -->
    <a href="{{ route('admin.districts.dashboard') }}" class="btn-back">
        ← Back to District Module Dashboard
    </a>

    <!-- SUCCESS -->
    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- TOP BAR -->
    <div class="top-bar">

        <input type="text"
               id="searchInput"
               class="search-input"
               placeholder="Search username or district...">

        <a href="{{ route('admin.district_admins.create') }}" class="btn btn-green">
            + Add Admin
        </a>

    </div>

    <!-- TABLE -->
    <div class="table-wrapper">

        <table id="adminsTable">

            <thead>
                <tr>
                    <th>#</th>
                    <th>Username</th>
                    <th>District</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($admins as $admin)
                <tr>

                    <td>{{ $loop->iteration }}</td>
                    <td><strong>{{ $admin->username }}</strong></td>
                    <td>{{ $admin->district->name ?? '-' }}</td>

                    <td>

                        <div class="actions">

                            <!-- EDIT -->
                            <a href="{{ route('admin.district_admins.edit', $admin->id) }}"
                               class="btn btn-blue">
                                Edit
                            </a>

                            <!-- DELETE -->
                            <form action="{{ route('admin.district_admins.destroy', $admin->id) }}"
                                  method="POST">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        onclick="return confirm('Delete this admin?')"
                                        class="btn btn-red">
                                    Delete
                                </button>
                            </form>

                            <!-- RESET PASSWORD -->
                            <form action="{{ route('admin.district_admins.reset.password', $admin->id) }}"
                                  method="POST"
                                  class="actions">
                                @csrf

                                <input type="password"
                                       name="password"
                                       placeholder="New"
                                       required
                                       class="small-input">

                                <button type="submit" class="btn btn-orange">
                                    Reset
                                </button>
                            </form>

                        </div>

                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="4" class="empty">
                        No district admins found
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>

    </div>

    <!-- PAGINATION -->
    <div style="margin-top:10px;">
        {{ $admins->links() }}
    </div>

</div>

@endsection

{{-- ================= LIVE SEARCH ================= --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('searchInput');
    const rows = document.querySelectorAll('#adminsTable tbody tr');

    searchInput.addEventListener('input', function () {

        let filter = this.value.toLowerCase().trim();

        rows.forEach(row => {

            let username = row.cells[1].textContent.toLowerCase();
            let district = row.cells[2].textContent.toLowerCase();

            let match = username.includes(filter) || district.includes(filter);

            row.style.display = match ? '' : 'none';

        });

    });

});
</script>