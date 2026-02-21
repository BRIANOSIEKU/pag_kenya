@extends('layouts.admin')

@section('content')

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8"> <!-- narrower than full width -->

            <div class="card shadow border-0 rounded-4">
                <div class="card-header bg-gradient-primary text-white rounded-top-4 text-center py-2">
                    <h4 class="mb-0"><i class="bi bi-building"></i> Create Church Profile</h4>
                </div>

                <div class="card-body p-0">

                    <!-- Validation Errors -->
                    @if ($errors->any())
                        <div class="alert alert-danger m-3 alert-dismissible fade show">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.church-profile.store') }}" method="POST">
                        @csrf

                        <table class="table table-borderless mb-0 align-middle" style="width:100%; table-layout: fixed; border-collapse: separate; border-spacing: 0 8px;">
                            <tbody>

                                <!-- Motto Row -->
                                <tr class="align-top shadow-sm rounded-3" style="background: #f8f9fa; border-radius:10px; transition: transform 0.2s;">
                                    <th style="width:28%; text-align:right; vertical-align: top; padding:12px;">
                                        <i class="bi bi-flag-fill text-primary me-1"></i> Motto <span class="text-danger">*</span>
                                    </th>
                                    <td style="padding: 10px;">
                                        <input type="text" name="motto" class="form-control form-control-sm" 
                                               value="{{ old('motto') }}" 
                                               placeholder="Church motto" 
                                               style="width:100%; height:50px; font-size:1rem; padding:10px;" required>
                                    </td>
                                </tr>

                                <!-- Mission / Vision - Blue Gradient -->
                                <tr class="align-top shadow-sm rounded-3" style="background: linear-gradient(90deg, #e3f2fd, #bbdefb); border-radius:10px; transition: transform 0.2s;">
                                    <th style="text-align:right; vertical-align: top; padding:12px;">
                                        <i class="bi bi-eye-fill text-primary me-1"></i> Vision <span class="text-danger">*</span>
                                    </th>
                                    <td style="padding: 10px;">
                                        <textarea name="vision" class="form-control form-control-sm" 
                                                  placeholder="Church vision" 
                                                  style="width:100%; min-height:100px; font-size:1rem; padding:10px;" required>{{ old('vision') }}</textarea>
                                    </td>
                                </tr>
                                <tr class="align-top shadow-sm rounded-3" style="background: linear-gradient(90deg, #e3f2fd, #bbdefb); border-radius:10px; transition: transform 0.2s;">
                                    <th style="text-align:right; vertical-align: top; padding:12px;">
                                        <i class="bi bi-rocket-takeoff-fill text-primary me-1"></i> Mission <span class="text-danger">*</span>
                                    </th>
                                    <td style="padding: 10px;">
                                        <textarea name="mission" class="form-control form-control-sm" 
                                                  placeholder="Church mission" 
                                                  style="width:100%; min-height:100px; font-size:1rem; padding:10px;" required>{{ old('mission') }}</textarea>
                                    </td>
                                </tr>

                                <!-- Core Values / Statement of Faith - Green Gradient -->
                                <tr class="align-top shadow-sm rounded-3" style="background: linear-gradient(90deg, #e8f5e9, #c8e6c9); border-radius:10px; transition: transform 0.2s;">
                                    <th style="text-align:right; vertical-align: top; padding:12px;">
                                        <i class="bi bi-stars text-success me-1"></i> Core Values <span class="text-danger">*</span>
                                    </th>
                                    <td style="padding: 10px;">
                                        <textarea name="core_values" class="form-control form-control-sm" 
                                                  placeholder="Church core values" 
                                                  style="width:100%; min-height:120px; font-size:1rem; padding:10px;" required>{{ old('core_values') }}</textarea>
                                    </td>
                                </tr>
                                <tr class="align-top shadow-sm rounded-3" style="background: linear-gradient(90deg, #e8f5e9, #c8e6c9); border-radius:10px; transition: transform 0.2s;">
                                    <th style="text-align:right; vertical-align: top; padding:12px;">
                                        <i class="bi bi-book-fill text-success me-1"></i> Statement of Faith <span class="text-danger">*</span>
                                    </th>
                                    <td style="padding: 10px;">
                                        <textarea name="statement_of_faith" class="form-control form-control-sm" 
                                                  placeholder="Statement of faith" 
                                                  style="width:100%; min-height:120px; font-size:1rem; padding:10px;" required>{{ old('statement_of_faith') }}</textarea>
                                    </td>
                                </tr>

                                <!-- History / Overview - Yellow Gradient -->
                                <tr class="align-top shadow-sm rounded-3" style="background: linear-gradient(90deg, #fffde7, #fff9c4); border-radius:10px; transition: transform 0.2s;">
                                    <th style="text-align:right; vertical-align: top; padding:12px;">
                                        <i class="bi bi-clock-history text-warning me-1"></i> History
                                    </th>
                                    <td style="padding: 10px;">
                                        <textarea name="history" class="form-control form-control-sm" 
                                                  placeholder="Church history" 
                                                  style="width:100%; min-height:100px; font-size:1rem; padding:10px;">{{ old('history') }}</textarea>
                                    </td>
                                </tr>
                                <tr class="align-top shadow-sm rounded-3" style="background: linear-gradient(90deg, #fffde7, #fff9c4); border-radius:10px; transition: transform 0.2s;">
                                    <th style="text-align:right; vertical-align: top; padding:12px;">
                                        <i class="bi bi-journal-text text-warning me-1"></i> Overview
                                    </th>
                                    <td style="padding: 10px;">
                                        <textarea name="overview" class="form-control form-control-sm" 
                                                  placeholder="Church overview" 
                                                  style="width:100%; min-height:100px; font-size:1rem; padding:10px;">{{ old('overview') }}</textarea>
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                        <div class="p-3 text-end">
                            <button type="submit" class="btn btn-success btn-sm shadow-sm"><i class="bi bi-save2"></i> Create Profile</button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- Hover effect for rows -->
<style>
    table tr:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
</style>

@endsection
