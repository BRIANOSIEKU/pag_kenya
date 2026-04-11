@extends('layouts.district_admin')

@section('content')

<h2>Assembly Members - {{ $assembly->name }}</h2>

<!-- ADD BUTTON -->
<a href="{{ route('district.assemblies.members.create', $assembly->id) }}"
   style="padding:8px 12px; background:#4CAF50; color:#fff; border-radius:6px; text-decoration:none; display:inline-block; margin-bottom:15px;">
    + Add Member
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
            <th style="padding:10px; border:1px solid #ddd;">#</th>
            <th style="padding:10px; border:1px solid #ddd;">Name</th>
            <th style="padding:10px; border:1px solid #ddd;">Gender</th>
            <th style="padding:10px; border:1px solid #ddd;">Contact</th>
            <th style="padding:10px; border:1px solid #ddd;">Actions</th>
        </tr>
    </thead>

    <tbody>

        @forelse($members as $index => $member)
        <tr>

            <!-- INDEX -->
            <td style="padding:10px; border:1px solid #ddd;">
                {{ $index + 1 }}
            </td>

            <!-- NAME -->
            <td style="padding:10px; border:1px solid #ddd;">
                {{ $member->name }}
            </td>

            <!-- GENDER -->
            <td style="padding:10px; border:1px solid #ddd;">
                {{ $member->gender }}
            </td>

            <!-- CONTACT -->
            <td style="padding:10px; border:1px solid #ddd;">
                {{ $member->contact }}
            </td>

            <!-- ACTIONS -->
            <td style="padding:10px; border:1px solid #ddd;">

                <a href="{{ route('district.assemblies.members.show', [$assembly->id, $member->id]) }}"
                   style="background:#03A9F4;color:#fff;padding:5px 8px;border-radius:4px;text-decoration:none;">
                    View
                </a>

                <a href="{{ route('district.assemblies.members.edit', [$assembly->id, $member->id]) }}"
                   style="background:#FFC107;color:#fff;padding:5px 8px;border-radius:4px;text-decoration:none;">
                    Edit
                </a>

                <form action="{{ route('district.assemblies.members.destroy', [$assembly->id, $member->id]) }}"
                      method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')

                    <button onclick="return confirm('Delete member?')"
                            style="background:#F44336;color:#fff;border:none;padding:5px 8px;border-radius:4px;">
                        Delete
                    </button>
                </form>

            </td>

        </tr>
        @empty

        <tr>
            <td colspan="5" style="padding:15px; text-align:center;">
                No members found.
            </td>
        </tr>

        @endforelse

    </tbody>

</table>

@endsection