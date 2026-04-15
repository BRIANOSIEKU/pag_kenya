@extends('layouts.admin')

@section('content')
<div style="text-align:center; padding:60px;">
    <h1 style="font-size:40px; color:#e53935;">403 - Unauthorized Access</h1>
    <p style="font-size:18px; color:#555;">
        You do not have permission to access this module.
    </p>

    <a href="{{ url()->previous() }}"
       style="display:inline-block;margin-top:20px;padding:10px 20px;
              background:#607D8B;color:#fff;border-radius:6px;text-decoration:none;">
        Go Back
    </a>
</div>
@endsection