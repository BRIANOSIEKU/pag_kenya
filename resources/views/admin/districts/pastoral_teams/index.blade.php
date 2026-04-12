@extends('layouts.admin')

@section('content')

<h2>Pastoral Team - {{ $district->name }}</h2>

<!-- TOP ACTIONS -->
<div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;margin-bottom:15px;gap:10px;">

    <!-- BACK -->
    <a href="{{ route('admin.districts.index') }}"
       style="padding:6px 10px;background:#555;color:#fff;border-radius:4px;text-decoration:none;">
        ← Back to Districts
    </a>

    <!-- EXPORT -->
    <a href="{{ route('admin.districts.pastoral-teams.export', $district->id) }}"
       style="padding:6px 10px;background:#4CAF50;color:#fff;border-radius:4px;text-decoration:none;">
        📄 Export PDF
    </a>

</div>

<!-- SEARCH -->
<form method="GET" style="margin-bottom:15px;display:flex;gap:8px;">
    <input type="text" name="search" value="{{ request('search') }}"
           placeholder="Search pastors..."
           style="padding:6px;border:1px solid #ccc;border-radius:4px;flex:1;">

    <button type="submit"
            style="padding:6px 12px;background:#2196F3;color:#fff;border:none;border-radius:4px;">
        Search
    </button>
</form>

<!-- TABLE -->
<table style="width:100%;border-collapse:collapse;box-shadow:0 2px 8px rgba(0,0,0,0.1);">

    <thead>
        <tr style="background:#f5f5f5;">
            <th style="padding:10px;border:1px solid #ddd;">Photo</th>
            <th style="padding:10px;border:1px solid #ddd;">Name</th>
            <th style="padding:10px;border:1px solid #ddd;">Gender</th>
            <th style="padding:10px;border:1px solid #ddd;">Contact</th>
            <th style="padding:10px;border:1px solid #ddd;">Assembly</th>
            <th style="padding:10px;border:1px solid #ddd;">Actions</th>
        </tr>
    </thead>

    <tbody>
        @forelse($pastors as $pastor)
        <tr>

            <!-- PHOTO -->
            <td style="padding:10px;border:1px solid #ddd;">
                <img src="{{ $pastor->photo_url }}"
                     width="50" height="50"
                     style="border-radius:50%;object-fit:cover;">
            </td>

            <!-- NAME -->
            <td style="padding:10px;border:1px solid #ddd;">
                <a href="{{ route('admin.pastoral-teams.show', $pastor->id) }}"
                   style="color:#2196F3;text-decoration:none;">
                    {{ $pastor->name }}
                </a>
            </td>

            <td style="padding:10px;border:1px solid #ddd;">
                {{ $pastor->gender }}
            </td>

            <td style="padding:10px;border:1px solid #ddd;">
                {{ $pastor->contact }}
            </td>

            <td style="padding:10px;border:1px solid #ddd;">
                {{ $pastor->assembly->name ?? 'N/A' }}
            </td>

            <!-- ACTIONS -->
            <td style="padding:10px;border:1px solid #ddd;">

                <!-- VIEW -->
                <a href="{{ route('admin.pastoral-teams.show', $pastor->id) }}"
                   style="background:#03A9F4;color:#fff;padding:4px 8px;border-radius:4px;text-decoration:none;">
                    View
                </a>

                <!-- EDIT -->
                <a href="{{ route('admin.pastoral-teams.edit', $pastor->id) }}"
                   style="background:#FFC107;color:#000;padding:4px 8px;border-radius:4px;text-decoration:none;">
                    Edit
                </a>

                <!-- DELETE -->
                <form action="{{ route('admin.pastoral-teams.destroy', $pastor->id) }}"
                      method="POST"
                      style="display:inline;">
                    @csrf
                    @method('DELETE')

                    <button onclick="return confirm('Delete pastor?')"
                            style="background:#F44336;color:#fff;padding:4px 8px;border:none;border-radius:4px;">
                        Delete
                    </button>
                </form>

            </td>

        </tr>
        @empty
        <tr>
            <td colspan="6" style="text-align:center;padding:10px;">
                No pastors found in this district.
            </td>
        </tr>
        @endforelse
    </tbody>

</table>

<!-- PAGINATION -->
<div style="margin-top:15px;">
    {{ $pastors->links() }}
</div>

@endsection