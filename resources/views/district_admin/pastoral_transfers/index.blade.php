@extends('layouts.district_admin')

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

   <a href="{{ route('district.admin.dashboard') }}" class="btn-back">
            ← Back to Dashboard
        </a>

<div style="max-width:1200px;margin:auto;">

    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
        <h2>Pastoral Transfers</h2>

        <a href="{{ route('district.admin.pastoral.transfers.create') }}"
           style="padding:10px 15px;background:#28a745;color:#fff;border-radius:6px;text-decoration:none;">
           + New Transfer
        </a>
    </div>

    {{-- Messages --}}
    @if(session('success'))
        <div style="background:#d4edda;padding:10px;color:#155724;margin-bottom:10px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background:#f8d7da;padding:10px;color:#721c24;margin-bottom:10px;">
            {{ session('error') }}
        </div>
    @endif


    <table style="width:100%;border-collapse:collapse;background:#fff;box-shadow:0 2px 10px rgba(0,0,0,0.05);">

        <thead style="background:#343a40;color:#fff;">
            <tr>
                <th style="padding:10px;">Pastor</th>
                <th>From</th>
                <th>To</th>
                <th>Approval Status</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>

        @forelse($transfers as $transfer)

            @php
                $isSameDistrict = $transfer->from_district_id == $transfer->to_district_id;

                $canDownloadLetter =
                    (
                        $isSameDistrict && $transfer->status === 'approved'
                    )
                    ||
                    (
                        !$isSameDistrict &&
                        $transfer->to_district_approved &&
                        $transfer->status === 'approved'
                    );
            @endphp

            <tr style="border-bottom:1px solid #eee;">

                {{-- PASTOR --}}
                <td style="padding:10px;">
                    {{ $transfer->pastor->name ?? 'N/A' }}
                </td>

                {{-- FROM --}}
                <td>
                    {{ $transfer->fromDistrict->name ?? '' }} /
                    {{ $transfer->fromAssembly->name ?? '' }}
                </td>

                {{-- TO --}}
                <td>
                    {{ $transfer->toDistrict->name ?? '' }} /
                    {{ $transfer->toAssembly->name ?? '' }}
                </td>

                {{-- APPROVAL STATUS --}}
                <td style="font-size:12px;">

                    @if($isSameDistrict)

                        <div>
                            Final Status:
                            @if($transfer->status == 'approved')
                                <span style="color:green;">Approved</span>
                            @elseif($transfer->status == 'rejected')
                                <span style="color:red;">Rejected</span>
                            @else
                                <span style="color:orange;">Pending Main Office</span>
                            @endif
                        </div>

                    @else

                        <div>
                            District Approval:
                            @if($transfer->to_district_approved)
                                <span style="color:green;">✔ Approved</span>
                            @else
                                <span style="color:orange;">Pending</span>
                            @endif
                        </div>

                        <div>
                            Final (Main Office):
                            @if($transfer->status == 'approved')
                                <span style="color:green;">Approved</span>
                            @elseif($transfer->status == 'rejected')
                                <span style="color:red;">Rejected</span>
                            @else
                                <span style="color:orange;">Pending</span>
                            @endif
                        </div>

                    @endif

                    {{-- REJECTION REASON --}}
                    @if($transfer->status == 'rejected' && $transfer->rejection_reason)
                        <div style="margin-top:5px;font-size:11px;color:red;">
                            {{ $transfer->rejection_reason }}
                        </div>
                    @endif

                </td>

                {{-- ACTIONS --}}
                <td>

                    {{-- PENDING STATE --}}
                    @if($transfer->status == 'pending')

                        <a href="{{ route('district.admin.pastoral.transfers.edit', $transfer->id) }}"
                           style="padding:5px 10px;background:#007bff;color:#fff;text-decoration:none;border-radius:4px;font-size:12px;">
                            Edit
                        </a>

                        <form method="POST"
                              action="{{ route('district.admin.pastoral.transfers.destroy', $transfer->id) }}"
                              style="display:inline-block;"
                              onsubmit="return confirm('Delete this transfer?')">

                            @csrf
                            @method('DELETE')

                            <button style="background:#dc3545;color:#fff;border:none;padding:5px 10px;border-radius:4px;font-size:12px;">
                                Delete
                            </button>

                        </form>

                    @else

                        {{-- APPROVED → DOWNLOAD LETTER --}}
                        @if($canDownloadLetter)

                            <a href="{{ route('district.admin.pastoral.transfers.download', $transfer->id) }}"
                               style="padding:5px 10px;background:#28a745;color:#fff;text-decoration:none;border-radius:4px;font-size:12px;">
                                Download Letter
                            </a>

                        @else

                            <em style="color:#888;font-size:12px;">Locked</em>

                        @endif

                    @endif

                </td>

            </tr>

        @empty

            <tr>
                <td colspan="5" style="text-align:center;padding:20px;">
                    No transfers found
                </td>
            </tr>

        @endforelse

        </tbody>

    </table>

</div>

@endsection