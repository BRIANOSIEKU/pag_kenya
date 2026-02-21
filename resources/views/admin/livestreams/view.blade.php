@extends('layouts.admin')

@section('content')
<h1>Current Live Stream</h1>

@if($currentStream)
    <h2>{{ $currentStream->title }}</h2>

    @if($currentStream->logo)
        <img src="{{ asset('storage/'.$currentStream->logo) }}" width="120" style="margin-bottom:10px;">
    @endif

    @if($currentStream->type === 'radio')
        <audio controls autoplay>
            <source src="{{ $currentStream->url }}" type="audio/mpeg">
            Your browser does not support the audio element.
        </audio>
    @else
        <iframe src="{{ $currentStream->url }}" width="100%" height="400" frameborder="0" allowfullscreen></iframe>
    @endif

@else
    <p>No live stream is currently active.</p>
@endif
@endsection