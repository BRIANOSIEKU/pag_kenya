@extends('layouts.app')

@section('title', 'Give Now')

@section('content')
<div class="min-h-screen bg-slate-50 flex items-center justify-center p-6">

    <div class="w-full max-w-md bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden p-8">
        
        <h1 class="text-2xl font-bold text-gray-800 text-center mb-6">Make a Donation</h1>
        <p class="text-gray-500 text-center mb-6">Your generosity changes lives.</p>

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-2xl text-sm font-semibold text-center">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('giving.submit') }}" method="POST" class="space-y-6">
            @csrf

            <div class="space-y-2">
                <label class="text-sm font-bold text-gray-700 ml-1">Amount (KES)</label>
                <div class="relative">
                    <span class="absolute left-5 top-4 text-gray-400 font-bold">KSh</span>
                    <input type="number" name="amount" required min="1"
                           placeholder="Enter amount"
                           class="w-full bg-gray-50 border-none rounded-2xl pl-16 pr-5 py-4 focus:ring-2 focus:ring-yellow-400 transition-all">
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-sm font-bold text-gray-700 ml-1">Donating For</label>
                <input type="text" name="purpose" required placeholder="e.g. Church Project"
                       class="w-full bg-gray-50 border-none rounded-2xl px-5 py-4 focus:ring-2 focus:ring-yellow-400 transition-all">
            </div>

            <button type="submit" 
                    class="w-full bg-yellow-400 hover:bg-yellow-500 text-yellow-950 font-black py-5 rounded-2xl shadow-xl shadow-yellow-100 transition-all duration-300 transform hover:scale-[1.02] active:scale-95 uppercase tracking-widest text-sm">
                Donate Now
            </button>
        </form>
    </div>
</div>
@endsection