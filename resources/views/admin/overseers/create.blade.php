@extends('layouts.admin')

@section('content')

<h2>Add New Overseer</h2>

@if ($errors->any())
    <div style="color:red; margin-bottom:15px;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.overseers.store') }}" method="POST" enctype="multipart/form-data">

    @csrf

    <div style="margin-bottom:15px;">
        <label>Name</label><br>
        <input type="text" name="name" value="{{ old('name') }}" required
               style="width:100%; padding:8px;">
    </div>

    <div style="margin-bottom:15px;">
        <label>District Name</label><br>
        <input type="text" name="district_name" value="{{ old('district_name') }}" required
               style="width:100%; padding:8px;">
    </div>

    <div style="margin-bottom:15px;">
        <label>Email (Optional)</label><br>
        <input type="email" name="email" value="{{ old('email') }}"
               style="width:100%; padding:8px;">
    </div>

    <div style="margin-bottom:15px;">
        <label>Phone (Optional)</label><br>
        <input type="text" name="phone" value="{{ old('phone') }}"
               style="width:100%; padding:8px;">
    </div>

    <div style="margin-bottom:15px;">
        <label>Gender</label><br>
        <select name="gender" required style="width:100%; padding:8px;">
            <option value="">-- Select Gender --</option>
            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
        </select>
    </div>

    <div style="margin-bottom:20px;">
        <label>Photo (Optional)</label><br>
        <input type="file" name="photo" accept="image/*">
    </div>

    <button type="submit"
            style="background:#2196F3;color:#fff;padding:10px 20px;border:none;border-radius:6px;font-weight:bold;">
        Save Overseer
    </button>

    <a href="{{ route('admin.overseers.index') }}"
       style="margin-left:10px;text-decoration:none;color:#555;">
        Cancel
    </a>

</form>

@endsection