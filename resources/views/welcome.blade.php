@extends('layouts.app')
@section('title', 'Personal & Business Banking')
@section('content')

{{-- ========== 1. HERO ========== --}}
@php $heroArt = public_path('images/hero-bg.svg'); @endphp
<section class="relative bg-bank-950 overflow-hidden">
    <div class="absolute inset-0" aria-hidden="true">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('images/hero-bg.svg') }}?v={{ @filemtime($heroArt) ?: 1 }}');"></div>
        <div class="absolute inset-0" style="background: linear-gradient(100deg, #0a1929 0%, rgba(10,25,41,0.94) 34%, rgba(10,25,41,0.62) 58%, rgba(10,25,41,0.18) 100%);"></div>
    </div>
    <div class="relative max-w-[1400px] mx-auto px-4 lg:px-8 py-20 lg:py-28">
        <div class="grid lg:grid-cols-12 gap-12 items-center">
            <div class="lg:col-span-7">
                <p class="text-accent-400 text-xs font-bold uppercase tracking-[0.2em] mb-5">Welcome to SecureBank</p>
                <h1 class="font-serif text-4xl md:text-5xl lg:text-6xl font-semibold text-white leading-[1.1] mb-6">
                    Banking built around<br class="hidden sm:block"> your financial goals.
                </h1>
                <p class="text-lg text-bank-300 leading-relaxed max-w-xl mb-9">
                    From everyday banking and savings to lending, investing, and wealth management, we provide the financial tools and guidance to help you move forward.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('register') }}" class="inline-flex items-center gap-2.5 bg-accent-500 hover:bg-accent-600 text-white px-8 py-3.5 rounded-lg font-semibold transition-all shadow-lg shadow-black/20">
                        Open an Account
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    <a href="#products" class="inline-flex items-center gap-2 border border-white/25 hover:border-white/50 text-white px-8 py-3.5 rounded-lg font-semibold transition-colors">
                        Explore Banking
                    </a>
                </div>
                <div class="flex flex-wrap items-center gap-x-8 gap-y-3 mt-10 text-xs text-bank-400">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-accent-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Real-time account balances
                    </span>
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-accent-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        Encrypted sign-in
                    </span>
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-accent-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21h18M3 10h18M5 6l7-3 7 3M4 10v11M20 10v11M8 14v3M12 14v3M16 14v3"/></svg>
                        Branches and digital banking
                    </span>
                </div>
                <p class="text-[11px] text-bank-500 mt-6 max-w-md">Demonstration prototype. Institution details, rates, and figures shown throughout this site are illustrative placeholders.</p>
            </div>

            {{-- 2. ONLINE BANKING LOGIN --}}
            <div class="lg:col-span-5">
                <div class="bg-white rounded-2xl shadow-2xl shadow-black/30 overflow-hidden">
                    <div class="bg-bank-800 px-6 py-4 flex items-center justify-between">
                        <div>
                            <h2 class="text-white font-semibold text-lg">Online Banking</h2>
                            <p class="text-bank-300 text-xs mt-0.5">Sign in to your account</p>
                        </div>
                        <div class="w-9 h-9 bg-white/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('login') }}" class="p-6 space-y-4">
                        @csrf
                        <div>
                            <label for="hero-email" class="block text-xs font-semibold text-bank-600 uppercase tracking-wider mb-1.5">Username or Email</label>
                            <input type="text" name="email" id="hero-email" value="{{ old('email') }}" autocomplete="username" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-accent-500/40 focus:border-accent-500 transition @error('email') border-red-400 @enderror"
                                placeholder="you@example.com">
                            @error('email') <p class="mt-1.5 text-xs text-red-600 font-medium" role="alert">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="hero-password" class="block text-xs font-semibold text-bank-600 uppercase tracking-wider mb-1.5">Password</label>
                            <input type="password" name="password" id="hero-password" autocomplete="current-password" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-accent-500/40 focus:border-accent-500 transition @error('password') border-red-400 @enderror"
                                placeholder="Enter your password">
                            @error('password') <p class="mt-1.5 text-xs text-red-600 font-medium" role="alert">{{ $message }}</p> @enderror
                        </div>
                        <div class="flex items-center justify-between">
                            <label class="flex items-center gap-2 text-sm text-bank-600">
                                <input type="checkbox" name="remember" id="hero-remember" class="w-4 h-4 rounded border-gray-300 text-accent-600 focus:ring-accent-500">
                                <label for="hero-remember" class="cursor-pointer">Remember me</label>
                            </label>
                        </div>
                        <button type="submit" class="w-full py-3.5 bg-bank-800 hover:bg-bank-900 text-white rounded-lg font-semibold text-sm transition-colors">
                            Sign In
                        </button>
                        <div class="border-t border-gray-100 pt-4 grid grid-cols-2 gap-2 text-center">
                            <a href="{{ route('marketing.show', 'forgot-password') }}" class="text-xs text-bank-500 hover:text-bank-800 transition-colors">Forgot password?</a>
                            <a href="{{ route('marketing.show', 'enroll-online-banking') }}" class="text-xs text-bank-500 hover:text-bank-800 transition-colors">Enroll in online banking</a>
                        </div>
                        <div class="bg-bank-50 rounded-lg px-3 py-2.5 flex items-center gap-2 text-[11px] text-bank-500">
                            <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Secure connection. Your information is encrypted and protected.
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ========== 2. QUICK ACTIONS ========== --}}
<section class="bg-white border-b border-gray-200">
    <div class="max-w-[1400px] mx-auto px-4 lg:px-8 py-6">
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-1">
            @php $actions = [
                ['Open an Account','UserPlus',route('register'),false],
                ['Sign In','LockClosed',route('login'),false],
                ['Send Money','ArrowRightLeft',route('transfer'),true],
                ['Pay a Bill','DocumentText',route('marketing.show','bill-pay'),false],
                ['Deposit a Check','ArrowDownTray',route('deposit'),true],
                ['Find an ATM','MapPin',route('marketing.show','find-atm'),false],
                ['Find a Branch','BuildingOffice',route('marketing.show','find-a-branch'),false],
                ['Get Help','ChatBubble',route('marketing.show','help-support'),false],
            ]; @endphp
            @foreach($actions as [$label,$icon,$url,$authOnly])
            @php $href = ($authOnly && ! auth()->check()) ? route('login') : $url; @endphp
            <a href="{{ $href }}"
               class="group flex flex-col items-center gap-2.5 py-4 px-2 rounded-lg hover:bg-bank-50 transition-colors text-center">
                <div class="w-10 h-10 rounded-full bg-bank-100 group-hover:bg-accent-100 flex items-center justify-center transition-colors">
                    <svg class="w-5 h-5 text-bank-600 group-hover:text-accent-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @switch($icon)
                            @case('UserPlus')<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7zM19 8v6M22 11h-6"/></>
                            @case('LockClosed')<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></>
                            @case('ArrowRightLeft')<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></>
                            @case('DocumentText')<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 7h6m-6 4h4"/></>
                            @case('ArrowDownTray')<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3v12m0 0l-4-4m4 4l4-4M4 17v2a2 2 0 002 2h12a2 2 0 002-2v-2"/></>
                            @case('MapPin')<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/></>
                            @case('BuildingOffice')<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5"/></>
                            @case('ChatBubble')<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></>
                        @endswitch
                    </svg>
                </div>
                <span class="text-xs font-medium text-bank-700 group-hover:text-bank-900 leading-tight">{{ $label }}</span>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ========== 3. PERSONAL BANKING PRODUCTS ========== --}}
