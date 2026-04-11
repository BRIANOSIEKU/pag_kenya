@extends('layouts.admin')

@section('content')
<h2>{{ $committee->name }} - Details</h2>

<div style="margin-bottom:20px;">
    <a href="{{ route('admin.committees.index') }}" class="btn-teal">Back to Committees</a>
    <a href="{{ route('admin.scommittees.edit', $committee->id) }}" class="btn-orange">Edit Committee</a>
</div>

<div class="card" style="margin-bottom:20px;">
    <h3>Overview</h3>
    <p>{{ $committee->overview }}</p>
</div>

<div class="card" style="margin-bottom:20px;">
    <h3>Chairperson</h3>
    <p>ID: {{ $committee->chairperson_id }}</p>
    <p>Gender: {{ $committee->chairperson_gender ?? 'N/A' }}</p>
    @if($committee->chairperson_photo)
        <img src="{{ asset('storage/'.$committee->chairperson_photo) }}" alt="Chairperson Photo" style="width:120px; height:auto;">
    @endif
</div>

<div class="card" style="margin-bottom:20px;">
    <h3>Secretary</h3>
    <p>ID: {{ $committee->secretary_id }}</p>
    <p>Gender: {{ $committee->secretary_gender ?? 'N/A' }}</p>
    @if($committee->secretary_photo)
        <img src="{{ asset('storage/'.$committee->secretary_photo) }}" alt="Secretary Photo" style="width:120px; height:auto;">
    @endif
</div>

<div class="card" style="margin-bottom:20px;">
    <h3>Duties & Functions</h3>
    <ul>
        @foreach($committee->duties as $duty)
            <li>{{ $duty->description }}</li>
        @endforeach
    </ul>
</div>

<div class="card" style="margin-bottom:20px;">
    <h3>Members</h3>
    <ul>
        @foreach($committee->members as $member)
            <li>{{ $member->name }} - {{ $member->gender }}</li>
        @endforeach
    </ul>
</div>

<div class="card" style="margin-bottom:20px;">
    <h3>Reports</h3>
    @foreach($committee->reports as $report)
        <div style="margin-bottom:10px; border-bottom:1px solid #ccc; padding-bottom:8px;">
            <strong>{{ $report->title }}</strong> <br>
            {{ $report->description }} <br>
            <em>{{ $report->date->format('d M Y') }}</em> <br>
            @if($report->attachment)
                <a href="{{ asset('storage/'.$report->attachment) }}" target="_blank">View Attachment</a>
            @endif
        </div>
    @endforeach
</div>
@endsection