@extends('layouts.admin')

@section('content')

<h1>District Leadership - {{ $district->name }}</h1>

<a href="{{ route('admin.districts.leadership.create', $district->id) }}"
   style="padding:8px 12px; background:#4CAF50; color:#fff; border-radius:6px; text-decoration:none; display:inline-block; margin-bottom:15px;">
    + Add Leader
</a>

@if(session('success'))
<div style="margin:10px 0; padding:10px; background:#d4edda; color:#155724; border-radius:6px;">
    {{ session('success') }}
</div>
@endif

<table style="width:100%; border-collapse:collapse; box-shadow:0 2px 8px rgba(0,0,0,0.1);">
    <thead>
        <tr style="background:#f5f5f5;">
            <th style="padding:10px; border:1px solid #ddd;">Photo</th>
            <th style="padding:10px; border:1px solid #ddd;">Name</th>
            <th style="padding:10px; border:1px solid #ddd;">Position</th> <!-- NEW -->
            <th style="padding:10px; border:1px solid #ddd;">Contact</th>
            <th style="padding:10px; border:1px solid #ddd;">Gender</th>
            <th style="padding:10px; border:1px solid #ddd;">Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach($leaders as $leader)
        <tr>
            <td style="padding:10px; border:1px solid #ddd;">
                @if($leader->photo)
                    <img src="{{ asset('storage/'.$leader->photo) }}" width="50" height="50" style="border-radius:50%;">
                @else
                    N/A
                @endif
            </td>

            <td style="padding:10px; border:1px solid #ddd;">
                {{ $leader->name }}
            </td>

            <td style="padding:10px; border:1px solid #ddd; font-weight:600; color:#003366;">
                {{ $leader->position ?? 'N/A' }}
            </td>

            <td style="padding:10px; border:1px solid #ddd;">
                {{ $leader->contact }}
            </td>

            <td style="padding:10px; border:1px solid #ddd;">
                {{ $leader->gender }}
            </td>

            <td style="padding:10px; border:1px solid #ddd;">

                <a href="{{ route('admin.districts.leadership.show', [$district->id, $leader->id]) }}"
                   style="background:#03A9F4; color:#fff; padding:4px 8px; border-radius:4px; text-decoration:none;">
                    View
                </a>

                <a href="{{ route('admin.districts.leadership.edit', [$district->id, $leader->id]) }}"
                   style="background:#FFC107; color:#fff; padding:4px 8px; border-radius:4px; text-decoration:none;">
                    Edit
                </a>

                <form action="{{ route('admin.districts.leadership.destroy', [$district->id, $leader->id]) }}"
                      method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')

                    <button onclick="return confirm('Delete leader?')"
                            style="background:#F44336; color:#fff; padding:4px 8px; border:none; border-radius:4px;">
                        Delete
                    </button>
                </form>

            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection