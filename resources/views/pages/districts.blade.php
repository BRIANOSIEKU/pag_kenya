@extends('layouts.app')

@section('content')
<div style="max-width:1000px; margin:auto; padding:20px;">

    {{-- Page Title --}}
    <h1 style="text-align:center; color:#1e3c72; margin-bottom:10px; font-size:2em;">
        Church Districts
    </h1>
    <div style="width:120px; height:4px; background:#FF9800; margin:0 auto 30px auto; border-radius:2px;"></div>

    {{-- Search Filter --}}
    <div style="margin-bottom:20px; text-align:right;">
        <input type="text" id="searchInput"
               placeholder="Search District or Overseer..."
               style="padding:8px 12px; width:250px; border:1px solid #ccc; border-radius:4px;">
    </div>

    @if($districts->count() > 0)
        <table id="districtsTable" style="width:100%; border-collapse:collapse; box-shadow:0 0 10px rgba(0,0,0,0.1);">
            <thead>
                <tr style="background:#f5f5f5; text-align:left;">
                    <th style="padding:10px; border:1px solid #ddd; width:40px;">#</th>
                    <th style="padding:10px; border:1px solid #ddd;">District Name</th>
                    <th style="padding:10px; border:1px solid #ddd;">Overseer</th>
                    <th style="padding:10px; border:1px solid #ddd;">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($districts as $index => $district)
                    <tr>
                        <td style="padding:10px; border:1px solid #ddd; font-weight:bold;">
                            {{ $index + 1 }}
                        </td>

                        <td style="padding:10px; border:1px solid #ddd; font-weight:bold;">
                            {{ $district->name }}
                        </td>

                        <td style="padding:10px; border:1px solid #ddd;">
                            {{ $district->overseer_name ?? 'Not Assigned' }}
                        </td>

                        <td style="padding:10px; border:1px solid #ddd;">
                            <a href="{{ route('public.districts.show', $district->id) }}"
                               style="padding:6px 12px; background:#1e3c72; color:#fff; border-radius:4px; text-decoration:none; margin-right:5px;">
                                Leadership
                            </a>

                            <a href="{{ route('public.pastoral-teams.by-district', $district->id) }}"
                               style="padding:6px 12px; background:#FF9800; color:#fff; border-radius:4px; text-decoration:none;">
                                Pastoral Team
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="text-align:center; color:#777;">No districts available at the moment.</p>
    @endif

</div>

{{-- Search Script --}}
<script>
document.getElementById('searchInput').addEventListener('keyup', function() {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll('#districtsTable tbody tr');

    rows.forEach(row => {
        let districtName = row.cells[1].textContent.toLowerCase();
        let overseerName = row.cells[2].textContent.toLowerCase();

        if (districtName.includes(filter) || overseerName.includes(filter)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>

@endsection