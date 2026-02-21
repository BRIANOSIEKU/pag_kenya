@extends('layouts.admin')

@section('title', 'Edit Church Profile')

@section('content')
<div class="container my-5">

    {{-- Center the card and make it wide --}}
    <div class="row justify-content-center">
        <div class="col-lg-11">

            {{-- Fancy Card --}}
            <div class="card shadow-lg rounded-4 border-0">

                {{-- Gradient Header --}}
                <div class="card-header text-white px-4 py-3" 
                     style="background: linear-gradient(90deg, #1e3c72, #2a5298); font-weight: bold; font-size: 1.3rem;">
                    Edit Church Profile
                </div>

                <div class="card-body px-5 py-4">

                    {{-- Success / Error Messages --}}
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    {{-- Form --}}
                    <form action="{{ route('admin.church-profile.update', $profile->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        @php
                            $sections = [
                                ['label' => 'Motto', 'name' => 'motto', 'icon' => 'bi-bookmark-fill', 'rows' => 1, 'color' => 'text-primary'],
                                ['label' => 'Vision', 'name' => 'vision', 'icon' => 'bi-eye-fill', 'rows' => 5, 'color' => 'text-success'],
                                ['label' => 'Mission', 'name' => 'mission', 'icon' => 'bi-rocket-fill', 'rows' => 5, 'color' => 'text-danger'],
                                ['label' => 'Core Values', 'name' => 'core_values', 'icon' => 'bi-stars', 'rows' => 5, 'color' => 'text-warning'],
                                ['label' => 'Statement of Faith', 'name' => 'statement_of_faith', 'icon' => 'bi-journal-text', 'rows' => 6, 'color' => 'text-info'],
                                ['label' => 'Overview', 'name' => 'overview', 'icon' => 'bi-book-fill', 'rows' => 5, 'color' => 'text-secondary'],
                                ['label' => 'Brief History', 'name' => 'history', 'icon' => 'bi-clock-history', 'rows' => 5, 'color' => 'text-dark'],
                            ];
                        @endphp

                        @foreach($sections as $section)
                            <div class="card shadow-sm mb-4 p-4 rounded-3">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi {{ $section['icon'] }} me-2 {{ $section['color'] }}" style="font-size:1.2rem;"></i>
                                    <h5 class="mb-0" style="font-size: 1rem;">{{ $section['label'] }}</h5>
                                </div>

                                @if($section['rows'] == 1)
                                    <input type="text" name="{{ $section['name'] }}" 
                                           class="form-control shadow-sm" 
                                           value="{{ old($section['name'], $profile->{$section['name']}) }}" 
                                           style="width: 100%; height: 50px; font-size: 1rem;" required>
                                @else
                                    <textarea name="{{ $section['name'] }}" 
                                              class="form-control shadow-sm auto-expand" 
                                              rows="{{ $section['rows'] }}" 
                                              style="width: 100%; font-size: 1rem; transition: height 0.3s ease;" required>{{ old($section['name'], $profile->{$section['name']}) }}</textarea>
                                @endif
                            </div>
                        @endforeach

                        {{-- Buttons --}}
                        <div class="d-flex gap-3 mt-4">
                            <button type="submit" class="btn btn-primary shadow-sm px-5 py-2">
                                Update Profile
                            </button>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary shadow-sm px-5 py-2">
                                Cancel
                            </a>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

{{-- Auto-expand textarea script with smooth animation --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const textareas = document.querySelectorAll('.auto-expand');

        textareas.forEach(textarea => {
            const adjustHeight = () => {
                textarea.style.height = 'auto'; // reset height
                textarea.style.height = textarea.scrollHeight + 'px';
            };

            // Initial adjustment
            adjustHeight();

            // Adjust on input
            textarea.addEventListener('input', () => {
                // small timeout ensures smooth transition
                requestAnimationFrame(adjustHeight);
            });
        });
    });
</script>
@endsection
