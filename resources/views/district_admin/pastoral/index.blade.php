@extends('layouts.district_admin')

@section('content')

<h2>Pastoral Team</h2>

<!-- ADD BUTTON -->
<a href="{{ route('district.admin.pastoral.create') }}"
   style="padding:8px 12px; background:#4CAF50; color:#fff; border-radius:6px; text-decoration:none; display:inline-block; margin-bottom:15px;">
    + Add Pastor
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
            <th style="padding:10px; border:1px solid #ddd;">National ID</th>
            <th style="padding:10px; border:1px solid #ddd;">Assembly</th>
            <th style="padding:10px; border:1px solid #ddd;">Graduation Year</th>
            <th style="padding:10px; border:1px solid #ddd;">Contact</th>
            <th style="padding:10px; border:1px solid #ddd;">Gender</th>
            <th style="padding:10px; border:1px solid #ddd;">Actions</th>
        </tr>
    </thead>

    <tbody>
        @forelse($pastors as $pastor)
        <tr>

            <!-- PHOTO -->
            <td style="padding:10px; border:1px solid #ddd;">
                @if($pastor->photo)
                    <img src="{{ asset('storage/'.$pastor->photo) }}"
                         width="50" height="50"
                         style="border-radius:50%;">
                @else
                    N/A
                @endif
            </td>

            <!-- NAME -->
            <td style="padding:10px; border:1px solid #ddd;">
                {{ $pastor->name }}
            </td>

            <!-- NATIONAL ID -->
            <td style="padding:10px; border:1px solid #ddd;">
                {{ $pastor->national_id }}
            </td>

            <!-- ASSEMBLY -->
            <td style="padding:10px; border:1px solid #ddd; font-weight:bold; color:#003366;">
                {{ $pastor->assembly->name ?? 'N/A' }}
            </td>

            <!-- GRADUATION YEAR (NEW) -->
            <td style="padding:10px; border:1px solid #ddd;">
                {{ $pastor->graduation_year ?? 'N/A' }}
            </td>

            <!-- CONTACT -->
            <td style="padding:10px; border:1px solid #ddd;">
                {{ $pastor->contact }}
            </td>

            <!-- GENDER -->
            <td style="padding:10px; border:1px solid #ddd;">
                {{ $pastor->gender }}
            </td>

            <!-- ACTIONS -->
            <td style="padding:10px; border:1px solid #ddd;">

                <!-- VIEW -->
                <a href="{{ route('district.admin.pastoral.show', $pastor->id) }}"
                   style="background:#03A9F4;color:#fff;padding:5px 8px;border-radius:4px;text-decoration:none;">
                    View
                </a>

                <!-- EDIT -->
                <a href="{{ route('district.admin.pastoral.edit', $pastor->id) }}"
                   style="background:#FFC107;color:#fff;padding:5px 8px;border-radius:4px;text-decoration:none;">
                    Edit
                </a>

                <!-- DELETE -->
                <form action="{{ route('district.admin.pastoral.delete', $pastor->id) }}"
                      method="POST"
                      style="display:inline-block;">

                    @csrf
                    @method('DELETE')

                    <button onclick="return confirm('Delete this pastor?')"
                            style="background:#F44336;color:#fff;border:none;padding:5px 8px;border-radius:4px;">
                        Delete
                    </button>

                </form>

            </td>

        </tr>

        @empty
        <tr>
            <td colspan="8" style="padding:15px; text-align:center;">
                No pastoral records found.
            </td>
        </tr>
        @endforelse

    </tbody>
</table>

@endsection