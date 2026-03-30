@extends('layouts.admin')

@section('content')
<h1>Edit Theme & Scripture</h1>
<hr><br>

<div class="card">
    <form action="{{ route('admin.hero.update', $setting->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="margin-bottom:15px;">
            <label for="theme" style="font-weight:bold;">Theme of the Year</label>
            <input type="text" name="theme" id="theme" value="{{ old('theme', $setting->theme) }}" 
                   style="width:100%; padding:8px; margin-top:5px; border-radius:6px; border:1px solid #ccc;">
            @error('theme')
                <div style="color:red; margin-top:5px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom:15px;">
            <label for="scripture" style="font-weight:bold;">Scripture of the Year</label>
            <input type="text" name="scripture" id="scripture" value="{{ old('scripture', $setting->scripture) }}" 
                   style="width:100%; padding:8px; margin-top:5px; border-radius:6px; border:1px solid #ccc;">
            @error('scripture')
                <div style="color:red; margin-top:5px;">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" 
                style="background-color:#4CAF50; color:#fff; padding:10px 18px; border-radius:6px; font-weight:bold;">
            Update
        </button>
        <a href="{{ route('admin.hero.index') }}" 
           style="background-color:#ccc; color:#333; padding:10px 18px; border-radius:6px; font-weight:bold; margin-left:10px;">
           Cancel
        </a>
    </form>
</div>
@endsection