<section id="products" class="py-20 bg-white">
    <div class="max-w-[1400px] mx-auto px-4 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <p class="text-accent-600 text-xs font-bold uppercase tracking-[0.2em] mb-3">Personal Banking</p>
            <h2 class="font-serif text-3xl md:text-4xl font-semibold text-bank-900">Banking for every stage of life</h2>
            <p class="text-bank-500 mt-4">Whether you're just starting out, building a family, or planning your retirement, we have accounts designed around the way you actually live.</p>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            @php $products = [
                ['Checking Accounts','Manage everyday spending with flexible options and no hidden fees.','No monthly maintenance fees','banknotes'],
                ['Savings Accounts','Build savings and prepare for your future with competitive rates.','Earn up to 4.50% APY','archive-box'],
                ['Credit Cards','Choose cards designed around rewards, spending, and flexibility.','Up to 3% cash back','credit-card'],
                ['Certificates of Deposit','Grow your savings with fixed-term deposit options.','Rates up to 4.75% APY','shield-check'],
            ]; @endphp
            @foreach($products as [$title,$desc,$benefit,$icon])
            <div class="lift group border border-gray-200 rounded-xl p-7 bg-white cursor-pointer">
                <div class="w-12 h-12 bg-bank-50 group-hover:bg-accent-50 rounded-xl flex items-center justify-center mb-5 transition-colors">
                    <svg class="w-6 h-6 text-bank-600 group-hover:text-accent-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        @switch($icon)
                            @case('banknotes')<path stroke-linecap="round" stroke-linejoin="round" d="M2 6h20v12H2zM2 10h20M6 15h4M12 15h2"/></>
                            @case('archive-box')<path stroke-linecap="round" stroke-linejoin="round" d="M3 8v11a2 2 0 002 2h14a2 2 0 002-2V8M2 3h20v5H2zM10 12h4"/></>
                            @case('credit-card')<path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h2M3 5h18a2 2 0 012 2v10a2 2 0 01-2 2H3a2 2 0 01-2-2V7a2 2 0 012-2z"/></>
                            @case('shield-check')<path stroke-linecap="round" stroke-linejoin="round" d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10zM9 12l2 2 4-4"/></>
                        @endswitch
                    </svg>
                </div>
                <h3 class="font-semibold text-bank-900 text-lg mb-2">{{ $title }}</h3>
                <p class="text-sm text-bank-500 leading-relaxed mb-4">{{ $desc }}</p>
                <p class="text-xs font-semibold text-accent-600 mb-5">{{ $benefit }}</p>
                <span class="text-sm font-semibold text-bank-800 group-hover:text-accent-600 transition-colors inline-flex items-center gap-1.5">Explore
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </span>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ========== 4. FEATURED PRODUCT ========== --}}
<section class="py-20 bg-bank-50">
    <div class="max-w-[1400px] mx-auto px-4 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-0 rounded-2xl overflow-hidden shadow-sm bg-white">
            <div class="relative min-h-[380px] lg:min-h-[520px]">
                <img src="https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=1000&q=80" alt="Professional reviewing financial documents" class="absolute inset-0 w-full h-full object-cover">
            </div>
            <div class="p-8 lg:p-14 flex flex-col justify-center">
                <p class="text-accent-600 text-xs font-bold uppercase tracking-[0.2em] mb-3">Featured</p>
                <h2 class="font-serif text-3xl lg:text-4xl font-semibold text-bank-900 mb-5">A smarter way to manage your money</h2>
                <p class="text-bank-600 leading-relaxed mb-7">Our Premier Banking account combines everyday checking with premium benefits — including higher interest rates, unlimited ATM access, and dedicated relationship support.</p>
                <ul class="space-y-3 mb-8">
                    @foreach(['No complicated setup — open in minutes','Secure digital access with biometric login','Convenient transfers between your accounts','Full-featured mobile banking','Dedicated banker support when you need it'] as $benefit)
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="text-sm text-bank-700">{{ $benefit }}</span>
                    </li>
                    @endforeach
                </ul>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('register') }}" class="px-6 py-3 bg-bank-800 hover:bg-bank-900 text-white rounded-lg font-semibold text-sm transition-colors">Open an Account</a>
                    <a href="{{ route('marketing.show', 'high-yield-savings') }}" class="px-6 py-3 border border-bank-300 text-bank-700 hover:bg-bank-50 rounded-lg font-semibold text-sm transition-colors">Learn More</a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ========== 5. LOANS & CREDIT ========== --}}
<section class="py-20 bg-white">
    <div class="max-w-[1400px] mx-auto px-4 lg:px-8">
        <div class="max-w-2xl mb-14">
            <p class="text-accent-600 text-xs font-bold uppercase tracking-[0.2em] mb-3">Loans & Credit</p>
            <h2 class="font-serif text-3xl md:text-4xl font-semibold text-bank-900 mb-4">When you're ready to move forward, we're here to help</h2>
            <p class="text-bank-500">Competitive rates, flexible terms, and online applications designed around your timeline.</p>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php $loans = [
                ['Personal Loans','From $5,000 to $100,000 with fixed rates and no prepayment penalties.','calculator'],
                ['Auto Loans','Competitive rates on new and used vehicles with quick approvals.','truck'],
                ['Home Loans','Fixed and adjustable-rate mortgages with flexible down payment options.','home'],
                ['Lines of Credit','Revolving credit for flexibility when you need it most.','credit'],
                ['Student Loans','Federal and private student lending with competitive fixed rates.','academic-cap'],
                ['Business Loans','Working capital and growth financing for businesses of all sizes.','building-office'],
            ]; @endphp
            @foreach($loans as [$title,$desc,$icon])
            <div class="lift border border-gray-200 rounded-xl p-6 group cursor-pointer">
                <div class="w-11 h-11 bg-bank-50 group-hover:bg-accent-50 rounded-lg flex items-center justify-center mb-4 transition-colors">
                    <svg class="w-5 h-5 text-bank-600 group-hover:text-accent-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        @switch($icon)
                            @case('calculator')<rect x="4" y="2" width="16" height="20" rx="2"/><path d="M8 6h8M8 11h.01M12 11h.01M16 11h.01M8 15h.01M12 15h.01M16 15v4M8 19h4"/></>
                            @case('truck')<path d="M1 3h15v13H1zM16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></>
                            @case('home')<path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path d="M9 22V12h6v10"/></>
                            @case('credit')<rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></>
                            @case('academic-cap')<path d="M22 10L12 5 2 10l10 5 10-5zM6 12v5c0 1.66 2.69 3 6 3s6-1.34 6-3v-5"/></>
                            @case('building-office')<path d="M3 21V5a2 2 0 012-2h8a2 2 0 012 2v16M15 21V9h4a2 2 0 012 2v10M1 21h22M7 7h2M7 11h2M7 15h2"/></>
                        @endswitch
                    </svg>
                </div>
                <h3 class="font-semibold text-bank-900 mb-1.5">{{ $title }}</h3>
                <p class="text-sm text-bank-500 leading-relaxed">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
        <div class="flex flex-wrap gap-4 mt-10">
            <a href="{{ route('marketing.show', 'borrowing') }}" class="px-7 py-3.5 bg-bank-800 hover:bg-bank-900 text-white rounded-lg font-semibold text-sm transition-colors">Explore Borrowing Options</a>
            <a href="{{ route('marketing.show', 'payment-calculator') }}" class="px-7 py-3.5 border border-bank-300 text-bank-700 hover:bg-bank-50 rounded-lg font-semibold text-sm transition-colors">Calculate Your Payment</a>
        </div>
    </div>
</section>

{{-- ========== 6. MORTGAGE ========== --}}
<section class="relative py-24 overflow-hidden">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=1800&q=80" alt="" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-bank-950/95 via-bank-950/85 to-bank-950/40"></div>
    </div>
    <div class="relative max-w-[1400px] mx-auto px-4 lg:px-8">
        <div class="max-w-xl">
            <p class="text-accent-400 text-xs font-bold uppercase tracking-[0.2em] mb-3">Home Loans</p>
            <h2 class="font-serif text-3xl md:text-4xl font-semibold text-white mb-5">Your next home could be closer than you think</h2>
            <p class="text-bank-200 leading-relaxed mb-8">Whether you're a first-time buyer, looking to refinance, or considering a move, our mortgage specialists will help you understand every option — without the jargon or the pressure.</p>
            <ul class="grid sm:grid-cols-2 gap-3 mb-9">
                @foreach(['Conventional & FHA loans','Fixed & adjustable rates','First-time buyer programs','Refinancing & rate locks','Jumbo & portfolio options','Online application in minutes'] as $item)
                <li class="flex items-center gap-2.5 text-sm text-bank-100">
                    <svg class="w-4 h-4 text-accent-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ $item }}
                </li>
                @endforeach
            </ul>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('marketing.show', 'mortgages') }}" class="px-7 py-3.5 bg-accent-500 hover:bg-accent-600 text-white rounded-lg font-semibold text-sm transition-colors shadow-lg">Explore Mortgages</a>
                <a href="{{ route('marketing.show', 'payment-calculator') }}" class="px-7 py-3.5 border border-white/25 hover:bg-white/10 text-white rounded-lg font-semibold text-sm transition-colors">Calculate Your Payment</a>
            </div>
        </div>
    </div>
