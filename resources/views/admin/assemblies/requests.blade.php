@extends('layouts.admin')

@section('content')

<h2>New Assembly Requests</h2>

@if(session('success'))
    <div style="background:#d4edda;color:#155724;padding:10px;border-radius:6px;margin-bottom:15px;">
        {{ session('success') }}
    </div>
@endif

<!-- ================= SEARCH FILTER ================= -->
<form method="GET" action="{{ route('admin.assembly.requests') }}"
      style="margin-bottom:15px; display:flex; gap:10px;">

    <select name="district_id" style="padding:8px; width:250px;">
        <option value="">-- Filter by District --</option>

        @foreach($districts as $district)
            <option value="{{ $district->id }}"
                {{ request('district_id') == $district->id ? 'selected' : '' }}>
                {{ $district->name }}
            </option>
        @endforeach
    </select>

    <button type="submit"
            style="padding:8px 12px;background:#2196F3;color:#fff;border:none;border-radius:5px;">
        Search
    </button>

    <a href="{{ route('admin.assembly.requests') }}"
       style="padding:8px 12px;background:#607D8B;color:#fff;border-radius:5px;text-decoration:none;">
        Reset
    </a>

</form>

<!-- ================= TABLE ================= -->
<table style="width:100%;border-collapse:collapse;box-shadow:0 2px 10px rgba(0,0,0,0.1);">

    <thead>
        <tr style="background:#f5f5f5;">
            <th style="padding:10px;border:1px solid #ddd;">District</th>
            <th style="padding:10px;border:1px solid #ddd;">Proposed Assembly</th>
            <th style="padding:10px;border:1px solid #ddd;">Physical Address</th>
            <th style="padding:10px;border:1px solid #ddd;">Status</th>
            <th style="padding:10px;border:1px solid #ddd;">Actions</th>
        </tr>
    </thead>

    <tbody>
        @forelse($requests as $request)
        <tr>

            <!-- DISTRICT -->
            <td style="padding:10px;border:1px solid #ddd;">
                {{ $request->district->name ?? 'N/A' }}
            </td>

            <!-- ASSEMBLY NAME -->
            <td style="padding:10px;border:1px solid #ddd;">
                {{ $request->name }}
            </td>

            <!-- ADDRESS -->
            <td style="padding:10px;border:1px solid #ddd;">
                {{ $request->physical_address }}
            </td>

            <!-- STATUS -->
            <td style="padding:10px;border:1px solid #ddd;color:orange;font-weight:bold;">
                {{ ucfirst($request->status) }}
            </td>

            <!-- ACTIONS -->
            <td style="padding:10px;border:1px solid #ddd;">

                <!-- APPROVE -->
                <form action="{{ route('admin.assembly.approve', $request->id) }}"
                      method="POST"
                      style="display:inline-block;">
                    @csrf
                    <button style="background:#4CAF50;color:#fff;padding:6px 10px;border:none;border-radius:5px;">
                        Approve
                    </button>
                </form>

                <!-- REJECT -->
                <form action="{{ route('admin.assembly.reject', $request->id) }}"
                      method="POST"
                      style="display:inline-block;">
                    @csrf
                    <button style="background:#F44336;color:#fff;padding:6px 10px;border:none;border-radius:5px;">
                        Reject
                    </button>
                </form>

            </td>

        </tr>
        @empty
        <tr>
            <td colspan="5" style="padding:15px;text-align:center;">
                No pending assembly requests.
            </td>
        </tr>
        @endforelse
    </tbody>

</table>

@endsection