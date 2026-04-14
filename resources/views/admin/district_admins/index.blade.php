@extends('layouts.admin')

@section('content')

<div style="max-width:1100px; margin:auto; padding:20px;">

    {{-- ================= TITLE ================= --}}
    <h1 style="text-align:center; color:#1e3c72; margin-bottom:8px; font-size:2em;">
        District Admins
    </h1>

    <style>
    .btn-back {
    background: #607D8B;
    color: white;
    padding: 8px 12px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 13px;
    font-weight: bold;
}

.btn-back:hover {
    opacity: 0.85;
}
</style>

   <a href="{{ route('admin.districts.dashboard') }}" class="btn-back">
            ← Back to District Module Dashboard
        </a>


    <div style="width:120px; height:4px; background:#4CAF50; margin:0 auto 20px auto; border-radius:2px;"></div>

    {{-- ================= SUCCESS ================= --}}
    @if(session('success'))
        <div style="padding:8px; background:#d4edda; color:#155724; margin-bottom:12px; border-radius:5px;">
            {{ session('success') }}
        </div>
    @endif

    {{-- ================= SEARCH + ADD ================= --}}
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">

        <input type="text"
               id="searchInput"
               placeholder="Search username or district..."
               style="padding:8px; width:280px; border:1px solid #ccc; border-radius:5px;">

        <a href="{{ route('admin.district_admins.create') }}"
           style="padding:8px 14px; background:#4CAF50; color:#fff; border-radius:5px; text-decoration:none;">
            + Add Admin
        </a>

    </div>

    {{-- ================= TABLE ================= --}}
    <table id="adminsTable"
           style="width:100%; border-collapse:collapse; background:#fff; box-shadow:0 0 8px rgba(0,0,0,0.08);">

        <thead>
            <tr style="background:#f5f5f5;">
                <th style="padding:8px; border:1px solid #ddd;">#</th>
                <th style="padding:8px; border:1px solid #ddd;">Username</th>
                <th style="padding:8px; border:1px solid #ddd;">District</th>
                <th style="padding:8px; border:1px solid #ddd; width:260px;">Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse($admins as $admin)
                <tr>
                    <td style="padding:6px 8px; border:1px solid #ddd;">
                        {{ $loop->iteration }}
                    </td>

                    <td style="padding:6px 8px; border:1px solid #ddd; font-weight:bold;">
                        {{ $admin->username }}
                    </td>

                    <td style="padding:6px 8px; border:1px solid #ddd;">
                        {{ $admin->district->name ?? '-' }}
                    </td>

                    <td style="padding:6px 8px; border:1px solid #ddd;">

                        {{-- EDIT --}}
                        <a href="{{ route('admin.district_admins.edit', $admin->id) }}"
                           style="padding:5px 8px; background:#2196F3; color:#fff; border-radius:4px; text-decoration:none; font-size:13px;">
                            Edit
                        </a>

                        {{-- DELETE --}}
                        <form action="{{ route('admin.district_admins.destroy', $admin->id) }}"
                              method="POST"
                              style="display:inline;">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    onclick="return confirm('Delete this admin?')"
                                    style="padding:5px 8px; background:#f44336; color:#fff; border:none; border-radius:4px; font-size:13px;">
                                Delete
                            </button>
                        </form>

                        {{-- RESET PASSWORD --}}
                        <form action="{{ route('admin.district_admins.reset.password', $admin->id) }}"
                              method="POST"
                              style="display:inline;">
                            @csrf

                            <input type="password"
                                   name="password"
                                   placeholder="New"
                                   required
                                   style="padding:5px; width:80px; border:1px solid #ccc; border-radius:4px; font-size:12px;">

                            <button type="submit"
                                    style="padding:5px 8px; background:#FF9800; color:#fff; border:none; border-radius:4px; font-size:12px;">
                                Reset
                            </button>
                        </form>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align:center; padding:12px; color:#777;">
                        No district admins found
                    </td>
                </tr>
            @endforelse
        </tbody>

    </table>

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