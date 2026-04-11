@extends('layouts.district_admin')

@section('content')

<h2>Create Assembly</h2>

<form method="POST" action="{{ route('district.admin.assemblies.store') }}">
    @csrf

    <label>Assembly Name</label><br>
    <input type="text" name="name" required style="padding:8px;width:300px;"><br><br>

    <label>Physical Address</label><br>
    <input type="text" name="physical_address" required style="padding:8px;width:300px;"><br><br>

    <button type="submit"
        style="padding:10px 15px;background:#4CAF50;color:#fff;border:none;">
        Submit (Pending Approval)
    </button>
</form>

@endsection