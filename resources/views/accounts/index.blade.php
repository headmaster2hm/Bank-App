@extends('layouts.banking')
@section('title', 'My Accounts')

@section('content')
<div class="fade-in">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">My Accounts</h1>
            <p class="text-gray-500 text-sm mt-1">Manage your bank accounts</p>
        </div>
        <a href="{{ route('accounts.create') }}" class="bg-brand-600 text-white px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-brand-700 transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Open Account
        </a>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($accounts as $account)
            <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden card-hover">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 {{ $account->account_type === 'checking' ? 'bg-blue-100' : ($account->account_type === 'savings' ? 'bg-green-100' : 'bg-purple-100') }} rounded-xl flex items-center justify-center">
                                @if($account->account_type === 'checking')
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4z"/></svg>
                                @elseif($account->account_type === 'savings')
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/></svg>
                                @else
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                @endif
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $account->account_name }}</p>
                                <p class="text-xs text-gray-500">{{ ucfirst($account->account_type) }} &middot; {{ $account->maskedNumber() }}</p>
                            </div>
                        </div>
                        @if($account->status === 'frozen')
                            <span class="text-xs bg-amber-100 text-amber-700 px-2.5 py-1 rounded-full font-medium">Frozen</span>
                        @endif
                    </div>

                    <div class="mb-4">
                        <p class="text-xs text-gray-500 mb-1">Current Balance</p>
                        <p class="text-2xl font-bold text-gray-900">${{ number_format($account->balance, 2) }}</p>
                    </div>

                    @if($account->account_type === 'savings' && $account->interest_rate > 0)
                        <div class="bg-green-50 rounded-xl p-3 mb-4">
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-green-700 font-medium">Interest Rate</span>
                                <span class="text-sm font-bold text-green-700">{{ $account->interest_rate }}% APY</span>
                            </div>
                        </div>
                    @endif

                    @if($account->credit_limit)
                        <div class="mb-4">
                            <div class="flex items-center justify-between text-xs text-gray-500 mb-1">
                                <span>Credit Used</span>
                                <span>${{ number_format($account->balance, 2) }} / ${{ number_format($account->credit_limit, 2) }}</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2">
                                <div class="bg-purple-500 h-2 rounded-full" style="width: {{ min(($account->balance / $account->credit_limit) * 100, 100) }}%"></div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="border-t border-gray-100 px-6 py-3 flex items-center justify-between">
                    <a href="{{ route('accounts.show', $account) }}" class="text-sm text-brand-600 hover:text-brand-700 font-medium">View Details</a>
                    <div class="flex items-center gap-2">
                        @if($account->status === 'active')
                            <form method="POST" action="{{ route('accounts.freeze', $account) }}">
                                @csrf
                                <button type="submit" class="text-xs text-amber-600 hover:text-amber-700 font-medium" onclick="return confirm('Freeze this account?')">Freeze</button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('accounts.unfreeze', $account) }}">
                                @csrf
                                <button type="submit" class="text-xs text-green-600 hover:text-green-700 font-medium">Unfreeze</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-2xl border border-gray-100 p-12 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4z"/></svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No accounts yet</h3>
                <p class="text-gray-500 text-sm mb-6">Open your first account to start banking with us</p>
                <a href="{{ route('accounts.create') }}" class="bg-brand-600 text-white px-6 py-2.5 rounded-xl text-sm font-medium hover:bg-brand-700 transition inline-block">
                    Open Your First Account
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection
