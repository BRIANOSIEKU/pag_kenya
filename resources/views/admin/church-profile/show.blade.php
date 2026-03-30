@extends('layouts.admin')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;500;600&display=swap');

.profile-dashboard {
    max-width: 900px;
    margin: 40px auto;
    padding: 20px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 25px;
    position: relative;
}

.profile-dashboard::before {
    content: "";
    background: url('{{ asset('images/pagk_logo.png') }}') no-repeat center;
    background-size: 200px;
    opacity: 0.03;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 400px;
    height: 400px;
    z-index: 0;
    animation: shimmer 4s linear infinite;
}

@keyframes shimmer {
    0% { background-position: -400px 0; }
    100% { background-position: 400px 0; }
}

.profile-card {
    background: #fff;
    border-radius: 12px;
    border: 2px solid #4CAF50;
    padding: 20px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    position: relative;
    z-index: 1;
    animation: fadeIn 0.8s ease forwards, floatShadow 1.5s ease-in-out infinite alternate;
}

@keyframes fadeIn {
    0% { opacity: 0; transform: translateY(20px); }
    100% { opacity: 1; transform: translateY(0); }
}

@keyframes floatShadow {
    0% { box-shadow: 0 8px 20px rgba(0,0,0,0.1); }
    100% { box-shadow: 0 12px 30px rgba(0,0,0,0.2); }
}

.profile-card h3 {
    font-family: 'Playfair Display', serif;
    color: #4CAF50;
    margin-bottom: 12px;
}

.profile-card p {
    font-family: 'Inter', sans-serif;
    font-size: 0.95rem;
    margin-bottom: 15px;
}

.profile-card a {
    display: inline-block;
    padding: 8px 18px;
    background: #FFD700;
    color: #1e3c72;
    font-weight: bold;
    border: 2px solid #4CAF50;
    border-radius: 6px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.profile-card a:hover {
    background: #4CAF50;
    color: #fff;
}

@media (max-width: 768px) {
    .profile-dashboard {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="profile-dashboard">

    <div class="profile-card">
        <h3>Mission</h3>
        <p>{{ $profile->mission ?? 'Not defined yet.' }}</p>
        <a href="{{ route('admin.church-profile.edit', $profile->id ?? 0) }}">Edit Mission</a>
    </div>

    <div class="profile-card">
        <h3>Vision</h3>
        <p>{{ $profile->vision ?? 'Not defined yet.' }}</p>
        <a href="{{ route('admin.church-profile.edit', $profile->id ?? 0) }}">Edit Vision</a>
    </div>

    <div class="profile-card">
        <h3>Core Values</h3>
        <p>{{ $profile->core_values ?? 'Not defined yet.' }}</p>
        <a href="{{ route('admin.church-profile.edit', $profile->id ?? 0) }}">Edit Core Values</a>
    </div>

    <div class="profile-card">
        <h3>Statement of Faith</h3>
        <p>{{ $profile->statement_of_faith ?? 'Not defined yet.' }}</p>
        <a href="{{ route('admin.church-profile.edit', $profile->id ?? 0) }}">Edit Statement</a>
    </div>

</div>

@endsection
