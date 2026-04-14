@extends('layouts.admin')

@section('content')

<div class="export-wrapper">

    <div class="export-header">
        <h2>District Summary Export</h2>
        <p>Generate ranked assembly tithe report per district</p>
    </div>

    <div class="export-body">

        <div class="info-box">
            📌 This report ranks assemblies by tithe contribution within a selected district.
        </div>

        <form method="POST" action="{{ route('admin.export.district.generate') }}">
            @csrf

            <!-- DISTRICT -->
            <div class="form-group">
                <label>District</label>
                <select name="district_id" class="form-control" required>
                    @foreach($districts as $d)
                        <option value="{{ $d->id }}">{{ $d->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- YEAR -->
            <div class="form-group">
                <label>Year</label>
                <input type="number" name="year" class="form-control" required>
            </div>

            <!-- MONTH -->
            <div class="form-group">
                <label>Month</label>
                <select name="month" class="form-control" required>
                    @foreach([
                        'January','February','March','April','May','June',
                        'July','August','September','October','November','December'
                    ] as $month)
                        <option value="{{ $month }}">{{ $month }}</option>
                    @endforeach
                </select>
            </div>

            <!-- STATUS -->
            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control" required>
                    <option value="approved">Approved</option>
                </select>
            </div>

            <button class="btn-submit">Generate PDF</button>

        </form>

    </div>
</div>

@endsection