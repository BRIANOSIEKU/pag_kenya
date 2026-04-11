@extends('layouts.district_admin')

@section('content')

<h2>Assembly Leaders - {{ $assembly->name }}</h2>

<!-- ADD BUTTON -->
<a href="{{ route('district.assemblies.leaders.create', $assembly->id) }}"
   style="padding:8px 12px; background:#4CAF50; color:#fff; border-radius:6px; text-decoration:none; display:inline-block; margin-bottom:15px;">
    + Add Leader
</a>

<!-- SUCCESS MESSAGE -->
@if(session('success'))
<div style="margin:10px 0; padding:10px; background:#d4edda; color:#155724; border-radius:6px;">
    {{ session('success') }}
</div>
@endif

<!-- TABLE -->
<table style="width:100%; border-collapse:collapse; box-shadow:0 2px 8px rgba(0,0,0,0.1);">

    <thead>
        <tr style="background:#f5f5f5;">
            <th style="padding:10px; border:1px solid #ddd;">Photo</th>
            <th style="padding:10px; border:1px solid #ddd;">Name</th>
            <th style="padding:10px; border:1px solid #ddd;">Position</th>
            <th style="padding:10px; border:1px solid #ddd;">Contact</th>
            <th style="padding:10px; border:1px solid #ddd;">Gender</th>
            <th style="padding:10px; border:1px solid #ddd;">Actions</th>
        </tr>
    </thead>

    <tbody>
        @forelse($leaders as $leader)
        <tr>

            <!-- PHOTO -->
            <td style="padding:10px; border:1px solid #ddd;">
                @if($leader->photo)
                    <img src="{{ asset('storage/'.$leader->photo) }}"
                         width="50" height="50"
                         style="border-radius:50%;">
                @else
                    N/A
                @endif
            </td>

            <!-- NAME -->
            <td style="padding:10px; border:1px solid #ddd;">
                {{ $leader->name }}
            </td>

            <!-- POSITION -->
            <td style="padding:10px; border:1px solid #ddd; font-weight:bold; color:#003366;">
                {{ $leader->position }}
            </td>

            <!-- CONTACT -->
            <td style="padding:10px; border:1px solid #ddd;">
                {{ $leader->contact }}
            </td>

            <!-- GENDER -->
            <td style="padding:10px; border:1px solid #ddd;">
                {{ $leader->gender }}
            </td>

            <!-- ACTIONS -->
            <td style="padding:10px; border:1px solid #ddd;">

                <a href="{{ route('district.assemblies.leaders.show', [$assembly->id, $leader->id]) }}"
                   style="background:#03A9F4;color:#fff;padding:5px 8px;border-radius:4px;text-decoration:none;">
                    View
                </a>

                <a href="{{ route('district.assemblies.leaders.edit', [$assembly->id, $leader->id]) }}"
                   style="background:#FFC107;color:#fff;padding:5px 8px;border-radius:4px;text-decoration:none;">
                    Edit
                </a>

                <form action="{{ route('district.assemblies.leaders.destroy', [$assembly->id, $leader->id]) }}"
                      method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')

                    <button onclick="return confirm('Delete leader?')"
                            style="background:#F44336;color:#fff;border:none;padding:5px 8px;border-radius:4px;">
                        Delete
                    </button>
                </form>

            </td>

        </tr>

        @empty
        <tr>
            <td colspan="6" style="padding:15px; text-align:center;">
                No assembly leaders found.
            </td>
        </tr>
        @endforelse

    </tbody>
</table>

@endsection