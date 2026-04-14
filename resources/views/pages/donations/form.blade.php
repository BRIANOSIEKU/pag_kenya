@extends('layouts.app')

@section('title', 'Give Now')

@section('content')
<style>
    html, body {
        height: 100%;
    }

    body {
        display: flex;
        flex-direction: column;
        margin: 0;
    }

    .main-content {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #f1f5f9;
        padding: 1rem;
    }

    .donation-card {
        background: white;
        border-radius: 2rem;
        padding: 2rem;
        max-width: 400px;
        width: 100%;
        box-shadow: 0 20px 50px rgba(0,0,0,0.05);
        border: 1px solid #e5e7eb;
    }

    .donation-card h1 {
        text-align: center;
        font-size: 1.75rem;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 1.5rem;
    }

    .donation-card label {
        display: block;
        font-weight: 600;
        color: #334155;
        margin-bottom: 0.25rem;
    }

    .donation-card input {
        width: 100%;
        padding: 0.75rem 1rem 0.75rem 3rem; 
        border-radius: 1rem;
        border: 1px solid #e5e7eb;
        background: #f9fafb;
        font-size: 0.95rem;
        outline: none;
        transition: all 0.2s;
        box-sizing: border-box;
    }

    .donation-card input:focus {
        border-color: #facc15;
        box-shadow: 0 0 0 2px rgba(250, 204, 21, 0.3);
        background: #ffffff;
    }

    .amount-wrapper {
        position: relative;
    }

    .amount-wrapper span {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        font-weight: 700;
        color: #9ca3af;
        pointer-events: none;
    }

    .donation-card button {
        width: 100%;
        background-color: #facc15;
        color: #1e293b;
        font-weight: 800;
        padding: 1rem;
        border-radius: 1.5rem;
        margin-top: 1.5rem;
        cursor: pointer;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        transition: all 0.2s;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
    }

    .donation-card button:hover {
        background-color: #eab308;
        transform: scale(1.02);
    }

    .spinner {
        border: 2px solid rgba(0,0,0,0.1);
        border-left-color: #1e293b;
        border-radius: 50%;
        width: 1rem;
        height: 1rem;
        animation: spin 1s linear infinite;
        display: none; /* hidden by default */
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    .alert {
        padding: 0.75rem 1rem;
        border-radius: 1rem;
        font-weight: 600;
        margin-bottom: 1rem;
        text-align: center;
    }

    .alert-success {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #d1fae5;
    }

    .alert-error {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }
</style>

<div class="main-content">
    <div class="donation-card">
        <h1>Make a Donation</h1>

        <!-- Success/Error messages -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Donation Form -->
        <form id="donationForm" action="{{ route('giving.submit') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Name -->
            <div class="space-y-1">
                <label>Full Name</label>
                <input type="text" name="name" required placeholder="John Mark">
            </div>

            <!-- Amount -->
            <div class="space-y-1">
                <label>Amount (KES)</label>
                <div class="amount-wrapper">
                    <span>KSh</span>
                    <input type="number" name="amount" required min="1" placeholder="Enter amount">
                </div>
            </div>

            <!-- Phone Number -->
            <div class="space-y-1">
                <label>Phone Number (for M-Pesa)</label>
                <input type="tel" name="phone_number" required placeholder="07XXXXXXXX" pattern="[0-9]{10}">
            </div>

            <!-- Donating For -->
            <div class="space-y-1">
                <label>Donating For</label>
                <input type="text" name="purpose" required placeholder="e.g. Church Project">
            </div>

            <!-- Submit -->
            <button type="submit">
                <div class="spinner" id="spinner"></div>
                Donate Now
            </button>
        </form>
    </div>
</div>

<script>
    const form = document.getElementById('donationForm');
    const button = form.querySelector('button');
    const spinner = document.getElementById('spinner');

    form.addEventListener('submit', function() {
        spinner.style.display = 'inline-block';
        button.disabled = true;
    });
</script>
@endsection