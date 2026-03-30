@extends('layouts.admin')

@section('title', 'Church Profile')

@section('content')
<!-- Back to Dashboard -->
<a href="{{ route('admin.dashboard') }}" style="padding:8px 12px; background:#2196F3; color:#fff; border-radius:6px; text-decoration:none; margin-bottom:15px; display:inline-block;">
    &larr; Back to Dashboard
</a>
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h1>Church Profile Overview</h1>
    <a href="{{ route('admin.church-profile.edit') }}" class="btn btn-primary">
        Edit Profile
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@php
    $profile = \App\Models\ChurchProfile::first();
@endphp

@if($profile)
    <div class="dashboard-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
        <!-- Motto -->
        <div class="card p-3 shadow-sm">
            <h3>Motto</h3>
            <p>{{ $profile->motto }}</p>
        </div>

        <!-- Vision -->
        <div class="card p-3 shadow-sm">
            <h3>Vision</h3>
            <p>{{ $profile->vision }}</p>
        </div>

        <!-- Mission -->
        <div class="card p-3 shadow-sm">
            <h3>Mission</h3>
            <p>{{ $profile->mission }}</p>
        </div>

        <!-- Core Values -->
        <div class="card p-3 shadow-sm">
            <h3>Core Values</h3>
            <p>{!! nl2br(e($profile->core_values)) !!}</p>
        </div>

        <!-- Statement of Faith -->
        <div class="card p-3 shadow-sm">
            <h3>Statement of Faith</h3>
            <p>{!! nl2br(e($profile->statement_of_faith)) !!}</p>
        </div>

        <!-- Overview -->
        <div class="card p-3 shadow-sm">
            <h3>Overview</h3>
            <p>{!! nl2br(e($profile->overview)) !!}</p>
        </div>

        <!-- Brief History -->
        <div class="card p-3 shadow-sm">
            <h3>Brief History</h3>
            <p>{!! nl2br(e($profile->history)) !!}</p>
        </div>
    </div>
@else
    <div class="alert alert-info">
        No church profile found. <a href="{{ route('admin.church-profile.create') }}" class="alert-link">Create one now</a>.
    </div>
@endif

@endsection
