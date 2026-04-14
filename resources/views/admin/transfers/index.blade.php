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


<h2 style="margin-bottom:15px;">Pending Transfer Requests (HQ Comparison View)</h2>

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

<div style="background:#fff;border:1px solid #e5e5e5;border-radius:10px;padding:18px;margin-bottom:20px;box-shadow:0 2px 8px rgba(0,0,0,0.05);">

    {{-- ================= PASTOR HEADER ================= --}}
    <div style="display:flex;gap:18px;align-items:center;border-bottom:1px solid #eee;padding-bottom:15px;margin-bottom:15px;">

        <div>
            @if($transfer->pastor->photo)
                <img src="{{ asset('storage/' . $transfer->pastor->photo) }}"
                     style="width:100px;height:100px;border-radius:10px;object-fit:cover;border:1px solid #ddd;">
            @else
                <div style="width:100px;height:100px;border-radius:10px;background:#ddd;"></div>
            @endif
        </div>

        <div style="flex:1;">
            <h3 style="margin:0;font-size:18px;">
                {{ $transfer->pastor->name ?? 'N/A' }}
            </h3>

            {{-- ================= DISTRICT + ASSEMBLY INFO ================= --}}
            <div style="font-size:13px;color:#444;margin-top:6px;line-height:1.6;">

                <div>
                    <b>Current:</b>
                    {{ $transfer->fromDistrict->name ?? 'N/A' }} /
                    {{ $transfer->fromAssembly->name ?? 'N/A' }}
                </div>

                <div>
                    <b>Target:</b>
                    {{ $transfer->toDistrict->name ?? 'N/A' }} /
                    {{ $transfer->toAssembly->name ?? 'N/A' }}
                </div>

            </div>
        </div>

    </div>


    {{-- ================= CURRENT ASSEMBLY ================= --}}
    <div style="margin-bottom:15px;">
        <h4 style="font-size:14px;margin-bottom:8px;color:#2c3e50;">
            Current Assembly Performance (Last 4 Months)
        </h4>

        @if(isset($transfer->currentAssemblyPerformance) && $transfer->currentAssemblyPerformance->count())

            <table style="width:100%;border-collapse:collapse;font-size:13px;">
                <thead>
                    <tr style="background:#f1f1f1;">
                        <th style="padding:8px;border:1px solid #ddd;text-align:left;">Month</th>
                        <th style="padding:8px;border:1px solid #ddd;text-align:left;">Tithe (KES)</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($transfer->currentAssemblyPerformance as $perf)
                        <tr>
                            <td style="padding:8px;border:1px solid #ddd;">
                                {{ $perf->month ?? '' }} {{ $perf->year ?? '' }}
                            </td>
                            <td style="padding:8px;border:1px solid #ddd;">
                                {{ number_format($perf->total ?? 0) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        @else
            <span style="color:#888;font-size:13px;">No current assembly performance data.</span>
        @endif
    </div>


    {{-- ================= TARGET ASSEMBLY ================= --}}
    <div style="margin-bottom:15px;">
        <h4 style="font-size:14px;margin-bottom:8px;color:#27ae60;">
            Target Assembly Performance (Last 4 Months)
        </h4>

        @if(isset($transfer->targetAssemblyPerformance) && $transfer->targetAssemblyPerformance->count())

            <table style="width:100%;border-collapse:collapse;font-size:13px;">
                <thead>
                    <tr style="background:#f1f1f1;">
                        <th style="padding:8px;border:1px solid #ddd;text-align:left;">Month</th>
                        <th style="padding:8px;border:1px solid #ddd;text-align:left;">Tithe (KES)</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($transfer->targetAssemblyPerformance as $perf)
                        <tr>
                            <td style="padding:8px;border:1px solid #ddd;">
                                {{ $perf->month ?? '' }} {{ $perf->year ?? '' }}
                            </td>
                            <td style="padding:8px;border:1px solid #ddd;">
                                {{ number_format($perf->total ?? 0) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        @else
            <span style="color:#888;font-size:13px;">No target assembly performance data.</span>
        @endif
    </div>


    {{-- ================= ACTIONS ================= --}}
    <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;border-top:1px solid #eee;padding-top:12px;">

        <form method="POST" action="{{ route('admin.transfers.approve', $transfer->id) }}">
            @csrf
            <button type="submit"
                    style="background:#28a745;color:#fff;border:none;padding:10px 14px;border-radius:6px;font-weight:bold;">
                Approve (HQ)
            </button>
        </form>

        <form method="POST"
              action="{{ route('admin.transfers.reject', $transfer->id) }}"
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

</div>

@empty
    <p>No pending transfers found.</p>
@endforelse

@endsection