</section>

{{-- ========== 7. CREDIT CARDS ========== --}}
<section class="py-20 bg-bank-50">
    <div class="max-w-[1400px] mx-auto px-4 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <p class="text-accent-600 text-xs font-bold uppercase tracking-[0.2em] mb-3">Credit Cards</p>
            <h2 class="font-serif text-3xl md:text-4xl font-semibold text-bank-900 mb-4">A card that fits the way you spend</h2>
            <p class="text-bank-500">From everyday spending to premium travel, our card lineup rewards what matters to you — with straightforward fees and real benefits.</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @php $cards = [
                ['Everyday Cash','Flat cash back on all purchases','$0 annual fee','bg-bank-800','Cash Back Card','cash-back-card'],
                ['Travel Rewards','Points on travel & dining','Annual fee applies','bg-gradient-to-br from-bank-700 to-bank-900','Travel Rewards','travel-rewards-card'],
                ['Premium Elite','Elevated rewards and protections','Annual fee applies','bg-gradient-to-br from-amber-800 to-amber-600','Premium Card','premium-card'],
                ['Secured Starter','Build credit responsibly','$0 annual fee','bg-gradient-to-br from-bank-600 to-bank-800','Secured Card','secured-card'],
            ]; @endphp
            @foreach($cards as [$name,$reward,$fee,$gradient,$label,$slug])
            <div class="group">
                <div class="rounded-2xl p-7 text-white {{ $gradient }} shadow-lg mb-5 aspect-[1.586/1] flex flex-col justify-between transform transition-transform group-hover:-translate-y-1">
                    <div class="flex justify-between items-start">
                        <span class="text-[10px] uppercase tracking-[0.2em] text-white/50 font-semibold">{{ $label }}</span>
                        <svg class="w-6 h-6 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
                    </div>
                    <div>
                        <p class="font-mono text-base tracking-[0.15em] text-white/80">•••• •••• •••• 4821</p>
                        <p class="text-[11px] text-white/50 mt-2 uppercase tracking-wider">{{ $name }}</p>
                    </div>
                </div>
                <div class="px-1">
                    <p class="font-semibold text-bank-900 text-sm mb-1.5">{{ $reward }}</p>
                    <p class="text-xs text-bank-500 mb-3">{{ $fee }}</p>
                    <a href="{{ route('marketing.show', $slug) }}" class="text-xs font-semibold text-accent-600 hover:text-accent-700 inline-flex items-center gap-1">Details
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        <div class="flex flex-wrap justify-center gap-4 mt-12">
            <a href="{{ route('marketing.show', 'all-credit-cards') }}" class="px-7 py-3.5 bg-bank-800 hover:bg-bank-900 text-white rounded-lg font-semibold text-sm transition-colors">Compare Cards</a>
            <a href="{{ route('marketing.show', 'pre-qualification') }}" class="px-7 py-3.5 border border-bank-300 text-bank-700 hover:bg-white rounded-lg font-semibold text-sm transition-colors">Check Your Eligibility</a>
        </div>
        <p class="text-center text-[11px] text-bank-400 mt-6">Card designs and pricing are illustrative examples. Approval is subject to verification and underwriting.</p>
    </div>
</section>

{{-- ========== 8. CURRENT RATES ========== --}}
<section class="py-20 bg-white">
    <div class="max-w-[1400px] mx-auto px-4 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10">
            <div>
                <p class="text-accent-600 text-xs font-bold uppercase tracking-[0.2em] mb-3">Rates & Pricing</p>
                <h2 class="font-serif text-3xl md:text-4xl font-semibold text-bank-900">Today's Rates</h2>
                <p class="text-sm text-bank-500 mt-3">Competitive rates across our core deposit and lending products.</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('marketing.show', 'rates') }}" class="px-5 py-2.5 border border-bank-300 text-bank-700 hover:bg-bank-50 rounded-lg text-sm font-semibold transition-colors">View All Rates</a>
                <a href="{{ route('marketing.show', 'rate-calculator') }}" class="px-5 py-2.5 bg-bank-800 hover:bg-bank-900 text-white rounded-lg text-sm font-semibold transition-colors">Rate Calculator</a>
            </div>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @php $rates = [
                ['High-Yield Savings','4.50%','APY','Variable rate. No minimum balance.','emerald','high-yield-savings'],
                ['12-Month CD','4.75%','APY','Fixed rate. $1,000 minimum deposit.','bank','cds'],
                ['30-Year Fixed Mortgage','6.125%','APR','Based on 20% down payment. 30-year term.','navy','mortgages'],
                ['5-Year Auto Loan','6.45%','APR','Based on 60-month term. New vehicles.','amber','auto-loans'],
            ]; @endphp
            @foreach($rates as [$product,$rate,$type,$note,$tone,$slug])
            <div class="border border-gray-200 rounded-xl p-6 hover:border-bank-300 transition-colors">
                <div class="flex items-start justify-between mb-4">
                    <p class="font-semibold text-bank-800 text-sm leading-snug">{{ $product }}</p>
                    <span class="w-2 h-2 rounded-full mt-1.5 {{ $tone==='emerald'?'bg-emerald-500':($tone==='amber'?'bg-amber-500':($tone==='bank'?'bg-bank-400':'bg-bank-600')) }}"></span>
                </div>
                <p class="text-3xl font-bold text-bank-900 tracking-tight">{{ $rate }}<span class="text-sm font-medium text-bank-400 ml-1">{{ $type }}</span></p>
                <p class="text-xs text-bank-400 mt-2 leading-relaxed">{{ $note }}</p>
                <a href="{{ route('marketing.show', $slug) }}" class="text-xs font-semibold text-accent-600 hover:text-accent-700 inline-flex items-center gap-1 mt-4">View Details
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
            @endforeach
        </div>
        <p class="text-[11px] text-bank-400 mt-6">Rates shown are illustrative demo data for this prototype and do not represent actual offers. Effective date: {{ now()->format('F j, Y') }}.</p>
    </div>
</section>

