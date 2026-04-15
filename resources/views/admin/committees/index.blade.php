@extends('layouts.admin')

@section('content')

<!-- Back Button -->
<a href="{{ route('admin.dashboard') }}" style="
    padding:8px 12px;
    background:#607D8B;
    color:#fff;
    border-radius:6px;
    text-decoration:none;
    margin-bottom:20px;
    display:inline-block;
">
    &larr; Back to Dashboard
</a>

<div style="max-width:1200px; margin:auto; background:#fff; padding:25px; border-radius:10px; box-shadow:0 3px 10px rgba(0,0,0,0.08);">

    <h2 style="margin-bottom:15px; font-size:22px; font-weight:bold;">
        Committees
    </h2>

    <!-- Add Button -->
    <a href="{{ route('admin.committees.create') }}" style="
        display:inline-block;
        background:#4CAF50;
        color:#fff;
        padding:8px 12px;
        border-radius:6px;
        text-decoration:none;
        margin-bottom:15px;
    ">
        + Add Committee
    </a>

    @if(session('success'))
        <div style="background:#d4edda; color:#155724; padding:10px; border-radius:6px; margin-bottom:15px;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Search -->
    <form action="{{ route('admin.committees.index') }}" method="GET" style="display:flex; gap:10px; margin-bottom:20px; flex-wrap:wrap;">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search committee..."
            style="flex:1; min-width:200px; padding:8px; border:1px solid #ccc; border-radius:6px;">

        <button type="submit" style="
            background:#2196F3;
            color:#fff;
            border:none;
            padding:8px 14px;
            border-radius:6px;
            cursor:pointer;
        ">
            Search
        </button>
    </form>

    <div style="overflow-x:auto;">

        <table style="width:100%; border-collapse:collapse; min-width:800px;">

            <thead>
                <tr style="background:#f5f5f5;">
                    <th style="padding:10px; border:1px solid #ddd;">#</th>
                    <th style="padding:10px; border:1px solid #ddd;">Name</th>
                    <th style="padding:10px; border:1px solid #ddd;">Actions</th>
                </tr>
            </thead>

            <tbody>

                @forelse($committees as $index => $committee)
                    <tr>
                        <td style="padding:10px; border:1px solid #ddd;">
                            {{ $index + 1 }}
                        </td>

                        <td style="padding:10px; border:1px solid #ddd;">
                            {{ $committee->name }}
                        </td>

                        <td style="padding:10px; border:1px solid #ddd;">

                            <div style="display:flex; flex-wrap:wrap; gap:6px;">

                                <a href="{{ route('admin.committees.leadership', $committee->id) }}" style="
                                    background:#9C27B0;
                                    color:#fff;
                                    padding:5px 8px;
                                    border-radius:6px;
                                    text-decoration:none;
                                    font-size:13px;
                                ">Leadership</a>

                                <a href="{{ route('admin.committees.members.index', $committee->id) }}" style="
                                    background:#4CAF50;
                                    color:#fff;
                                    padding:5px 8px;
                                    border-radius:6px;
                                    text-decoration:none;
                                    font-size:13px;
                                ">Members</a>

                                <a href="{{ route('admin.committees.reports.index', $committee->id) }}" style="
                                    background:#FFC107;
                                    color:#000;
                                    padding:5px 8px;
                                    border-radius:6px;
                                    text-decoration:none;
                                    font-size:13px;
                                ">Reports</a>

                                <a href="{{ route('admin.committees.duties', $committee->id) }}" style="
                                    background:#3F51B5;
                                    color:#fff;
                                    padding:5px 8px;
                                    border-radius:6px;
                                    text-decoration:none;
                                    font-size:13px;
                                ">Duties</a>

                                <a href="{{ route('admin.committees.edit', $committee->id) }}" style="
                                    background:#2196F3;
                                    color:#fff;
                                    padding:5px 8px;
                                    border-radius:6px;
                                    text-decoration:none;
                                    font-size:13px;
                                ">Edit</a>

                            </div>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align:center; padding:20px; color:#777;">
                            No committees found.
                        </td>
                    </tr>
                @endforelse

            </tbody>

        </table>

    </div>

    @if(method_exists($committees, 'links'))
        <div style="margin-top:20px;">
            {{ $committees->links() }}
        </div>
    @endif

</div>

@endsection