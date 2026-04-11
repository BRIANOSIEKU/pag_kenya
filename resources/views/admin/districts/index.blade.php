@extends('layouts.admin')

@section('content')

<h1>Districts</h1>
<!-- EXPORT BUTTON -->
<a href="{{ route('admin.districts.export.form') }}" 
   style="padding:8px 12px; background:#000; color:#fff; border-radius:6px; text-decoration:none; margin-bottom:15px; display:inline-block;">
    Export PDF
</a>
<!-- Add Button -->
<a href="{{ route('admin.districts.create') }}" 
   style="padding:8px 12px; background:#4CAF50; color:#fff; border-radius:6px; text-decoration:none; margin-bottom:15px; display:inline-block;">
    + Add District
</a>

<!-- Success Message -->
@if(session('success'))
    <div style="margin:10px 0; padding:10px; background:#d4edda; color:#155724; border-radius:6px;">
        {{ session('success') }}
    </div>
@endif

<!-- Search Form -->
<form action="{{ route('admin.districts.index') }}" method="GET" 
      style="margin-bottom:15px; display:flex; gap:8px; flex-wrap:wrap;">
    
    <input type="text" name="search" 
           placeholder="Search districts..." 
           value="{{ request('search') }}" 
           style="padding:6px 10px; border-radius:4px; border:1px solid #ccc; flex:1; min-width:200px;">

    <button type="submit" 
            style="padding:6px 12px; background:#2196F3; color:#fff; border:none; border-radius:4px;">
        Search
    </button>
</form>

<!-- Table -->
<table style="width:100%; border-collapse:collapse; box-shadow:0 2px 8px rgba(0,0,0,0.1);">
    
    <thead>
        <tr style="background:#f5f5f5; text-align:left;">
            <th style="padding:10px; border:1px solid #ddd;">#</th>
            <th style="padding:10px; border:1px solid #ddd;">District Name</th>
            <th style="padding:10px; border:1px solid #ddd;">Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach($districts as $index => $district)
        <tr>
            <td style="padding:10px; border:1px solid #ddd;">
                {{ $index + 1 }}
            </td>

            <td style="padding:10px; border:1px solid #ddd;">
                {{ $district->name }}
            </td>

            <td style="padding:10px; border:1px solid #ddd;">

                <a href="" 
                   style="margin-right:5px; color:#fff; background:#03A9F4; padding:4px 8px; border-radius:4px; text-decoration:none;">
                    Pastoral Team
                </a>

                <a href="{{ route('admin.districts.leadership.index', $district->id) }}" 
                   style="margin-right:5px; color:#fff; background:#9C27B0; padding:4px 8px; border-radius:4px; text-decoration:none;">
                    Leadership
                </a>

                <a href="{{ route('admin.districts.edit', $district->id) }}" 
                   style="margin-right:5px; color:#fff; background:#FFC107; padding:4px 8px; border-radius:4px; text-decoration:none;">
                    Edit
                </a>

                <form action="{{ route('admin.districts.destroy', $district->id) }}" 
                      method="POST" style="display:inline-block;">
                    
                    @csrf
                    @method('DELETE')

                    <button type="submit" 
                            onclick="return confirm('Delete this district?');" 
                            style="color:#fff; background:#F44336; padding:4px 8px; border:none; border-radius:4px; cursor:pointer;">
                        Delete
                    </button>
                </form>

            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Pagination (if needed later) -->
@if(method_exists($districts, 'links'))
    <div style="margin-top:15px;">
        {{ $districts->links() }}
    </div>
@endif

@endsection