{{-- ========== 9. FINANCIAL PLANNING ========== --}}
<section class="py-20 bg-white border-t border-gray-100">
    <div class="max-w-[1400px] mx-auto px-4 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <p class="text-accent-600 text-xs font-bold uppercase tracking-[0.2em] mb-3">Financial Planning</p>
            <h2 class="font-serif text-3xl md:text-4xl font-semibold text-bank-900 mb-4">Plan for what matters most</h2>
            <p class="text-bank-500">Whether you're building a safety net, buying a home, or planning retirement, our guidance starts with where you are and where you want to go.</p>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            @php $planning = [
                ['Save','Build an emergency fund and reach your savings goals.','emergency fund 3–6 months','piggy-bank','financial-planning'],
                ['Borrow','Understand your borrowing options and credit.','loans lines of credit','banknotes','borrowing'],
                ['Invest','Build long-term wealth through investment strategies.','brokerage retirement','chart-bar','investing'],
                ['Protect','Prepare for unexpected events and secure your future.','insurance estate planning','shield-check','insurance-planning'],
            ]; @endphp
            @foreach($planning as [$title,$desc,$tags,$icon,$slug])
            <div class="group">
                <div class="w-14 h-14 bg-bank-50 group-hover:bg-accent-50 rounded-xl flex items-center justify-center mb-5 transition-colors">
                    <svg class="w-6 h-6 text-bank-600 group-hover:text-accent-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        @switch($icon)
                            @case('piggy-bank')<path d="M18 11a6 6 0 00-12 0v5H4a1 1 0 00-1 1v3h3v2h2v-2h8v2h2v-2h3v-3a1 1 0 00-1-1h-2v-5z"/><path d="M14 8h.01M18 4l1.5 1.5"/></>
                            @case('banknotes')<rect x="2" y="6" width="20" height="12" rx="2"/><circle cx="12" cy="12" r="2.5"/><path d="M6 12h.01M18 12h.01"/></>
                            @case('chart-bar')<path d="M3 3v18h18M7 15v4M12 10v9M17 6v13"/></>
                            @case('shield-check')<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/></>
                        @endswitch
                    </svg>
                </div>
                <h3 class="font-semibold text-bank-900 text-lg mb-2">{{ $title }}</h3>
                <p class="text-sm text-bank-500 leading-relaxed mb-3">{{ $desc }}</p>
                <p class="text-[11px] text-bank-400 mb-4">Covers: {{ $tags }}</p>
                <a href="{{ route('marketing.show', $slug) }}" class="text-sm font-semibold text-accent-600 hover:text-accent-700 inline-flex items-center gap-1">Learn More
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ========== 10. FINANCIAL TOOLS ========== --}}
<section class="py-20 bg-bank-50">
    <div class="max-w-[1400px] mx-auto px-4 lg:px-8">
        <div class="max-w-2xl mb-12">
            <p class="text-accent-600 text-xs font-bold uppercase tracking-[0.2em] mb-3">Tools & Calculators</p>
            <h2 class="font-serif text-3xl md:text-4xl font-semibold text-bank-900 mb-4">Put the numbers to work for you</h2>
            <p class="text-bank-500">Free calculators to help you estimate payments, plan savings, and make more informed decisions.</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @php $tools = [
                ['Mortgage Calculator','Estimate your monthly payment.','home','mortgage-calculator'],
                ['Loan Payment','See what a loan would cost monthly.','calculator','payment-calculator'],
                ['Savings Calculator','Project how your savings can grow.','chart-line','savings-goal-calculator'],
                ['Compound Interest','Watch your money work over time.','percent','investment-growth'],
                ['Retirement Planner','Estimate your retirement readiness.','sun','retirement-planner'],
                ['Debt Payoff','Find your path out of debt.','trending-down','debt-payoff-calculator'],
                ['Auto Loan','Estimate your car payment.','truck','auto-loan-calculator'],
                ['Currency Converter','Quick currency reference.','globe','currency-converter'],
            ]; @endphp
            @foreach($tools as [$name,$desc,$icon,$slug])
            <a href="{{ route('marketing.show', $slug) }}" class="group bg-white border border-gray-200 rounded-xl p-6 lift flex flex-col">
                <div class="w-10 h-10 bg-bank-50 group-hover:bg-accent-50 rounded-lg flex items-center justify-center mb-4 transition-colors">
                    <svg class="w-5 h-5 text-bank-600 group-hover:text-accent-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        @switch($icon)
                            @case('home')<path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path d="M9 22V12h6v10"/></>
                            @case('calculator')<rect x="4" y="2" width="16" height="20" rx="2"/><path d="M8 6h8M8 11h.01M12 11h.01M16 11h.01M8 15h.01M12 15h.01M16 15v4M8 19h4"/></>
                            @case('chart-line')<path d="M3 3v18h18M7 14l4-4 3 3 5-6"/></>
                            @case('percent')<path d="M19 5L5 19"/><circle cx="7.5" cy="7.5" r="2.5"/><circle cx="16.5" cy="16.5" r="2.5"/></>
                            @case('sun')<circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/></>
                            @case('trending-down')<path d="M23 18l-6-6-4 4-7-7M14 9h6v6"/></>
                            @case('truck')<path d="M1 3h15v13H1zM16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></>
                            @case('globe')<circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/></>
                        @endswitch
                    </svg>
                </div>
                <p class="font-semibold text-bank-900 text-sm mb-1">{{ $name }}</p>
                <p class="text-xs text-bank-500 leading-relaxed mb-4">{{ $desc }}</p>
                <span class="text-xs font-semibold text-accent-600 group-hover:text-accent-700 inline-flex items-center gap-1 mt-auto">Calculate
                    <svg class="w-3 h-3 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </span>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ========== 11. DIGITAL BANKING ========== --}}
<section class="py-24 bg-bank-950 overflow-hidden">
    <div class="max-w-[1400px] mx-auto px-4 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <p class="text-accent-400 text-xs font-bold uppercase tracking-[0.2em] mb-3">Digital Banking</p>
                <h2 class="font-serif text-3xl md:text-4xl font-semibold text-white mb-5">Bank securely, wherever you are</h2>
                <p class="text-bank-300 leading-relaxed mb-8">Full-featured mobile banking with the speed you expect and the security you deserve. Check balances, deposit checks, pay bills, and transfer money from anywhere.</p>
                <div class="grid sm:grid-cols-2 gap-x-6 gap-y-3 mb-9">
                    @foreach(['Mobile banking 24/7','Mobile check deposit','Instant transaction alerts','Transfers & payments','Bill pay & scheduling','Card controls & freeze','Biometric login','Real-time fraud alerts'] as $feat)
                    <div class="flex items-center gap-2.5 text-sm text-bank-200">
                        <svg class="w-4 h-4 text-accent-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $feat }}
                    </div>
                    @endforeach
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('marketing.show', 'online-banking') }}" class="px-6 py-3 bg-accent-500 hover:bg-accent-600 text-white rounded-lg font-semibold text-sm transition-colors">Explore Digital Banking</a>
                    <a href="{{ route('marketing.show', 'mobile-app') }}" class="px-5 py-2.5 bg-white/10 hover:bg-white/15 border border-white/15 text-white rounded-lg text-sm font-semibold transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M17.05 20.28c-.98.95-2.05.8-3.08.35-1.09-.46-2.09-.48-3.24 0-1.44.62-2.2.44-3.06-.35C2.79 15.25 3.51 7.59 9.05 7.31c1.35.07 2.29.74 3.08.8 1.18-.24 2.31-.93 3.57-.84 1.51.12 2.65.72 3.4 1.8-3.12 1.87-2.38 5.98.48 7.13-.57 1.5-1.31 2.99-2.54 4.09l.01-.01zM12.03 7.25c-.15-2.23 1.66-4.07 3.74-4.25.29 2.58-2.34 4.5-3.74 4.25z"/></svg>
                        Get the Mobile App
                    </a>
                </div>
            </div>

            {{-- Phone mockup --}}
            <div class="flex justify-center lg:justify-end">
                <div class="relative w-[280px]">
                    <div class="absolute -inset-8 bg-accent-500/10 rounded-full blur-3xl"></div>
                    <div class="relative bg-bank-900 rounded-[2.5rem] border border-bank-700 p-2.5 shadow-2xl">
                        <div class="bg-white rounded-[2rem] overflow-hidden">
                            <div class="bg-bank-800 px-5 pt-3 pb-5 flex items-center justify-between text-white">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-accent-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M3 21h18M3 10h18M5 6l7-3 7 3M4 10v11M20 10v11M8 14v3M12 14v3M16 14v3"/></svg>
                                    <span class="text-xs font-bold">SecureBank</span>
                                </div>
                                <span class="text-[10px] text-bank-300">9:41</span>
                            </div>
                            <div class="p-4 bg-bank-50">
                                <p class="text-[10px] text-bank-400 uppercase tracking-wider font-semibold mb-2">Total Balance</p>
                                <p class="text-2xl font-bold text-bank-900 mb-4">$24,892<span class="text-sm">.50</span></p>
                                <div class="grid grid-cols-4 gap-2 mb-4">
                                    @foreach([['Transfer','M8 7h12M8 17H4m16 0l-4 4m4-4l-4-4'],['Deposit','M12 4v16m8-8H4'],['Pay','M3 6h18M7 12h10M11 18h2'],['Cards','M3 10h18M7 15h2']] as [$lbl,$path])
                                    <div class="bg-white rounded-lg py-2.5 flex flex-col items-center gap-1.5 shadow-sm">
                                        <svg class="w-4 h-4 text-bank-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $path }}"/></svg>
                                        <span class="text-[9px] text-bank-600 font-medium">{{ $lbl }}</span>
                                    </div>
                                    @endforeach
                                </div>
                                <p class="text-[10px] text-bank-500 font-semibold uppercase tracking-wider mb-2">Recent Activity</p>
                                <div class="space-y-2">
                                    @foreach([['Whole Foods','-$89.99',false],['Salary Deposit','+$5,200.00',true],['Shell Gas','-$45.50',false],['Netflix','-$12.99',false]] as [$name,$amt,$credit])
                                    <div class="bg-white rounded-lg px-3 py-2.5 flex items-center justify-between shadow-sm">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-7 h-7 rounded-full {{ $credit ? 'bg-emerald-100' : 'bg-bank-100' }} flex items-center justify-center">
                                                <svg class="w-3.5 h-3.5 {{ $credit ? 'text-emerald-600' : 'text-bank-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="{{ $credit ? 'M7 11l5-5m0 0l5 5m-5-5v12' : 'M17 13l-5 5m0 0l-5-5m5 5V6' }}"/></svg>
                                            </div>
                                            <span class="text-[11px] font-medium text-bank-800">{{ $name }}</span>
                                        </div>
                                        <span class="text-[11px] font-bold {{ $credit ? 'text-emerald-600' : 'text-bank-900' }}">{{ $amt }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="absolute -bottom-4 left-1/2 -translate-x-1/2 w-28 h-1 bg-bank-700 rounded-full"></div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ========== 12. SECURITY ========== --}}
