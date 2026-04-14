@extends('layouts.admin')

@section('content')

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
            ← Back to District Dashboard
        </a>

<h2>National Pastoral Approval</h2>

@if(session('success'))
<div style="background:#d4edda;padding:10px;color:#155724;margin-bottom:10px;border-radius:6px;">
    {{ session('success') }}
</div>
@endif

@if($pastors->count() == 0)
    <p>No pending pastoral submissions at the national level.</p>
@else

<table style="width:100%; border-collapse:collapse; box-shadow:0 2px 8px rgba(0,0,0,0.1);">

    <thead>
        <tr style="background:#f5f5f5;">
            <th style="padding:10px; border:1px solid #ddd;">District</th>
            <th style="padding:10px; border:1px solid #ddd;">Photo</th>
            <th style="padding:10px; border:1px solid #ddd;">Name</th>
            <th style="padding:10px; border:1px solid #ddd;">National ID</th>
            <th style="padding:10px; border:1px solid #ddd;">Assembly</th>
            <th style="padding:10px; border:1px solid #ddd;">Contact</th>
            <th style="padding:10px; border:1px solid #ddd;">Status</th>
            <th style="padding:10px; border:1px solid #ddd;">Actions</th>
        </tr>
    </thead>

    <tbody>

        @foreach($pastors as $p)
        <tr>

            <!-- DISTRICT -->
            <td style="padding:10px; border:1px solid #ddd; font-weight:bold; color:#1e3c72;">
                {{ $p->district_name }}
            </td>

            <!-- PHOTO -->
            <td style="padding:10px; border:1px solid #ddd;">
                @if($p->photo)
                    <img src="{{ asset('storage/'.$p->photo) }}"
                         width="45" height="45"
                         style="border-radius:50%;">
                @else
                    N/A
                @endif
            </td>

            <!-- NAME -->
            <td style="padding:10px; border:1px solid #ddd;">
                {{ $p->name }}
            </td>

            <!-- NATIONAL ID -->
            <td style="padding:10px; border:1px solid #ddd;">
                {{ $p->national_id }}
            </td>

            <!-- ASSEMBLY -->
            <td style="padding:10px; border:1px solid #ddd;">
                {{ $p->assembly_name ?? $p->assembly_id ?? 'N/A' }}
            </td>

            <!-- CONTACT -->
            <td style="padding:10px; border:1px solid #ddd;">
                {{ $p->contact }}
            </td>

            <!-- STATUS -->
            <td style="padding:10px; border:1px solid #ddd;">
                <span style="background:orange;color:#fff;padding:4px 8px;border-radius:4px;">
                    Pending
                </span>
            </td>

            <!-- ACTIONS -->
            <td style="padding:10px; border:1px solid #ddd;">

                <!-- VIEW PROFILE -->
                <a href="{{ route('admin.national.pastoral.approvals.view', $p->id) }}"
                   style="background:#03A9F4;color:#fff;padding:5px 8px;border-radius:4px;text-decoration:none;">
                    View
                </a>

                <!-- APPROVE -->
                <form method="POST"
                      action="{{ route('admin.national.pastoral.approvals.approve', $p->id) }}"
                      style="display:inline-block;">

                    @csrf
                    <button style="background:#4CAF50;color:#fff;border:none;padding:5px 8px;border-radius:4px;">
                        Approve
                    </button>

                </form>

                <!-- REJECT -->
                <form method="POST"
                      action="{{ route('admin.national.pastoral.approvals.reject', $p->id) }}"
                      style="display:inline-block;">

                    @csrf
                    <button onclick="return confirm('Reject this pastor?')"
                            style="background:#F44336;color:#fff;border:none;padding:5px 8px;border-radius:4px;">
                        Reject
                    </button>

                </form>

            </td>

        </tr>
        @endforeach

    </tbody>

</table>

@endif

@endsection