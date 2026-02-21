@extends('layouts.app') <!-- Or your public layout -->

@section('content')
<!-- Back Button -->
<a href="{{ route('devotions.public.index') }}" 
   style="display:inline-block; padding:10px 16px; background:#2196F3; color:#fff; border-radius:6px; text-decoration:none; transition:0.3s;"
   onmouseover="this.style.backgroundColor='#0f3c78';"
   onmouseout="this.style.backgroundColor='#2196F3';">
    ← Back to Devotions
</a>

<!-- ================= DEVOTION DETAIL ================= -->
<section id="devotion-detail" style="padding:60px 20px; background:#f9f9f9;">
    <div style="max-width:900px; margin:0 auto;">

        <!-- Devotion Title -->
        <h1 style="font-family:'Playfair Display', serif; font-weight:700; color:#0f3c78; margin-bottom:20px;">
            {{ $devotion->title }}
        </h1>

        <!-- Author & Posted Date -->
        <p style="font-family:'Inter', sans-serif; color:#555; margin-bottom:20px;">
            <small>By {{ $devotion->author }} | {{ \Carbon\Carbon::parse($devotion->date)->format('d M Y') }}</small>
        </p>

        <!-- Devotion Thumbnail -->
        @if($devotion->thumbnail)
            <div style="margin-bottom:30px; text-align:center;">
                <img src="{{ asset($devotion->thumbnail) }}" 
                     alt="Devotion Thumbnail" 
                     style="width:100%; max-height:400px; object-fit:cover; border-radius:8px; border:1px solid #ddd;">
            </div>
        @endif

        <!-- Devotion Content -->
        <div style="font-family:'Inter', sans-serif; color:#333; line-height:1.7; margin-bottom:30px;">
            {!! nl2br(e($devotion->content)) !!}
        </div>

        <!-- ================= COMMENTS SECTION ================= -->
        <section id="devotion-comments" style="margin-top:50px;">
            <h2 style="color:#0f3c78; font-family:'Playfair Display', serif; margin-bottom:20px;">Comments</h2>

            <!-- Comment Form -->
            @auth
                <form action="{{ route('devotions.comment.store', $devotion->id) }}" method="POST" style="margin-bottom:30px;">
                    @csrf
                    <textarea name="comment" rows="3" placeholder="Write your comment..." 
                              style="width:100%; padding:10px; border-radius:6px; border:1px solid #ddd;">{{ old('comment') }}</textarea>
                    @error('comment')
                        <p style="color:red; font-size:14px; margin-top:5px;">{{ $message }}</p>
                    @enderror
                    <button type="submit" 
                            style="margin-top:10px; padding:10px 16px; background:#2196F3; color:#fff; border-radius:6px; border:none; cursor:pointer;">
                        Post Comment
                    </button>
                </form>
            @else
                <p>
                    <a href="{{ route('login.google') }}" style="color:#2196F3; text-decoration:underline;">
                        Login with Google
                    </a> to post a comment.
                </p>
            @endauth

            <!-- List Comments -->
            @if($devotion->comments()->count() > 0)
                @foreach($devotion->comments()->with('user')->latest()->get() as $comment)
                    <div style="margin-bottom:20px; border-bottom:1px solid #ddd; padding-bottom:10px;">
                        <p style="font-weight:600; color:#0f3c78;">
                            {{ $comment->user->name }} 
                            <small style="color:#555;">{{ $comment->created_at->diffForHumans() }}</small>
                        </p>
                        <p>{{ $comment->comment }}</p>

                        @if($comment->admin_response)
                            <div style="margin-top:10px; padding:10px; background:#f0f0f0; border-left:4px solid #0f3c78;">
                                <p style="font-weight:600; color:#0f3c78;">Author  Reply:</p>
                                <p>{{ $comment->admin_response }}</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            @else
                <p style="color:#555;">No comments yet. Be the first to share your thoughts!</p>
            @endif

        </section>

    </div>
</section>
@endsection