@extends('layouts.district_admin')

@section('content')

<div style="max-width:600px;margin:auto;background:#fff;padding:20px;border-radius:10px;">

    <h2>Member Profile</h2>

    <p><strong>Name:</strong> {{ $member->name }}</p>
    <p><strong>Gender:</strong> {{ $member->gender }}</p>
    <p><strong>Contact:</strong> {{ $member->contact }}</p>

</div>

@endsection