<section class="py-20 bg-white">
    <div class="max-w-[1400px] mx-auto px-4 lg:px-8">
        <div class="max-w-2xl mb-12">
            <p class="text-accent-600 text-xs font-bold uppercase tracking-[0.2em] mb-3">Security Center</p>
            <h2 class="font-serif text-3xl md:text-4xl font-semibold text-bank-900 mb-4">Your security is our priority</h2>
            <p class="text-bank-500">We use multiple layers of protection to help keep your accounts and personal information safe — and to act quickly if something doesn't look right.</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-10">
            @php $security = [
                ['Fraud Monitoring','Continuous monitoring of your accounts for unusual activity.','eye'],
                ['Account Alerts','Real-time notifications for transactions and sign-ins.','bell'],
                ['Encryption','Data is encrypted in transit using current TLS standards.','lock'],
                ['Identity Protection','Multi-factor authentication and device recognition.','fingerprint'],
            ]; @endphp
            @foreach($security as [$title,$desc,$icon])
            <div class="border border-gray-200 rounded-xl p-6">
                <div class="w-11 h-11 bg-emerald-50 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-emerald-700" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        @switch($icon)
                            @case('eye')<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></>
                            @case('bell')<path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0"/></>
                            @case('lock')<rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></>
                            @case('fingerprint')<path d="M12 11a2 2 0 012 2c0 3-.5 6-2 8M8 21c1.5-2 2-5 2-8a2 2 0 114 0M5 21c1-2 1.5-4.5 1.5-8a5.5 5.5 0 0111 0c0 1.5-.1 3-.4 4.5M4 17c.4-1.3.6-2.7.6-4a7.4 7.4 0 0113.8-4"/></>
                        @endswitch
                    </svg>
                </div>
                <h3 class="font-semibold text-bank-900 text-sm mb-1.5">{{ $title }}</h3>
                <p class="text-xs text-bank-500 leading-relaxed">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
        <div class="bg-red-50 border border-red-200 rounded-xl p-6 flex flex-col sm:flex-row items-start sm:items-center gap-4">
            <div class="w-11 h-11 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v4m0 4h.01M10.3 3.9L1.8 18a2 2 0 001.7 3h17a2 2 0 001.7-3L13.7 3.9a2 2 0 00-3.4 0z"/></svg>
            </div>
            <div class="flex-1">
                <h3 class="font-semibold text-red-900 text-sm mb-1">See something you don't recognize?</h3>
                <p class="text-red-700 text-xs">Report it immediately. Our fraud team is available 24/7 and can freeze your cards and secure your accounts.</p>
            </div>
            <div class="flex gap-3 flex-shrink-0">
                <a href="{{ route('marketing.show', 'report-fraud') }}" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-semibold transition-colors">Report Fraud</a>
                <a href="{{ route('marketing.show', 'security-center') }}" class="px-5 py-2.5 border border-red-300 text-red-700 hover:bg-red-100 rounded-lg text-sm font-semibold transition-colors">Security Center</a>
            </div>
        </div>
    </div>
</section>

{{-- ========== 13. CUSTOMER SUPPORT ========== --}}
<section class="py-20 bg-bank-50 border-y border-gray-200">
    <div class="max-w-[1400px] mx-auto px-4 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <p class="text-accent-600 text-xs font-bold uppercase tracking-[0.2em] mb-3">Customer Support</p>
            <h2 class="font-serif text-3xl md:text-4xl font-semibold text-bank-900">We're here when you need us</h2>
            <p class="text-bank-500 mt-4">Reach us by phone, in person, or online — whichever works best for you.</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-5 gap-4">
            @php $support = [
                ['Call Us','Phone banking','Speak with a banking specialist.','phone','contact-us'],
                ['Visit a Branch','Search by ZIP code','Find a branch near you.','building-office','find-a-branch'],
                ['Help Center','Self-service','Answers to common questions.','book','help-center'],
                ['Secure Message','Online banking','Contact us securely.','chat','contact-us'],
                ['Live Chat','Available 24/5','Talk to a support representative.','computer','contact-us'],
            ]; @endphp
            @foreach($support as [$title,$meta,$desc,$icon,$slug])
            <a href="{{ route('marketing.show', $slug) }}" class="group bg-white border border-gray-200 rounded-xl p-6 text-center lift">
                <div class="w-11 h-11 bg-bank-50 group-hover:bg-accent-50 rounded-full flex items-center justify-center mx-auto mb-4 transition-colors">
                    <svg class="w-5 h-5 text-bank-600 group-hover:text-accent-600" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
                        @switch($icon)
                            @case('phone')<path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6A19.79 19.79 0 012.12 4.18 2 2 0 014.11 2h3a2 2 0 012 1.72c.13.96.36 1.9.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.9.34 1.85.57 2.81.7A2 2 0 0122 16.92z"/></>
                            @case('building-office')<path d="M3 21V5a2 2 0 012-2h8a2 2 0 012 2v16M15 21V9h4a2 2 0 012 2v10M1 21h22M7 7h2M7 11h2M7 15h2"/></>
                            @case('book')<path d="M4 19.5A2.5 2.5 0 016.5 17H20M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></>
                            @case('chat')<path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/></>
                            @case('computer')<rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></>
                        @endswitch
                    </svg>
                </div>
                <p class="font-semibold text-bank-900 text-sm mb-1">{{ $title }}</p>
                <p class="text-xs font-semibold text-accent-600 mb-1.5">{{ $meta }}</p>
                <p class="text-[11px] text-bank-400 leading-snug">{{ $desc }}</p>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ========== 14. BRANCH / ATM LOCATOR ========== --}}
