@extends('layouts.district_admin')

@section('content')

<h2 style="margin-bottom:15px;">Incoming Transfer Requests</h2>

@if(session('success'))
    <div style="background:#d4edda;padding:10px;color:#155724;margin-bottom:10px;border-radius:6px;">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div style="background:#f8d7da;padding:10px;color:#721c24;margin-bottom:10px;border-radius:6px;">
        {{ session('error') }}
    </div>
@endif


@forelse($transfers as $transfer)

<div style="
    background:#fff;
    border:1px solid #e5e5e5;
    border-radius:10px;
    padding:18px;
    margin-bottom:18px;
    box-shadow:0 2px 8px rgba(0,0,0,0.05);
">

    {{-- TOP SECTION --}}
    <div style="display:flex;gap:18px;align-items:center;border-bottom:1px solid #eee;padding-bottom:15px;margin-bottom:15px;">

        {{-- PHOTO --}}
        <div>
            @if($transfer->pastor->photo)
                <img src="{{ asset('storage/' . $transfer->pastor->photo) }}"
                     style="width:100px;height:100px;border-radius:10px;object-fit:cover;border:1px solid #ddd;">
            @else
                <div style="width:100px;height:100px;border-radius:10px;background:#ddd;"></div>
            @endif
        </div>

        {{-- NAME + BASIC INFO --}}
        <div style="flex:1;">

            <h3 style="margin:0;font-size:18px;">
                {{ $transfer->pastor->name ?? 'N/A' }}
            </h3>

            <div style="margin-top:8px;display:grid;grid-template-columns:1fr 1fr;gap:6px;font-size:13px;color:#444;">

                <div><b>Gender:</b> {{ $transfer->pastor->gender }}</div>
                <div><b>Phone:</b> {{ $transfer->pastor->contact }}</div>
                <div><b>Date of Birth:</b> {{ $transfer->pastor->date_of_birth }}</div>
                <div><b>Graduation Year:</b> {{ $transfer->pastor->graduation_year }}</div>

            </div>

        </div>

    </div>


    {{-- TRANSFER INFO --}}
    <div style="margin-bottom:15px;">
        <h4 style="margin-bottom:6px;font-size:14px;">Transfer Details</h4>

        <div style="font-size:13px;line-height:1.6;color:#333;">
            <b>From:</b> {{ $transfer->fromDistrict->name ?? '' }} /
            {{ $transfer->fromAssembly->name ?? '' }} <br>

            <b>To:</b> {{ $transfer->toDistrict->name ?? '' }} /
            {{ $transfer->toAssembly->name ?? '' }}
        </div>

        <div style="margin-top:8px;">
            <b>Reason:</b>
            <div style="margin-top:3px;color:#555;">
                {{ $transfer->reason }}
            </div>
        </div>
    </div>


    {{-- ATTACHMENTS --}}
    <div style="margin-bottom:15px;">
        <h4 style="margin-bottom:6px;font-size:14px;">Credentials</h4>

        @if($transfer->pastor->attachments)
            @php
                $files = json_decode($transfer->pastor->attachments, true);
            @endphp

            <div style="font-size:13px;">
                @if(is_array($files))
                    @foreach($files as $file)
                        <div style="margin-bottom:4px;">
                            📎 <a href="{{ asset('storage/' . $file) }}" target="_blank">
                                View Credentials
                            </a>
                        </div>
                    @endforeach
                @else
                    📎 <a href="{{ asset('storage/' . $transfer->pastor->attachments) }}" target="_blank">
                        View Document
                    </a>
                @endif
            </div>

        @else
            <span style="color:#888;font-size:13px;">No credentials uploaded</span>
        @endif
    </div>


    {{-- ACTIONS --}}
    @if($transfer->status == 'pending')

        <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;border-top:1px solid #eee;padding-top:12px;">

            {{-- APPROVE --}}
            <form method="POST"
                  action="{{ route('district.admin.pastoral.transfers.approve', $transfer->id) }}">
                @csrf
                <button type="submit"
                        style="background:#28a745;color:#fff;border:none;padding:10px 14px;border-radius:6px;font-weight:bold;">
                    Approve
                </button>
            </form>

            {{-- REJECT --}}
            <form method="POST"
                  action="{{ route('district.admin.pastoral.transfers.reject', $transfer->id) }}"
                  style="display:flex;gap:8px;align-items:center;">
                @csrf

                <input type="text"
                       name="rejection_reason"
                       placeholder="Rejection reason..."
                       required
                       style="padding:8px;border:1px solid #ccc;border-radius:6px;width:220px;">

                <button type="submit"
                        style="background:#dc3545;color:#fff;border:none;padding:10px 14px;border-radius:6px;font-weight:bold;">
                    Reject
                </button>
            </form>

        </div>

    @else
        <div style="border-top:1px solid #eee;padding-top:10px;color:#777;font-size:13px;">
            This request has already been processed.
        </div>
    @endif

</div>

@empty
    <p>No incoming transfer requests found.</p>
@endforelse

@endsection