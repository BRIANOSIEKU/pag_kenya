@extends('layouts.district_admin')

@section('content')

<h1>Assemblies</h1>

<!-- ADD BUTTON -->
<a href="{{ route('district.admin.assemblies.create') }}" 
   style="padding:8px 12px; background:#4CAF50; color:#fff; border-radius:6px; text-decoration:none; margin-bottom:15px; display:inline-block;">
    + Add Assembly
</a>

<!-- SUCCESS MESSAGE -->
@if(session('success'))
    <div style="margin:10px 0; padding:10px; background:#d4edda; color:#155724; border-radius:6px;">
        {{ session('success') }}
    </div>
@endif

<!-- LIVE SEARCH INPUT -->
<input type="text" id="searchInput"
       placeholder="Search assemblies..."
       style="padding:6px 10px; border-radius:4px; border:1px solid #ccc; width:100%; max-width:400px; margin-bottom:15px;">

<!-- TABLE -->
<table style="width:100%; border-collapse:collapse; box-shadow:0 2px 8px rgba(0,0,0,0.1);">

    <thead>
        <tr style="background:#f5f5f5; text-align:left;">
            <th style="padding:10px; border:1px solid #ddd;">#</th>
            <th style="padding:10px; border:1px solid #ddd;">Assembly Name</th>
            <th style="padding:10px; border:1px solid #ddd;">Address</th>
            <th style="padding:10px; border:1px solid #ddd;">Status</th>
            <th style="padding:10px; border:1px solid #ddd;">Actions</th>
        </tr>
    </thead>

    <tbody>
        @forelse($assemblies as $index => $assembly)
        <tr class="assembly-row">

            <!-- INDEX -->
            <td style="padding:10px; border:1px solid #ddd;">
                {{ $index + 1 }}
            </td>

            <!-- NAME -->
            <td class="name" style="padding:10px; border:1px solid #ddd;">
                {{ $assembly->name }}
            </td>

            <!-- ADDRESS -->
            <td class="address" style="padding:10px; border:1px solid #ddd;">
                {{ $assembly->physical_address }}
            </td>

            <!-- STATUS -->
            <td style="padding:10px; border:1px solid #ddd;">
                @if($assembly->status == 'pending')
                    <span style="color:orange;font-weight:bold;">Pending</span>
                @else
                    <span style="color:green;font-weight:bold;">Approved</span>
                @endif
            </td>

            <!-- ACTIONS -->
            <td style="padding:10px; border:1px solid #ddd;">

                <!-- LEADERS BUTTON -->
                <a href="{{ route('district.assemblies.leaders.index', $assembly->id) }}" 
                   style="margin-right:5px; color:#fff; background:#9C27B0; padding:6px 10px; border-radius:4px; text-decoration:none; display:inline-block;">
                    Assembly Leaders
                </a>

                <!-- MEMBERS BUTTON -->
                <a href="{{ route('district.assemblies.members.index', $assembly->id) }}" 
                   style="margin-right:5px; color:#fff; background:#03A9F4; padding:6px 10px; border-radius:4px; text-decoration:none; display:inline-block;">
                    Assembly Members
                </a>

            </td>
        </tr>

        @empty
        <tr>
            <td colspan="5" style="padding:15px; text-align:center;">
                No assemblies found.
            </td>
        </tr>
        @endforelse

    </tbody>
</table>

<!-- PAGINATION -->
@if(method_exists($assemblies, 'links'))
    <div style="margin-top:15px;">
        {{ $assemblies->links() }}
    </div>
@endif

<!-- LIVE SEARCH SCRIPT -->
<script>
document.getElementById('searchInput').addEventListener('keyup', function () {

    let value = this.value.toLowerCase();
    let rows = document.querySelectorAll('.assembly-row');

    rows.forEach(function(row) {

        let name = row.querySelector('.name').innerText.toLowerCase();
        let address = row.querySelector('.address').innerText.toLowerCase();

        if (name.includes(value) || address.includes(value)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }

    });

});
</script>

@endsection