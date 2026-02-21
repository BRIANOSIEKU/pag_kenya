@extends('layouts.app')

@section('title', 'Give Now')

@section('content')
<div class="container mx-auto py-12 px-4 max-w-xl">
    <h1 class="text-3xl font-bold mb-6 text-center">Give Now</h1>
    
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 text-red-800 p-4 rounded mb-6">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('giving.submit') }}" method="POST" class="bg-white p-8 rounded-lg shadow-md space-y-6">
        @csrf

        <!-- Full Name -->
        <div>
            <label for="name" class="block font-semibold mb-2">Full Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                   class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
        </div>

        <!-- Phone Number -->
        <div>
            <label for="phone_number" class="block font-semibold mb-2">Phone Number</label>
            <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number') }}" required
                   class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block font-semibold mb-2">Email Address</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                   class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
        </div>

        <!-- Amount -->
        <div>
            <label for="amount" class="block font-semibold mb-2">Amount (KES)</label>
            <input type="number" name="amount" id="amount" value="{{ old('amount') }}" min="1" required
                   class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
        </div>

        <!-- Payment Method -->
        <div>
            <label for="method" class="block font-semibold mb-2">Payment Method</label>
            <select name="method" id="method" required
                    class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                <option value="">-- Select Method --</option>
                <option value="Mpesa" {{ old('method') == 'Mpesa' ? 'selected' : '' }}>M-Pesa</option>
                <option value="Bank Transfer" {{ old('method') == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                <option value="Online" {{ old('method') == 'Online' ? 'selected' : '' }}>Online Payment</option>
            </select>
        </div>

        <!-- Optional Message -->
        <div>
            <label for="message" class="block font-semibold mb-2">Message (Optional)</label>
            <textarea name="message" id="message" rows="4"
                      class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">{{ old('message') }}</textarea>
        </div>

        <!-- Submit Button -->
        <div class="text-center">
            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-8 py-3 rounded-lg shadow-lg transition duration-300">
                Submit Donation
            </button>
        </div>
    </form>
</div>
@endsection
