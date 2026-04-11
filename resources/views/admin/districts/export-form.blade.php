@extends('layouts.admin')

@section('content')

<h2>Export District Leadership Report</h2>

<form action="{{ route('admin.districts.export.pdf') }}" method="POST">
    @csrf

    <label>Select Position</label><br>

    <select name="category" required style="padding:8px; margin:10px 0; width:300px;">
        <option value="">-- Select Position --</option>

        <option value="Overseer">Overseer</option>
        <option value="Secretary">Secretary</option>
        <option value="CEYD">CEYD</option>
        <option value="Women Director">Women Director</option>
        <option value="LayPerson">LayPerson</option>
        <option value="Treasurer">Treasurer</option>
        <option value="Senior Pastor">Senior Pastor</option>

    </select>

    <br><br>

    <button type="submit"
        style="padding:10px 15px; background:green; color:white; border:none; border-radius:6px;">
        Download PDF
    </button>

</form>

@endsection