@extends('layouts.app')
@section('title', 'Open Account')
@section('content')
<div class="min-h-screen py-12 px-4">
    <div class="w-full max-w-lg mx-auto">
        <div class="text-center mb-8">
            <div class="w-14 h-14 bg-brand-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4z"/></svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">Open your account</h1>
            <p class="text-gray-500 text-sm mt-1">It takes less than 3 minutes. No paperwork required.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Legal Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition @error('name') border-red-300 @enderror">
                        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition @error('email') border-red-300 @enderror">
                        @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                        <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition @error('phone') border-red-300 @enderror">
                        @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                            <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth') }}" required
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition @error('date_of_birth') border-red-300 @enderror">
                            @error('date_of_birth') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="ssn_last_four" class="block text-sm font-medium text-gray-700 mb-1">SSN (Last 4)</label>
                            <input type="password" name="ssn_last_four" id="ssn_last_four" maxlength="4" pattern="[0-9]{4}" required placeholder="****"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition @error('ssn_last_four') border-red-300 @enderror">
                            @error('ssn_last_four') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Street Address</label>
                        <input type="text" name="address" id="address" value="{{ old('address') }}" required
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition @error('address') border-red-300 @enderror">
                        @error('address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <input type="password" name="password" id="password" required
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition @error('password') border-red-300 @enderror">
                            @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                    </div>

                    <div class="flex items-start gap-3 pt-2">
                        <input type="checkbox" name="terms" id="terms" required
                            class="w-4 h-4 mt-0.5 text-brand-600 border-gray-300 rounded focus:ring-brand-500">
                        <label for="terms" class="text-sm text-gray-600">
                            I agree to the <a href="{{ route('marketing.show', 'terms') }}" class="text-brand-600 underline">Terms of Service</a> and <a href="{{ route('marketing.show', 'privacy') }}" class="text-brand-600 underline">Privacy Policy</a>, and I certify I am 18+ years old.
                        </label>
                    </div>
                    @error('terms') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="w-full bg-brand-600 text-white py-3 rounded-xl font-semibold mt-6 hover:bg-brand-700 transition shadow-sm">
                    Open My Account
                </button>
            </form>

            <div class="mt-4 p-3 bg-blue-50 rounded-xl">
                <p class="text-xs text-blue-700 text-center">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    Your information is encrypted and secure. We never share your data with third parties.
                </p>
            </div>
        </div>

        <p class="text-center mt-6 text-sm text-gray-500">
            Already have an account?
            <a href="{{ route('login') }}" class="text-brand-600 font-semibold hover:text-brand-700">Sign in</a>
        </p>
    </div>
</div>
@endsection
