@extends('layouts.admin')

@section('content')

<h1 style="margin-bottom:20px;">Upload Report for {{ $committee->name }}</h1>

<div style="margin-bottom:20px;">
    <a href="{{ route('admin.committees.reports.list', $committee->id) }}" style="
        background-color:#607D8B;
        color:#fff;
        padding:10px 16px;
        border-radius:6px;
        font-weight:bold;
        text-decoration:none;
        transition:0.3s;
    " onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
        &larr; Back to Reports
    </a>
</div>

@if ($errors->any())
    <div style="margin-bottom:20px; padding:10px 15px; background:#f8d7da; color:#721c24; border-radius:6px;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.committees.reports.store', $committee->id) }}" method="POST" enctype="multipart/form-data" style="max-width:600px;">
    @csrf

    <div style="margin-bottom:15px;">
        <label for="title" style="font-weight:bold;">Title</label><br>
        <input type="text" name="title" id="title" required style="width:100%; padding:8px; border-radius:4px; border:1px solid #ccc;">
    </div>

    <div style="margin-bottom:15px;">
        <label for="description" style="font-weight:bold;">Description</label><br>
        <textarea name="description" id="description" rows="4" style="width:100%; padding:8px; border-radius:4px; border:1px solid #ccc;"></textarea>
    </div>

    <div style="margin-bottom:15px;">
        <label for="report_date" style="font-weight:bold;">Report Date</label><br>
        <input type="date" name="report_date" id="report_date" required style="padding:8px; border-radius:4px; border:1px solid #ccc;">
    </div>

    <div style="margin-bottom:20px;">
        <label for="attachment" style="font-weight:bold;">Attachment (PDF/DOCX)</label><br>
        <input type="file" name="attachment" id="attachment" accept=".pdf,.doc,.docx" style="padding:6px;">
    </div>

    <button type="submit" style="
        background-color:#9C27B0;
        color:#fff;
        padding:10px 20px;
        border:none;
        border-radius:6px;
        font-weight:bold;
        cursor:pointer;
        transition:0.3s;
    " onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
        Upload Report
    </button>
</form>

@endsection