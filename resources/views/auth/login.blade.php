@extends('layouts.app')
@section('title', 'Sign In')
@section('content')
<div class="min-h-[calc(100vh-4rem)] flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="w-14 h-14 bg-brand-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4z"/></svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">Welcome back</h1>
            <p class="text-gray-500 text-sm mt-1">Sign in to access your accounts</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition @error('email') border-red-300 @enderror">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input type="password" name="password" id="password" required
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition @error('password') border-red-300 @enderror">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="remember" class="w-4 h-4 text-brand-600 border-gray-300 rounded focus:ring-brand-500">
                            <span class="text-sm text-gray-600">Remember me</span>
                        </label>
                        <a href="{{ route('marketing.show', 'forgot-password') }}" class="text-sm text-brand-600 hover:text-brand-700 font-medium">Forgot password?</a>
                    </div>
                </div>

                <button type="submit" class="w-full bg-brand-600 text-white py-3 rounded-xl font-semibold mt-6 hover:bg-brand-700 transition shadow-sm">
                    Sign In
                </button>
            </form>
        </div>

        <p class="text-center mt-6 text-sm text-gray-500">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-brand-600 font-semibold hover:text-brand-700">Open one now</a>
        </p>
    </div>
</div>
@endsection
