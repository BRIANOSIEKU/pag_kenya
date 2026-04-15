@extends('layouts.admin')

@section('title', 'Comments Moderation')

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

    <h2 style="margin-bottom:20px; font-size:22px; font-weight:bold;">
        Comments Moderation
    </h2>

    @if(session('success'))
        <div style="background:#d4edda; color:#155724; padding:10px; border-radius:6px; margin-bottom:15px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="overflow-x:auto;">

        <table style="width:100%; border-collapse:collapse; min-width:900px;">

            <thead>
                <tr style="background:#f5f5f5;">
                    <th style="padding:10px; border:1px solid #ddd;">#</th>
                    <th style="padding:10px; border:1px solid #ddd;">Devotion</th>
                    <th style="padding:10px; border:1px solid #ddd;">User</th>
                    <th style="padding:10px; border:1px solid #ddd;">Comment</th>
                    <th style="padding:10px; border:1px solid #ddd;">Status</th>
                    <th style="padding:10px; border:1px solid #ddd;">Admin Reply</th>
                    <th style="padding:10px; border:1px solid #ddd;">Actions</th>
                </tr>
            </thead>

            <tbody>

                @forelse($comments as $comment)
                    <tr>
                        <td style="padding:10px; border:1px solid #ddd;">{{ $comment->id }}</td>

                        <td style="padding:10px; border:1px solid #ddd;">
                            {{ $comment->devotion->title ?? 'N/A' }}
                        </td>

                        <td style="padding:10px; border:1px solid #ddd;">
                            <strong>{{ $comment->user->name ?? 'N/A' }}</strong><br>
                            <small>{{ $comment->user->email ?? '' }}</small>
                        </td>

                        <td style="padding:10px; border:1px solid #ddd;">
                            {{ $comment->comment }}
                        </td>

                        <td style="padding:10px; border:1px solid #ddd;">
                            @if($comment->admin_response)
                                <span style="background:#4CAF50; color:#fff; padding:4px 8px; border-radius:4px; font-size:12px;">
                                    Replied
                                </span>
                            @else
                                <span style="background:#FFC107; color:#000; padding:4px 8px; border-radius:4px; font-size:12px;">
                                    Pending
                                </span>
                            @endif
                        </td>

                        <td style="padding:10px; border:1px solid #ddd;">
                            {{ $comment->admin_response ?? '---' }}
                        </td>

                        <td style="padding:10px; border:1px solid #ddd; min-width:250px;">

                            <!-- Reply Form -->
                            <form action="{{ route('admin.comments.respond', $comment->id) }}" method="POST">
                                @csrf

                                <textarea name="admin_response" rows="2" placeholder="Write response..."
                                    style="width:100%; padding:6px; border:1px solid #ccc; border-radius:6px; margin-bottom:5px;"
                                    required>{{ $comment->admin_response }}</textarea>

                                <button type="submit" style="
                                    background:#2196F3;
                                    color:#fff;
                                    padding:6px 10px;
                                    border:none;
                                    border-radius:6px;
                                    cursor:pointer;
                                    font-size:13px;
                                ">
                                    {{ $comment->admin_response ? 'Update' : 'Reply' }}
                                </button>
                            </form>

                            <!-- Delete Form -->
                            <form action="{{ route('admin.comments.delete', $comment->id) }}" method="POST" style="margin-top:8px;">
                                @csrf
                                @method('DELETE')

                                <button type="submit" onclick="return confirm('Delete this comment?')" style="
                                    background:#f44336;
                                    color:#fff;
                                    padding:6px 10px;
                                    border:none;
                                    border-radius:6px;
                                    cursor:pointer;
                                    font-size:13px;
                                ">
                                    Delete
                                </button>
                            </form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center; padding:20px; color:#777;">
                            No comments found.
                        </td>
                    </tr>
                @endforelse

            </tbody>

        </table>

    </div>
</div>

@endsection