<section class="py-20 bg-white">
    <div class="max-w-[1400px] mx-auto px-4 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <p class="text-accent-600 text-xs font-bold uppercase tracking-[0.2em] mb-3">Locations</p>
                <h2 class="font-serif text-3xl md:text-4xl font-semibold text-bank-900 mb-5">Find a branch or ATM</h2>
                <p class="text-bank-500 leading-relaxed mb-7">Search by city, state, or ZIP code to find a branch, ATM, or drive-thru near you, along with hours and available services.</p>
                <form class="space-y-4" onsubmit="event.preventDefault(); alert('Locator search will be available when the mapping API is connected.');">
                    <div>
                        <label for="locator-input" class="block text-xs font-semibold text-bank-600 uppercase tracking-wider mb-1.5">City, State, or ZIP Code</label>
                        <div class="relative">
                            <svg class="w-5 h-5 text-bank-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <input type="text" id="locator-input" placeholder="e.g. San Francisco, CA 94102" class="w-full pl-12 pr-4 py-3.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-accent-500/40 focus:border-accent-500 transition">
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <button type="submit" class="px-6 py-3 bg-bank-800 hover:bg-bank-900 text-white rounded-lg font-semibold text-sm transition-colors">Find a Branch</button>
                        <button type="submit" class="px-6 py-3 border border-bank-300 text-bank-700 hover:bg-bank-50 rounded-lg font-semibold text-sm transition-colors">Find an ATM</button>
                    </div>
                </form>
            </div>
            <div class="relative rounded-2xl overflow-hidden border border-gray-200 bg-bank-50 h-[380px]">
                <div class="absolute inset-0 opacity-40">
                    <svg class="w-full h-full" preserveAspectRatio="none" viewBox="0 0 800 400">
                        <defs><pattern id="mapgrid" width="50" height="50" patternUnits="userSpaceOnUse"><path d="M50 0H0v50" fill="none" stroke="#9fb3c8" stroke-width="0.5"/></pattern></defs>
                        <rect width="800" height="400" fill="url(#mapgrid)"/>
                        <path d="M0 280 Q200 240 400 300 T800 260" stroke="#bcccdc" stroke-width="3" fill="none"/>
                        <path d="M100 0 Q200 200 300 400" stroke="#bcccdc" stroke-width="2" fill="none"/>
                        <path d="M600 0 Q550 200 650 400" stroke="#bcccdc" stroke-width="2" fill="none"/>
                    </svg>
                </div>
                @foreach([[35,42,'bank'],[55,58,'bank'],[68,32,'atm'],[28,68,'atm'],[78,72,'atm'],[45,22,'bank']] as [$x,$y,$type])
                <div class="absolute" style="left:{{ $x }}%; top:{{ $y }}%">
                    @if($type === 'bank')
                        <div class="w-9 h-9 bg-bank-800 rounded-full flex items-center justify-center shadow-lg border-2 border-white">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 21h18M3 10h18M5 6l7-3 7 3M4 10v11M20 10v11"/></svg>
                        </div>
                    @else
                        <div class="w-7 h-7 bg-accent-500 rounded-full flex items-center justify-center shadow-lg border-2 border-white">
                            <span class="text-white text-[10px] font-bold">$</span>
                        </div>
                    @endif
                </div>
                @endforeach
                <div class="absolute bottom-4 left-4 right-4 bg-white/95 backdrop-blur rounded-lg px-4 py-3 flex items-center justify-between shadow-sm">
                    <p class="text-xs text-bank-500">Map preview — <span class="font-semibold text-bank-700">mapping API ready to connect</span></p>
                    <div class="flex items-center gap-3 text-[10px] text-bank-500">
                        <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 bg-bank-800 rounded-full"></span> Branch</span>
                        <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 bg-accent-500 rounded-full"></span> ATM</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ========== 15. TRUST / CREDIBILITY ========== --}}
<section class="py-20 bg-bank-950">
    <div class="max-w-[1400px] mx-auto px-4 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <p class="text-accent-400 text-xs font-bold uppercase tracking-[0.2em] mb-3">Our Institution</p>
            <h2 class="font-serif text-3xl md:text-4xl font-semibold text-white mb-4">Built on trust. Focused on your future.</h2>
            <p class="text-bank-400">Clear terms, plain-language disclosures, and straightforward guidance to help families and businesses build, grow, and protect what matters most.</p>
        </div>
        <div class="grid md:grid-cols-3 gap-6 text-center">
            @foreach([['Financial Strength','Capital and liquidity positions are reviewed on a regular basis and reported to regulators.','chart-bar'],['Deposit Protection','Deposit insurance terms, coverage limits, and eligibility requirements are disclosed in full before you open an account.','shield-check'],['Security Standards','Multi-factor authentication, device alerts, and transaction monitoring are layered across every digital channel.','lock']] as [$title,$desc,$icon])
            <div class="border border-white/10 rounded-xl p-7">
                <div class="w-11 h-11 bg-white/5 rounded-lg flex items-center justify-center mx-auto mb-4">
                    <svg class="w-5 h-5 text-accent-400" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
                        @switch($icon)
                            @case('chart-bar')<path d="M3 3v18h18M7 15v4M12 10v9M17 6v13"/></>
                            @case('shield-check')<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/></>
                            @case('lock')<rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></>
                        @endswitch
                    </svg>
                </div>
                <h3 class="font-semibold text-white text-sm mb-2">{{ $title }}</h3>
                <p class="text-xs text-bank-400 leading-relaxed">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
        <p class="text-center text-[11px] text-bank-600 mt-10">Illustrative figures for prototype demonstration. Not a representation of a real institution's financials.</p>
    </div>
</section>

{{-- ========== 16. BUSINESS BANKING ========== --}}
<section class="py-20 bg-bank-50">
    <div class="max-w-[1400px] mx-auto px-4 lg:px-8">
        <div class="grid lg:grid-cols-12 gap-12 items-center">
            <div class="lg:col-span-5">
                <p class="text-accent-600 text-xs font-bold uppercase tracking-[0.2em] mb-3">Business Banking</p>
                <h2 class="font-serif text-3xl md:text-4xl font-semibold text-bank-900 mb-5">Banking that helps businesses move forward</h2>
                <p class="text-bank-500 leading-relaxed mb-8">From a sole proprietorship to an enterprise, we bring the same rigor to business banking that we'd want for our own finances — with dedicated specialists who understand your industry.</p>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('marketing.show', 'business-banking') }}" class="px-6 py-3 bg-bank-800 hover:bg-bank-900 text-white rounded-lg font-semibold text-sm transition-colors">Explore Business Banking</a>
                    <a href="{{ route('marketing.show', 'open-business-account') }}" class="px-6 py-3 border border-bank-300 text-bank-700 hover:bg-white rounded-lg font-semibold text-sm transition-colors">Open a Business Account</a>
                </div>
            </div>
            <div class="lg:col-span-7 grid sm:grid-cols-2 gap-4">
            @php $biz = [
                ['Business Checking','Flexible everyday banking with real-time visibility.','banknotes','business-checking'],
                ['Business Savings','Earn interest on operating reserves.','archive-box','business-savings'],
                ['Business Credit Cards','Custom limits and rewards for every category.','credit-card','business-credit-card'],
                ['Business Loans','Working capital, equipment, and growth financing.','briefcase','business-loans'],
                ['Merchant Services','In-person and online payment processing.','device-phone','merchant-services'],
                ['Payroll & Payments','Direct deposit, tax payments, and vendor runs.','users','payroll-services'],
                ['Cash Management','Automated sweeps, approvals, and forecasting.','arrows-right-left','cash-management'],
                ['Treasury Services','Liquidity, forecasting, and risk controls.','building-library','treasury-management'],
            ]; @endphp
                @foreach($biz as [$title,$desc,$icon,$slug])
                <a href="{{ route('marketing.show', $slug) }}" class="group bg-white border border-gray-200 rounded-xl p-5 lift flex items-start gap-3.5">
                    <div class="w-10 h-10 bg-bank-50 group-hover:bg-accent-50 rounded-lg flex items-center justify-center flex-shrink-0 transition-colors">
                        <svg class="w-5 h-5 text-bank-500 group-hover:text-accent-600" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                            @switch($icon)
                                @case('banknotes')<rect x="2" y="6" width="20" height="12" rx="2"/><circle cx="12" cy="12" r="2.5"/></>
                                @case('archive-box')<path d="M3 8v11a2 2 0 002 2h14a2 2 0 002-2V8M2 3h20v5H2z"/></>
                                @case('credit-card')<rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></>
                                @case('briefcase')<rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"/></>
                                @case('device-phone')<rect x="5" y="2" width="14" height="20" rx="2"/><path d="M12 18h.01"/></>
                                @case('users')<path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></>
                                @case('arrows-right-left')<path d="M8 3L4 7l4 4M4 7h16M16 21l4-4-4-4M20 17H4"/></>
                                @case('building-library')<path d="M3 21h18M5 21V10M19 21V10M9 21V10M15 21V10M3 10l9-7 9 7H3z"/></>
                            @endswitch
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-bank-900 text-sm mb-0.5">{{ $title }}</p>
                        <p class="text-xs text-bank-500 leading-snug">{{ $desc }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ========== 17. WEALTH MANAGEMENT ========== --}}
