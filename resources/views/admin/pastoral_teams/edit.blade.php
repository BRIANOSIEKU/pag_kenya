@extends('layouts.admin')

@section('content')
<div style="max-width:700px; margin:auto; padding:20px;">

<h2>Edit Pastoral Team Member</h2>

<form action="{{ route('admin.pastoral-teams.update', $team->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <input type="text" name="name" placeholder="Full Name" value="{{ old('name', $team->name) }}" required><br><br>

    <label>Select District</label><br>
    <select name="district_name" required>
        <option value="" disabled>-- Select District --</option>
        @foreach($districts as $district)
            <option value="{{ $district }}" {{ old('district_name', $team->district_name) == $district ? 'selected' : '' }}>
                {{ $district }}
            </option>
        @endforeach
    </select><br><br>

    <input type="text" name="assembly_name" placeholder="Assembly Name" value="{{ old('assembly_name', $team->assembly_name) }}" required><br><br>

    <input type="text" name="role" placeholder="Role" value="{{ old('role', $team->role) }}"><br><br>
    <input type="text" name="phone" placeholder="Phone" value="{{ old('phone', $team->phone) }}"><br><br>
    <input type="email" name="email" placeholder="Email" value="{{ old('email', $team->email) }}"><br><br>

    @if($team->photo)
        <img src="{{ asset('storage/'.$team->photo) }}" width="80" height="80" style="border-radius:50%; object-fit:cover;"><br><br>
    @endif
    <input type="file" name="photo"><br><br>

    <button type="submit">Update</button>
</form>
</div>
@endsection