@extends('layouts.admin')

@section('content')
<h1>Hero Slides & Theme of the Year</h1>
<hr><br>

<!-- ================= THEME & SCRIPTURE ================= -->
<div class="card" style="margin-bottom:20px;">
    <h3>Current Theme & Scripture</h3>
    @if($setting) {{-- updated variable from controller --}}
        <p><strong>Theme:</strong> {{ $setting->theme }}</p>
        <p><strong>Scripture:</strong> {{ $setting->scripture }}</p>
        <a href="{{ route('admin.hero.edit', $setting->id) }}" style="background-color:#4CAF50; color:#fff; padding:6px 12px; border-radius:5px; text-decoration:none;">Edit Theme & Scripture</a>
    @else
        <p>No theme set yet.</p>
        <a href="{{ route('admin.hero.create') }}" style="background-color:#4CAF50; color:#fff; padding:6px 12px; border-radius:5px; text-decoration:none;">Add Theme & Scripture</a>
    @endif
</div>

<!-- ================= HERO SLIDES ================= -->
<div class="card">
    <h3>Hero Slides</h3>

    <a href="{{ route('admin.hero-slides.create') }}" style="background-color:#009688; color:#fff; margin-bottom:10px; display:inline-block; padding:6px 12px; border-radius:5px; text-decoration:none;">
        + Add New Slide
    </a>

    @if(isset($slides) && $slides->isNotEmpty())
        <table style="width:100%; border-collapse:collapse; margin-top:10px;">
            <thead>
                <tr style="background:#f1f1f1;">
                    <th style="padding:8px; text-align:left;">#</th>
                    <th style="padding:8px; text-align:left;">Title / Caption</th>
                    <th style="padding:8px; text-align:left;">Image</th>
                    <th style="padding:8px; text-align:left;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($slides as $index => $slide)
                    <tr>
                        <td style="padding:8px;">{{ $index + 1 }}</td>
                        <td style="padding:8px;">{{ $slide->title ?? 'No caption' }}</td>
                        <td style="padding:8px;">
                            @if($slide->image)
                                <img src="{{ asset('storage/' . $slide->image) }}" alt="Slide Image" style="width:120px; border-radius:6px;">
                            @else
                                No Image
                            @endif
                        </td>
                        <td style="padding:8px;">
                            <a href="{{ route('admin.hero-slides.edit', $slide->id) }}" style="background:#4CAF50; color:#fff; padding:4px 8px; border-radius:4px; text-decoration:none;">Edit</a>

                            <form action="{{ route('admin.hero-slides.destroy', $slide->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure?')" style="background:#f44336; color:#fff; padding:4px 8px; border-radius:4px; border:none; cursor:pointer;">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No slides added yet.</p>
    @endif
</div>
@endsection