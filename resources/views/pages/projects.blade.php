@extends('layouts.app') <!-- Assuming your public layout is app.blade.php -->

@section('content')
<h2 style="text-align:center; margin-bottom:20px;">Our Projects</h2>

<div style="display:flex; flex-wrap:wrap; gap:20px; justify-content:center;">
    @forelse($projects as $project)
    <div style="border:1px solid #ddd; border-radius:8px; width:250px; overflow:hidden; text-align:center; box-shadow:0 2px 6px rgba(0,0,0,0.1); transition:transform 0.3s;" 
         onmouseover="this.style.transform='scale(1.05)'" 
         onmouseout="this.style.transform='scale(1)'">
        <a href="{{ route('projects.public.show', $project->id) }}" style="text-decoration:none; color:inherit;">
            @if($project->image)
                <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}" style="width:100%; height:200px; object-fit:cover;">
            @endif
            <h3 style="padding:10px 0; font-size:1.2rem;">{{ $project->title }}</h3>
        </a>
    </div>
    @empty
    <p style="text-align:center; width:100%;">No projects available at the moment.</p>
    @endforelse
</div>
@endsection