<section class="relative py-24 overflow-hidden bg-bank-900">
    <div class="absolute inset-0 opacity-[0.07]">
        <svg class="w-full h-full" preserveAspectRatio="none"><defs><pattern id="grid" width="60" height="60" patternUnits="userSpaceOnUse"><path d="M60 0H0v60" fill="none" stroke="white" stroke-width="0.5"/></pattern></defs><rect width="100%" height="100%" fill="url(#grid)"/></svg>
    </div>
    <div class="relative max-w-[1400px] mx-auto px-4 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <p class="text-accent-400 text-xs font-bold uppercase tracking-[0.2em] mb-3">Wealth Management</p>
                <h2 class="font-serif text-3xl md:text-4xl font-semibold text-white mb-5">A deeper approach to wealth</h2>
                <p class="text-bank-300 leading-relaxed mb-8">Wealth isn't just a number — it's security for your family, freedom of choice, and the ability to pursue what matters. Our advisors bring a fiduciary standard to every relationship.</p>
                <div class="grid sm:grid-cols-2 gap-x-6 gap-y-3 mb-9">
                    @foreach(['Investment management','Retirement planning','Private banking','Estate & legacy planning','Tax-aware investing','Family office services'] as $item)
                    <div class="flex items-center gap-2.5 text-sm text-bank-200">
                        <svg class="w-4 h-4 text-accent-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $item }}
                    </div>
                    @endforeach
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('marketing.show', 'private-banking') }}" class="px-7 py-3.5 bg-accent-500 hover:bg-accent-600 text-white rounded-lg font-semibold text-sm transition-colors">Explore Wealth Management</a>
                    <a href="{{ route('marketing.show', 'contact-us') }}" class="px-7 py-3.5 border border-white/25 hover:bg-white/10 text-white rounded-lg font-semibold text-sm transition-colors">Talk to an Advisor</a>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                @php $wealthServices = [
                    ['Fee-Only Advisory','Transparent pricing with no commissions on recommendations.'],
                    ['Personalized Portfolios','Portfolios aligned to your goals, timeline, and risk profile.'],
                    ['Retirement Planning','Distribution strategies, tax considerations, and income planning.'],
                    ['Legacy &amp; Trust Services','Estate coordination and continuity planning for family assets.'],
                ]; @endphp
                @foreach($wealthServices as [$val,$lbl])
                <div class="bg-white/5 border border-white/10 rounded-xl p-6 backdrop-blur-sm">
                    <p class="text-base font-bold text-white mb-1.5 leading-snug">{{ $val }}</p>
                    <p class="text-xs text-bank-400 leading-snug">{{ $lbl }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ========== 18. FINANCIAL EDUCATION ========== --}}
<section class="py-20 bg-white">
    <div class="max-w-[1400px] mx-auto px-4 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-12">
            <div>
                <p class="text-accent-600 text-xs font-bold uppercase tracking-[0.2em] mb-3">Insights & Education</p>
                <h2 class="font-serif text-3xl md:text-4xl font-semibold text-bank-900">Financial insights for every stage of life</h2>
            </div>
            <a href="{{ route('marketing.show', 'insights') }}" class="text-sm font-semibold text-bank-700 hover:text-accent-600 transition-colors inline-flex items-center gap-1.5 shrink-0">View All Insights
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @php $articles = [
                ['How to build an emergency fund','Saving','5 min read','emergency','emergency-fund'],
                ['Understanding your credit score','Credit','7 min read','credit-score','credit-score'],
                ['How mortgages actually work','Home','8 min read','home','mortgage'],
                ['Saving for your child\'s education','Planning','6 min read','education','college-fund'],
                ['Preparing for retirement','Retirement','10 min read','retirement','retirement'],
                ['Managing debt strategically','Debt','6 min read','debt','debt'],
                ['Recognizing financial scams','Security','4 min read','security','scam'],
            ]; @endphp
            @foreach($articles as [$title,$cat,$time,$img,$alt])
            <article class="group cursor-pointer">
                <div class="aspect-[16/10] rounded-xl overflow-hidden bg-bank-100 mb-4">
                    <img src="https://images.unsplash.com/photo-{{ ['emergency-fund'=>'1454165804606-c3d57bc86b40','credit-score'=>'1554224154-22dec7ec881c','mortgage'=>'1560518883-ce09059eeffa','college-fund'=>'1523050854058-8df90110c9f1','retirement'=>'1544005313-94ddf0286df2','debt'=>'1554224155-8d04cb21cd6c','scam'=>'1563013544-824ae1b704d3'][$alt] }}?w=600&q=75&fit=crop" alt="{{ $alt }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                <p class="text-[10px] font-bold uppercase tracking-widest text-accent-600 mb-2">{{ $cat }}</p>
                <h3 class="font-semibold text-bank-900 leading-snug mb-2 group-hover:text-accent-700 transition-colors">{{ $title }}</h3>
                <div class="flex items-center gap-3 text-[11px] text-bank-400">
                    <span>{{ $time }}</span>
                    <span class="w-1 h-1 rounded-full bg-bank-300"></span>
                    <span class="font-semibold text-bank-600 group-hover:text-accent-600 transition-colors">Read More →</span>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>

{{-- ========== 19. COMMUNITY ========== --}}
<section class="relative py-24 overflow-hidden">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=1800&q=80" alt="" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-bank-950/92 to-bank-950/55"></div>
    </div>
    <div class="relative max-w-[1400px] mx-auto px-4 lg:px-8">
        <div class="max-w-xl">
            <p class="text-accent-400 text-xs font-bold uppercase tracking-[0.2em] mb-3">Community Impact</p>
            <h2 class="font-serif text-3xl md:text-4xl font-semibold text-white mb-5">Investing in the communities we serve</h2>
            <p class="text-bank-200 leading-relaxed mb-8">A bank is only as strong as the communities it operates in. Through grants, financial education programs, and small-business lending, we're committed to expanding access and building lasting economic opportunity.</p>
            <div class="grid grid-cols-3 gap-6 mb-9 max-w-md">
                @foreach([['Grants','Funding for local nonprofit and civic organizations'],['Education','Free financial workshops and one-on-one coaching'],['Small Business','Credit and guidance for local business owners']] as [$v,$l])
                <div>
                    <p class="text-lg font-bold text-white leading-tight">{{ $v }}</p>
                    <p class="text-[11px] text-bank-300 mt-1 leading-snug">{{ $l }}</p>
                </div>
                @endforeach
            </div>
            <a href="{{ route('marketing.show', 'community') }}" class="inline-flex items-center gap-2 px-7 py-3.5 bg-accent-500 hover:bg-accent-600 text-white rounded-lg font-semibold text-sm transition-colors">Our Community Impact
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </div>
</section>

