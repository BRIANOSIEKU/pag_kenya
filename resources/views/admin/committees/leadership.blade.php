@extends('layouts.admin')

@section('content')

<div class="container" style="max-width:1100px; margin:auto; padding:20px;">

    <h1 style="margin-bottom:20px;">{{ $committee->name }} - Leadership</h1>

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:10px;">

        <a href="{{ route('admin.committees.index') }}" style="
            background-color:#607D8B;
            color:#fff;
            padding:10px 16px;
            border-radius:6px;
            font-weight:bold;
            text-decoration:none;
            transition:0.3s;
            display:inline-block;
        " onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
            &larr; Back to Committees
        </a>

        <a href="{{ route('admin.committees.leadership.create', $committee->id) }}" style="
            background-color:#9C27B0;
            color:#fff;
            padding:10px 16px;
            border-radius:6px;
            font-weight:bold;
            text-decoration:none;
            transition:0.3s;
            display:inline-block;
        " onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
            + Add Leader
        </a>

    </div>

    @if(session('success'))
        <div style="margin-bottom:20px; padding:10px 15px; background:#d4edda; color:#155724; border-radius:6px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="overflow-x:auto;">
        <table style="width:100%; border-collapse:collapse; box-shadow:0 2px 8px rgba(0,0,0,0.1); background:#fff;">

            <thead>
                <tr style="background:#f5f5f5; text-align:left;">
                    <th style="padding:10px; border:1px solid #ddd;">#</th>
                    <th style="padding:10px; border:1px solid #ddd;">Photo</th>
                    <th style="padding:10px; border:1px solid #ddd;">Name</th>
                    <th style="padding:10px; border:1px solid #ddd;">Role</th>
                    <th style="padding:10px; border:1px solid #ddd;">Contact</th>
                    <th style="padding:10px; border:1px solid #ddd;">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($committee->leaders as $index => $leader)
                <tr>
                    <td style="padding:10px; border:1px solid #ddd;">{{ $index + 1 }}</td>

                    <!-- Photo -->
                    <td style="padding:10px; border:1px solid #ddd; text-align:center;">
                        @php
                            $pivotPhoto = $leader->pivot->photo ?? null;
                            $photoUrl = $pivotPhoto ? asset('storage/leaders_photos/'.$pivotPhoto) : null;
                        @endphp

                        @if($photoUrl)
                            <img src="{{ $photoUrl }}" alt="{{ $leader->name }}"
                                 style="width:60px; height:60px; object-fit:cover; border-radius:50%;">
                        @else
                            <div style="width:60px; height:60px; border-radius:50%; background:#e0e0e0;
                                        display:flex; align-items:center; justify-content:center; color:#888;">
                                N/A
                            </div>
                        @endif
                    </td>

                    <!-- Name -->
                    <td style="padding:10px; border:1px solid #ddd;">{{ $leader->name }}</td>

                    <!-- Role -->
                    <td style="padding:10px; border:1px solid #ddd;">{{ $leader->pivot->role ?? '-' }}</td>

                    <!-- Contact -->
                    <td style="padding:10px; border:1px solid #ddd;">{{ $leader->pivot->contact ?? '-' }}</td>

                    <!-- Actions -->
                    <td style="padding:10px; border:1px solid #ddd; white-space:nowrap;">
                        <a href="{{ route('admin.committees.leadership.edit', [$committee->id, $leader->id]) }}"
                           style="margin-right:5px; color:#fff; background:#FFC107; padding:4px 8px; border-radius:4px; text-decoration:none;">
                            Edit
                        </a>

                        <form action="{{ route('admin.committees.leadership.destroy', [$committee->id, $leader->id]) }}"
                              method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    onclick="return confirm('Delete this leader?');"
                                    style="color:#fff; background:#F44336; padding:4px 8px; border:none; border-radius:4px; cursor:pointer;">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding:10px; text-align:center; color:#888;">
                        No leaders assigned yet.
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

    <!-- Pagination -->
    @if($committee->leaders instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div style="margin-top:15px;">
            {{ $committee->leaders->links() }}
        </div>
    @endif

</div>

@endsection