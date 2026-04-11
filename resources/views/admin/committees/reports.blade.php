@extends('layouts.admin')

@section('content')

<h1 style="margin-bottom:20px;">{{ $committee->name }} - Reports</h1>

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <!-- Back to Committees -->
    <a href="{{ route('admin.committees.index') }}" style="
        background-color:#607D8B;
        color:#fff;
        padding:10px 16px;
        border-radius:6px;
        font-weight:bold;
        text-decoration:none;
        transition:0.3s;"
        onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
        &larr; Back to Committees
    </a>

    <!-- Upload Report -->
    <a href="{{ route('admin.committees.reports.create', $committee->id) }}" style="
        background-color:#9C27B0;
        color:#fff;
        padding:10px 16px;
        border-radius:6px;
        font-weight:bold;
        text-decoration:none;
        transition:0.3s;"
        onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
        + Upload Report
    </a>
</div>

@if(session('success'))
    <div style="margin-bottom:20px; padding:10px 15px; background:#d4edda; color:#155724; border-radius:6px;">
        {{ session('success') }}
    </div>
@endif

<table style="width:100%; border-collapse:collapse; box-shadow:0 2px 8px rgba(0,0,0,0.1);">
    <thead>
        <tr style="background:#f5f5f5; text-align:left;">
            <th style="padding:10px; border:1px solid #ddd;">#</th>
            <th style="padding:10px; border:1px solid #ddd;">Title</th>
            <th style="padding:10px; border:1px solid #ddd;">Attachment</th>
            <th style="padding:10px; border:1px solid #ddd;">Description</th>
            <th style="padding:10px; border:1px solid #ddd;">Report Date</th>
            <th style="padding:10px; border:1px solid #ddd;">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($committee->reports as $index => $report)
        <tr>
            <td style="padding:10px; border:1px solid #ddd;">{{ $index + 1 }}</td>
            <td style="padding:10px; border:1px solid #ddd;">{{ $report->title }}</td>
            <td style="padding:10px; border:1px solid #ddd;">
                @if($report->attachment)
                    <a href="{{ asset('storage/'.$report->attachment) }}" target="_blank" style="color:#2196F3; text-decoration:underline;">View File</a>
                @else
                    -
                @endif
            </td>
            <td style="padding:10px; border:1px solid #ddd;">{{ $report->description ?? '-' }}</td>
            <td style="padding:10px; border:1px solid #ddd;">{{ $report->report_date ?? '-' }}</td>
            <td style="padding:10px; border:1px solid #ddd;">
                <!-- Edit -->
                <a href="{{ route('admin.committees.reports.edit', [$committee->id, $report->id]) }}" style="margin-right:5px; color:#fff; background:#FFC107; padding:4px 8px; border-radius:4px; text-decoration:none;">Edit</a>
                
                <!-- Delete -->
                <form action="{{ route('admin.committees.reports.destroy', [$committee->id, $report->id]) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Delete this report?');" style="color:#fff; background:#F44336; padding:4px 8px; border:none; border-radius:4px; cursor:pointer;">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" style="padding:10px; text-align:center; color:#888;">No reports uploaded yet.</td>
        </tr>
        @endforelse
    </tbody>
</table>

<!-- Pagination -->
@if($committee->reports instanceof \Illuminate\Pagination\LengthAwarePaginator)
    <div style="margin-top:15px;">
        {{ $committee->reports->links() }}
    </div>
@endif

@endsection