{{-- ========== 20. CUSTOMER STORIES ========== --}}
<section class="py-20 bg-white">
    <div class="max-w-[1400px] mx-auto px-4 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <p class="text-accent-600 text-xs font-bold uppercase tracking-[0.2em] mb-3">Customer Stories</p>
            <h2 class="font-serif text-3xl md:text-4xl font-semibold text-bank-900 mb-4">Banking built around real people</h2>
            <p class="text-bank-500">We serve over 2 million customers. Here's a sample of what that means in their words.</p>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            @php $stories = [
                ['Maya R.','Portland, OR','Small Business Owner','I moved my business banking here because a real person answered the phone. My banker knows my name, my industry, and what I\'m trying to build. That\'s rare.','Maya R.'],
                ['James & Priya T.','Austin, TX','First-Time Homebuyers','The mortgage team walked us through every option without ever making us feel rushed. We closed in thirty days and saved thousands versus the estimate.','James T.'],
                ['Robert K.','Scottsdale, AZ','Retiree','After thirty years of managing a portfolio elsewhere, I wanted someone local who would take the time to explain things. I found that here.','Robert K.'],
            ]; @endphp
            @foreach($stories as [$name,$loc,$type,$quote,$alt])
            <figure class="border border-gray-200 rounded-xl p-7 flex flex-col lift">
                <svg class="w-8 h-8 text-accent-200 mb-4" fill="currentColor" viewBox="0 0 24 24"><path d="M13.5 5C9 5 5 9 5 14c0 3 2 5 5 5s5-2 5-5c0-2-1-4-3-4 0-2 1-3 3-4l-1.5-1zM21 5c-4.5 0-8.5 4-8.5 9 0 3 2 5 5 5s5-2 5-5c0-2-1-4-3-4 0-2 1-3 3-4L21 5z"/></svg>
                <blockquote class="text-sm text-bank-600 leading-relaxed flex-1 mb-6">"{{ $quote }}"</blockquote>
                <figcaption class="flex items-center gap-3 pt-5 border-t border-gray-100">
                    <div class="w-10 h-10 bg-bank-100 rounded-full flex items-center justify-center text-sm font-bold text-bank-600">{{ substr($name,0,1) }}</div>
                    <div>
                        <p class="text-sm font-semibold text-bank-900">{{ $name }}</p>
                        <p class="text-[11px] text-bank-400">{{ $loc }} &middot; {{ $type }}</p>
                    </div>
                </figcaption>
            </figure>
            @endforeach
        </div>
        <p class="text-center text-[11px] text-bank-400 mt-8">Sample testimonials shown for demonstration purposes in this prototype.</p>
    </div>
</section>

{{-- ========== 21. FINAL CTA ========== --}}
<section class="py-24 bg-white">
    <div class="max-w-3xl mx-auto px-4 lg:px-8 text-center">
        <h2 class="font-serif text-3xl md:text-4xl font-semibold text-bank-900 mb-5">Ready to take the next step?</h2>
        <p class="text-lg text-bank-500 leading-relaxed mb-9">Whether you're opening your first account, buying a home, growing your business, or planning for the future, we're here to help you move forward with confidence.</p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('register') }}" class="px-9 py-4 bg-bank-800 hover:bg-bank-900 text-white rounded-lg font-semibold transition-all shadow-lg shadow-bank-800/20">Open an Account</a>
            <a href="{{ route('marketing.show', 'contact-us') }}" class="px-9 py-4 border border-bank-300 text-bank-700 hover:bg-bank-50 rounded-lg font-semibold transition-colors">Talk to a Banker</a>
        </div>
    </div>
</section>

{{-- ========== 22. FOOTER ========== --}}
<footer class="bg-bank-950 text-bank-400">
    <div class="max-w-[1400px] mx-auto px-4 lg:px-8 pt-16 pb-10">
        <div class="grid md:grid-cols-2 lg:grid-cols-6 gap-10 mb-14">
            <div class="lg:col-span-2">
                <div class="flex items-center gap-2.5 mb-4">
                    <div class="w-9 h-9 bg-white/10 rounded-md flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M3 21h18M3 10h18M5 6l7-3 7 3M4 10v11M20 10v11M8 14v3M12 14v3M16 14v3"/></svg>
                    </div>
                    <span class="font-bold text-white text-lg">SecureBank</span>
                </div>
                <p class="text-sm leading-relaxed mb-6 max-w-sm">Secure, modern banking for individuals, families, and businesses. Regulatory status, licensing, and disclosure documents are published in the Disclosures section.</p>
                <a href="{{ route('marketing.show', 'newsroom') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-accent-400 hover:text-accent-300 transition-colors">
                    Company news &amp; announcements
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
            @php $footerCols = [
                ['Banking',['checking-accounts','savings-accounts','credit-cards','cds','personal-loans','auto-loans']],
                ['Borrowing',['home-loans','mortgages','rate-refinance','line-of-credit','student-loans','business-loans']],
                ['Invest & Protect',['investing','private-banking','retirement-planning','insurance-planning','trust-services','estate-planning']],
                ['Support',['contact-us','help-center','find-a-branch','find-atm','security-center','report-fraud']],
                ['Company',['about','careers','investor-relations','newsroom','community','sustainability']],
            ]; @endphp
            @foreach($footerCols as [$heading,$links])
            <div>
                <h3 class="text-white font-semibold text-sm mb-4">{{ $heading }}</h3>
                <ul class="space-y-2.5 text-[13px]">
                    @foreach($links as $slug)
                    <li><a href="{{ route('marketing.show', $slug) }}" @if(request()->route('page') === $slug) aria-current="page" @endif class="hover:text-white transition-colors">{{ \App\Support\MarketingCatalog::get($slug)['title'] }}</a></li>
                    @endforeach
                </ul>
            </div>
            @endforeach
        </div>

        <div class="border-t border-white/10 pt-8">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 mb-6">
                <div class="flex flex-wrap items-center gap-x-6 gap-y-3 text-[11px] text-bank-500">
                    <span class="flex items-center gap-1.5"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> Deposit protection details available on request</span>
                    <a href="{{ route('marketing.show', 'licensing') }}" class="hover:text-bank-200 transition-colors">Licensing &amp; Regulatory Filings</a>
                    <a href="{{ route('marketing.show', 'institution-details') }}" class="hover:text-bank-200 transition-colors">Official Institution Details</a>
                </div>
                <div class="flex gap-2.5">
                    <a href="{{ route('marketing.show', 'mobile-app') }}" class="px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 rounded-lg text-[11px] font-medium text-bank-300 hover:text-white transition-colors flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.05 20.28c-.98.95-2.05.8-3.08.35-1.09-.46-2.09-.48-3.24 0-1.44.62-2.2.44-3.06-.35C2.79 15.25 3.51 7.59 9.05 7.31c1.35.07 2.29.74 3.08.8 1.18-.24 2.31-.93 3.57-.84 1.51.12 2.65.72 3.4 1.8-3.12 1.87-2.38 5.98.48 7.13-.57 1.5-1.31 2.99-2.54 4.09l.01-.01zM12.03 7.25c-.15-2.23 1.66-4.07 3.74-4.25.29 2.58-2.34 4.5-3.74 4.25z"/></svg>
                        Download the App
                    </a>
                </div>
            </div>
            <div class="flex flex-col lg:flex-row justify-between items-center gap-4 text-[11px] text-bank-500">
                <p>&copy; 2026 SecureBank, N.A. All rights reserved.</p>
                <div class="flex flex-wrap justify-center gap-x-5 gap-y-2">
                    <a href="{{ route('marketing.show', 'privacy') }}" class="hover:text-bank-200 transition-colors">Privacy Policy</a>
                    <a href="{{ route('marketing.show', 'terms') }}" class="hover:text-bank-200 transition-colors">Terms &amp; Conditions</a>
                    <a href="{{ route('marketing.show', 'accessibility') }}" class="hover:text-bank-200 transition-colors">Accessibility</a>
                    <a href="{{ route('marketing.show', 'security') }}" class="hover:text-bank-200 transition-colors">Security</a>
                    <a href="{{ route('marketing.show', 'disclosures') }}" class="hover:text-bank-200 transition-colors">Disclosures</a>
                    <a href="{{ route('marketing.show', 'cookie-policy') }}" class="hover:text-bank-200 transition-colors">Cookie Policy</a>
                </div>
            </div>
            <p class="text-[10px] text-bank-600 mt-6 leading-relaxed max-w-5xl">
                This website is a demonstration prototype. All products, rates, statistics, testimonials, and regulatory references are illustrative and do not constitute actual banking offers, investment advice, or a solicitation of any kind. Deposit insurance descriptions are for general informational purposes. Rates shown are examples only and subject to change. Please consult actual disclosures before making financial decisions.
            </p>
        </div>
    </div>
</footer>

@endsection
