@extends('layouts.admin')

@section('content')
<!-- Back to Dashboard -->
<a href="{{ route('admin.dashboard') }}" style="padding:8px 12px; background:#2196F3; color:#fff; border-radius:6px; text-decoration:none; margin-bottom:15px; display:inline-block;">
    &larr; Back to Dashboard
</a>
<div style="max-width:1000px; margin:auto; padding:20px;">

    <h1 style="text-align:center; color:#1e3c72; margin-bottom:10px; font-size:2em;">
        Pastoral Team Members
    </h1>
    <div style="width:120px; height:4px; background:#FF9800; margin:0 auto 30px auto; border-radius:2px;"></div>

    {{-- Add Button --}}
    <div style="margin-bottom:20px; text-align:right;">
        <a href="{{ route('admin.pastoral-teams.create') }}" 
           style="padding:8px 15px; background:#1e3c72; color:#fff; border-radius:4px; text-decoration:none;">
            + Add Pastoral Team
        </a>
    </div>

    {{-- District Filter --}}
    <div style="margin-bottom:20px;">
        <form method="GET" action="{{ route('admin.pastoral-teams.index') }}">
            <label for="district_filter">Filter by District:</label>
            <select name="district" id="district_filter" onchange="this.form.submit()">
                <option value="">-- All Districts --</option>
                @foreach($districts as $district)
                    <option value="{{ $district }}" {{ request('district') == $district ? 'selected' : '' }}>
                        {{ $district }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    @if($teams->count() > 0)
        <table style="width:100%; border-collapse:collapse; box-shadow:0 0 10px rgba(0,0,0,0.1);">
            <thead>
                <tr style="background:#f5f5f5; text-align:left;">
                    <th style="padding:10px; border:1px solid #ddd; width:40px;">#</th>
                    <th style="padding:10px; border:1px solid #ddd; width:80px;">Photo</th>
                    <th style="padding:10px; border:1px solid #ddd;">Name</th>
                    <th style="padding:10px; border:1px solid #ddd;">District</th>
                    <th style="padding:10px; border:1px solid #ddd;">Assembly</th>
                    <th style="padding:10px; border:1px solid #ddd;">Role</th>
                    <th style="padding:10px; border:1px solid #ddd;">Phone</th>
                    <th style="padding:10px; border:1px solid #ddd;">Email</th>
                    <th style="padding:10px; border:1px solid #ddd; width:120px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($teams as $index => $team)
                    <tr>
                        <td style="padding:10px; border:1px solid #ddd; font-weight:bold;">
                            {{ $index + 1 }}
                        </td>
                        <td style="padding:10px; border:1px solid #ddd; width:80px;">
                            @if($team->photo)
                                <img src="{{ asset('storage/'.$team->photo) }}" 
                                     alt="{{ $team->name }}" 
                                     width="60" height="60" 
                                     style="object-fit:cover; border-radius:50%; border:1px solid #ccc;">
                            @else
                                <div style="width:60px; height:60px; background:#ccc; border-radius:50%;"></div>
                            @endif
                        </td>
                        <td style="padding:10px; border:1px solid #ddd; font-weight:bold;">
                            {{ $team->name }}
                        </td>
                        <td style="padding:10px; border:1px solid #ddd;">
                            {{ $team->district_name }}
                        </td>
                        <td style="padding:10px; border:1px solid #ddd;">
                            {{ $team->assembly_name }}
                        </td>
                        <td style="padding:10px; border:1px solid #ddd;">
                            {{ $team->role ?? '-' }}
                        </td>
                        <td style="padding:10px; border:1px solid #ddd;">
                            {{ $team->phone ?? '-' }}
                        </td>
                        <td style="padding:10px; border:1px solid #ddd;">
                            {{ $team->email ?? '-' }}
                        </td>
                        <td style="padding:10px; border:1px solid #ddd;">
                            <a href="{{ route('admin.pastoral-teams.edit', $team->id) }}" 
                               style="padding:5px 10px; background:#FF9800; color:#fff; border-radius:4px; text-decoration:none;">
                               Edit
                            </a>
                            <form action="{{ route('admin.pastoral-teams.destroy', $team->id) }}" 
                                  method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Are you sure?')"
                                        style="padding:5px 10px; background:red; color:#fff; border:none; border-radius:4px;">
                                        Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Pagination --}}
        <div style="margin-top:15px;">
            {{ $teams->links() }}
        </div>

    @else
        <p style="text-align:center; color:#777;">No pastoral team members available.</p>
    @endif

</div>
@endsection