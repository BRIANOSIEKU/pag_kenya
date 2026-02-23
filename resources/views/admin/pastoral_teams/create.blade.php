@extends('layouts.admin')

@section('content')
<div style="max-width:700px; margin:auto; padding:20px;">

<h2>Add Pastoral Team Member</h2>

<form action="{{ route('admin.pastoral-teams.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <input type="text" name="name" placeholder="Full Name" value="{{ old('name') }}" required><br><br>

    {{-- District Dropdown --}}
    <label>Select District</label><br>
    <select name="district_name" required>
        <option value="" disabled selected>-- Select District --</option>
        @foreach($districts as $district)
            <option value="{{ $district }}" {{ old('district_name') == $district ? 'selected' : '' }}>
                {{ $district }}
            </option>
        @endforeach
    </select><br><br>

    {{-- Assembly --}}
    <input type="text" name="assembly_name" placeholder="Assembly Name" value="{{ old('assembly_name') }}" required><br><br>

    <input type="text" name="role" placeholder="Role" value="{{ old('role') }}"><br><br>
    <input type="text" name="phone" placeholder="Phone" value="{{ old('phone') }}"><br><br>
    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}"><br><br>
    <input type="file" name="photo"><br><br>

    <button type="submit">Save</button>
</form>
</div>
@endsection