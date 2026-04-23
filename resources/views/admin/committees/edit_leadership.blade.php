@extends('layouts.admin')

@section('content')

<div class="container" style="max-width:1100px; margin:auto; padding:30px;">

    <h2 style="font-size:28px; font-weight:bold; margin-bottom:25px;">
        Edit Leader for {{ $committee->name }}
    </h2>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div style="background:#e8f5e9; color:#2e7d32; padding:15px; border-radius:8px; margin-bottom:20px;">
            {{ session('success') }}
        </div>
    @endif

    {{-- ERRORS --}}
    @if ($errors->any())
        <div style="background:#fdecea; color:#b71c1c; padding:15px; border-radius:8px; margin-bottom:20px;">
            <ul style="margin:0; padding-left:20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="background:#fff; border-radius:10px; box-shadow:0 2px 10px rgba(0,0,0,0.08); overflow:hidden;">

        <form action="{{ route('admin.committees.leadership.update', [$committee->id, $leader->id]) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <table style="width:100%; border-collapse:collapse;">

                <!-- NAME -->
                <tr style="border-bottom:1px solid #eee;">
                    <td style="width:25%; background:#f9f9f9; padding:15px; font-weight:bold;">
                        Full Name
                    </td>
                    <td style="padding:15px;">
                        <input type="text"
                               name="name"
                               value="{{ old('name', $leader->name ?? '') }}"
                               style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">
                    </td>
                </tr>

                <!-- ROLE (PIVOT) -->
                <tr style="border-bottom:1px solid #eee;">
                    <td style="background:#f9f9f9; padding:15px; font-weight:bold;">
                        Role
                    </td>
                    <td style="padding:15px;">
                        <input type="text"
                               name="role"
                               value="{{ old('role', $leader->pivot->role ?? '') }}"
                               style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">
                    </td>
                </tr>

                <!-- CONTACT (PIVOT) -->
                <tr style="border-bottom:1px solid #eee;">
                    <td style="background:#f9f9f9; padding:15px; font-weight:bold;">
                        Contact
                    </td>
                    <td style="padding:15px;">
                        <input type="text"
                               name="contact"
                               value="{{ old('contact', $leader->pivot->contact ?? '') }}"
                               style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">
                    </td>
                </tr>

                <!-- PHOTO (PIVOT) -->
                <tr>
                    <td style="background:#f9f9f9; padding:15px; font-weight:bold;">
                        Photo
                    </td>
                    <td style="padding:15px;">
                        <input type="file" name="photo" id="photoInput">

                        <div style="margin-top:15px;">
                            @php
                                $photo = $leader->pivot->photo ?? null;
                            @endphp

                            @if($photo)
                                <img src="{{ asset('storage/leaders_photos/'.$photo) }}"
                                     style="width:120px; height:120px; object-fit:cover; border-radius:50%;">
                            @else
                                <div style="color:#888;">No photo uploaded</div>
                            @endif
                        </div>
                    </td>
                </tr>

            </table>

            <div style="padding:20px;">
                <button type="submit"
                        style="background:#2196F3; color:#fff; padding:12px 25px; border:none; border-radius:6px; font-weight:bold; cursor:pointer;">
                    Update Leader
                </button>
            </div>

        </form>
    </div>
</div>

@endsection