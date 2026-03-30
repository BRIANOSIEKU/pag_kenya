@extends('layouts.app')

@section('content')
<div style="max-width:1000px; margin:auto; padding:20px;">

    {{-- Page Title --}}
    <h1 style="text-align:center; color:#1e3c72; margin-bottom:10px; font-size:2em;">
        Church Overseers
    </h1>
    <div style="width:120px; height:4px; background:#FF9800; margin:0 auto 30px auto; border-radius:2px;"></div>

    {{-- Search Filter --}}
    <div style="margin-bottom:20px; text-align:right;">
        <input type="text" id="searchInput" 
               placeholder="Search Overseers..." 
               style="padding:8px 12px; width:250px; border:1px solid #ccc; border-radius:4px;">
    </div>

    @if($overseers->count() > 0)
        <table id="overseersTable" style="width:100%; border-collapse:collapse; box-shadow:0 0 10px rgba(0,0,0,0.1);">
            <thead>
                <tr style="background:#f5f5f5; text-align:left;">
                    <th style="padding:10px; border:1px solid #ddd; width:40px;">#</th>
                    <th style="padding:10px; border:1px solid #ddd; width:80px;">Photo</th>
                    <th style="padding:10px; border:1px solid #ddd;">Name</th>
                    <th style="padding:10px; border:1px solid #ddd;">District</th>
                    <th style="padding:10px; border:1px solid #ddd;">Email</th>
                    <th style="padding:10px; border:1px solid #ddd; width:150px;">Pastoral Team</th>
                </tr>
            </thead>
            <tbody>
                @foreach($overseers as $index => $overseer)
                    <tr>
                        <td style="padding:10px; border:1px solid #ddd; font-weight:bold;">{{ $index + 1 }}</td>
                        <td style="padding:10px; border:1px solid #ddd; width:80px;">
                            @if($overseer->photo)
                                <img src="{{ asset('storage/'.$overseer->photo) }}" 
                                     alt="{{ $overseer->name }}" 
                                     width="60" height="60" 
                                     style="object-fit:cover; border-radius:50%; border:1px solid #ccc;">
                            @else
                                <div style="width:60px; height:60px; background:#ccc; border-radius:50%;"></div>
                            @endif
                        </td>
                        <td style="padding:10px; border:1px solid #ddd; font-weight:bold;">{{ $overseer->name }}</td>
                        <td style="padding:10px; border:1px solid #ddd;">{{ $overseer->district_name }}</td>
                        <td style="padding:10px; border:1px solid #ddd;">{{ $overseer->email ?? '-' }}</td>
                        <td style="padding:10px; border:1px solid #ddd;">
                            <a href="{{ route('public.pastoral-teams.by-district', $overseer->district_name) }}" 
                               style="padding:5px 10px; background:#FF9800; color:#fff; border-radius:4px; text-decoration:none;">
                               View Team
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="text-align:center; color:#777;">No overseers available at the moment.</p>
    @endif

</div>

{{-- Search Script --}}
<script>
document.getElementById('searchInput').addEventListener('keyup', function() {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll('#overseersTable tbody tr');

    rows.forEach(row => {
        let name = row.cells[2].textContent.toLowerCase();
        let district = row.cells[3].textContent.toLowerCase();
        let email = row.cells[4].textContent.toLowerCase();

        if(name.includes(filter) || district.includes(filter) || email.includes(filter)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>
@endsection