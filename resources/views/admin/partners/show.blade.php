@extends('layouts.admin')

@section('content')

<h2>{{ $partner->name }}</h2>

@if($partner->logo)
    <img src="{{ asset('storage/'.$partner->logo) }}" 
         style="max-width:300px;margin-bottom:20px;">
@endif

<p>{{ $partner->description }}</p>

<br>

<a href="{{ route('admin.partners.edit', $partner) }}">Edit</a> |
<a href="{{ route('admin.partners.index') }}">Back</a>

@endsection
