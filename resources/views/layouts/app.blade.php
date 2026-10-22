<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SecureBank') — Secure, Modern Banking</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        theme: {
            extend: {
                fontFamily: {
                    sans: ['"Source Sans 3"', 'system-ui', 'sans-serif'],
                    serif: ['"Playfair Display"', 'Georgia', 'serif'],
                },
                colors: {
                    bank: {
                        50:'#f0f4f8', 100:'#d9e2ec', 200:'#bcccdc', 300:'#9fb3c8',
                        400:'#829ab1', 500:'#627d98', 600:'#486581', 700:'#334e68',
                        800:'#243b53', 900:'#102a43', 950:'#0a1929',
                    },
                    brand: {
                        50:'#f0f4f8', 100:'#d9e2ec', 200:'#bcccdc', 300:'#9fb3c8',
                        400:'#829ab1', 500:'#627d98', 600:'#486581', 700:'#334e68',
                        800:'#243b53', 900:'#102a43', 950:'#0a1929',
                    },
                    accent: {
                        50:'#fdf8ef', 100:'#f9edd4', 200:'#f2d8a8', 300:'#e9be72',
                        400:'#dfa445', 500:'#d18e2a', 600:'#b97520', 700:'#9a5c1c',
                        800:'#7d4a1e', 900:'#663d1c',
                    },
                },
            },
        },
    }
    </script>
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        html { -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }

        /* Mega menu */
        .mega-trigger:hover .mega-panel,
        .mega-trigger:focus-within .mega-panel { opacity:1; visibility:visible; transform:translateY(0); }
        .mega-panel { opacity:0; visibility:hidden; transform:translateY(4px); transition: all .2s ease; }

        /* Mobile drawer */
        .drawer-overlay { opacity:0; pointer-events:none; transition: opacity .3s ease; }
        .drawer-overlay.open { opacity:1; pointer-events:auto; }
        .drawer-panel { transform:translateX(-100%); transition: transform .3s cubic-bezier(.4,0,.2,1); }
        .drawer-panel.open { transform:translateX(0); }

        /* Subtle reveal on scroll */
        .reveal { opacity:0; transform:translateY(24px); transition: all .6s cubic-bezier(.25,.46,.45,.94); }
        .reveal.visible { opacity:1; transform:translateY(0); }
        /* Safety net: never leave content hidden if JS is unavailable */
        .no-js .reveal, noscript .reveal { opacity:1 !important; transform:none !important; }
        @media (prefers-reduced-motion: reduce) {
            .reveal, .reveal.visible { opacity:1 !important; transform:none !important; transition:none !important; }
            .card-mockup .card-inner, .card-mockup:hover .card-inner { transform:none !important; transition:none !important; }
            .lift, .lift:hover { transform:none !important; box-shadow:0 8px 30px rgba(0,0,0,.08); transition:none !important; }
            .drawer-panel, .mega-panel, .accordion-content, .accordion-icon { transition:none !important; }
            * { scroll-behavior:auto !important; }
        }

        /* Card lift */
        .lift { transition: box-shadow .25s ease, transform .25s ease; }
        .lift:hover { box-shadow:0 8px 30px rgba(0,0,0,.08); transform:translateY(-3px); }

        /* Focus visible */
        :focus-visible { outline:2px solid #d18e2a; outline-offset:2px; border-radius:4px; }

        /* Rates ticker */
        .rates-bar { animation: scrollLeft 30s linear infinite; }
        @keyframes scrollLeft { 0%{transform:translateX(0)} 100%{transform:translateX(-50%)} }
        @media (prefers-reduced-motion: reduce) { .rates-bar { animation:none; } }

        /* Hero gradient */
        .hero-bg { background: linear-gradient(135deg, #0a1929 0%, #102a43 40%, #243b53 100%); }

        /* Credit card mockup */
        .card-mockup { perspective: 1000px; }
        .card-mockup .card-inner { transition: transform .6s cubic-bezier(.25,.46,.45,.94); transform-style: preserve-3d; }
        .card-mockup:hover .card-inner { transform: rotateY(-8deg) rotateX(4deg); }

        /* Mobile accordion */
        .accordion-content { max-height:0; overflow:hidden; transition: max-height .3s ease; }
        .accordion-content.open { max-height:500px; }
        .accordion-icon { transition: transform .3s ease; }
        .accordion-icon.open, details[open] .accordion-icon { transform: rotate(45deg); }
        details > summary { list-style: none; }
        details > summary::-webkit-details-marker { display: none; }
        details > summary:focus-visible { outline:2px solid #d18e2a; outline-offset:-2px; }

        /* Smooth scroll */
        html { scroll-behavior: smooth; }
        @media (prefers-reduced-motion: reduce) { html { scroll-behavior: auto; } }
    </style>
    <script>document.documentElement.classList.add('js');</script>
    @stack('styles')
</head>
<body class="bg-white text-bank-800 font-sans">
@php
    use App\Support\MarketingCatalog;
    /** Resolve a navigation label or slug to a real marketing page URL. */
    $m = static fn (?string $label, string $fallback = 'banking'): string => MarketingCatalog::url($label, $fallback);
@endphp
@auth
    {{-- ═══ AUTHENTICATED LAYOUT ═══ --}}
    <div class="min-h-screen flex flex-col">
        {{-- Top Utility Bar --}}
        <div class="bg-bank-950 text-bank-300 text-[13px] hidden lg:block border-b border-bank-800/50">
            <div class="max-w-[1400px] mx-auto px-8 flex justify-between items-center h-9">
                <div class="flex items-center gap-1">
                    <span class="text-bank-100 font-semibold cursor-default">Personal</span>
                    <span class="text-bank-600 mx-1">|</span>
                    <a href="{{ $m('business-banking', 'business-banking') }}" class="hover:text-white transition-colors">Business</a>
                    <span class="text-bank-600 mx-1">|</span>
                    <a href="{{ $m('private-banking', 'wealth-management') }}" class="hover:text-white transition-colors">Wealth</a>
                    <span class="text-bank-600 mx-1">|</span>
                    <a href="{{ $m('institutional') }}" class="hover:text-white transition-colors">Institutional</a>
                    <span class="text-bank-600 mx-1">|</span>
                    <a href="{{ $m('about') }}" class="hover:text-white transition-colors">About Us</a>
                </div>
                <div class="flex items-center gap-1">
                    <a href="{{ $m('investor-relations') }}" class="hover:text-white transition-colors px-2">Investor Relations</a>
                    <span class="text-bank-600">|</span>
                    <a href="{{ $m('careers') }}" class="hover:text-white transition-colors px-2">Careers</a>
                    <span class="text-bank-600">|</span>
                    <a href="{{ $m('help-support') }}" class="hover:text-white transition-colors px-2">Help & Support</a>
                </div>
            </div>
        </div>

        {{-- Main Header --}}
        <header class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
            <div class="max-w-[1400px] mx-auto px-4 lg:px-8 flex items-center justify-between h-[68px]">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 shrink-0">
                    <div class="w-9 h-9 bg-bank-800 rounded-md flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M3 21h18M3 10h18M5 6l7-3 7 3M4 10v11M20 10v11M8 14v3M12 14v3M16 14v3"/></svg>
                    </div>
                    <span class="text-bank-900 font-bold text-xl tracking-tight hidden sm:block">SecureBank</span>
                </a>

                <nav class="hidden lg:flex items-center gap-0.5 h-full">
                    @php
                        $navItems = [
                            ['label' => 'Dashboard', 'route' => 'dashboard', 'pattern' => 'dashboard'],
                            ['label' => 'Accounts', 'route' => 'accounts.index', 'pattern' => 'accounts.*'],
                            ['label' => 'Transactions', 'route' => 'transactions.index', 'pattern' => 'transactions.*'],
                        ];
                    @endphp
                    @foreach($navItems as $item)
                        <a href="{{ route($item['route']) }}"
                           @if (request()->routeIs($item['pattern'])) aria-current="page" @endif
                           class="px-4 py-2 text-[15px] font-medium rounded-md transition-colors {{ request()->routeIs($item['pattern']) ? 'text-bank-900 bg-bank-50' : 'text-bank-600 hover:text-bank-900 hover:bg-gray-50' }}">
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </nav>

                <div class="flex items-center gap-3">
                    <a href="{{ route('transfer') }}" class="hidden sm:inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-bank-700 bg-bank-50 hover:bg-bank-100 rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                        Transfer
                    </a>
                    <div class="w-px h-6 bg-gray-200 hidden sm:block"></div>
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-bank-700 rounded-full flex items-center justify-center text-white text-xs font-bold">{{ substr(Auth::user()->name,0,1) }}</div>
                        <span class="text-sm font-medium text-bank-800 hidden md:block">{{ explode(' ',Auth::user()->name)[0] }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-bank-400 hover:text-bank-700 transition-colors ml-1" title="Sign Out">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        </button>
                    </form>
                    <button type="button" id="mobile-toggle" class="lg:hidden p-2 -mr-2 text-bank-600" aria-label="Open menu" aria-expanded="false" aria-controls="drawer-panel">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                </div>
            </div>
        </header>

        {{-- Flash Messages --}}
        @if(session('success') || session('error'))
        <div class="max-w-[1400px] mx-auto w-full px-4 lg:px-8 pt-4">
            @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-3 rounded-lg flex items-center gap-3 text-sm" role="alert">
                <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 px-5 py-3 rounded-lg flex items-center gap-3 text-sm" role="alert">
                <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('error') }}
            </div>
            @endif
        </div>
        @endif

        <main class="flex-1 max-w-[1400px] mx-auto w-full px-4 lg:px-8 py-6 lg:py-8">
            @yield('content')
        </main>

        <footer class="bg-bank-950 text-bank-400 mt-auto border-t border-bank-800">
            <div class="max-w-[1400px] mx-auto px-8 py-6 flex flex-col sm:flex-row justify-between items-center gap-3 text-xs">
                <div class="flex items-center gap-4">
                    <span class="font-semibold text-bank-200">SecureBank</span>
                    <span>&copy; 2026 All rights reserved.</span>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ $m('privacy') }}" class="hover:text-bank-200 transition-colors">Privacy</a>
                    <span class="text-bank-700">|</span>
                    <a href="{{ $m('terms') }}" class="hover:text-bank-200 transition-colors">Terms</a>
                    <span class="text-bank-700">|</span>
                    <a href="{{ $m('disclosures') }}" class="hover:text-bank-200 transition-colors">Disclosures</a>
                </div>
            </div>
        </footer>
    </div>

    {{-- Mobile Drawer --}}
    <div id="drawer-overlay" class="drawer-overlay fixed inset-0 bg-black/40 z-[60] lg:hidden" aria-hidden="true"></div>
    <div role="dialog" aria-modal="true" aria-label="Mobile navigation" tabindex="-1" aria-hidden="true" id="drawer-panel" class="drawer-panel fixed inset-y-0 left-0 w-[320px] max-w-[85vw] bg-white z-[70] lg:hidden shadow-2xl flex flex-col">
        <div class="flex items-center justify-between px-5 h-16 border-b border-gray-100">
            <span class="font-bold text-bank-900 text-lg">SecureBank</span>
            <button type="button" id="drawer-close" class="p-2 -mr-2 text-bank-500 hover:text-bank-800" aria-label="Close menu">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <nav class="flex-1 overflow-y-auto py-4 px-5 space-y-1" aria-label="Mobile">
            <a href="{{ route('dashboard') }}" class="block py-2.5 text-sm font-medium text-bank-900 {{ request()->routeIs('dashboard') ? 'text-accent-600' : '' }}">Dashboard</a>
            <a href="{{ route('accounts.index') }}" class="block py-2.5 text-sm font-medium text-bank-600 hover:text-bank-900">Accounts</a>
            <a href="{{ route('transactions.index') }}" class="block py-2.5 text-sm font-medium text-bank-600 hover:text-bank-900">Transactions</a>
            <div class="border-t border-gray-100 my-3"></div>
            <a href="{{ route('transfer') }}" class="block py-2.5 text-sm font-medium text-bank-600 hover:text-bank-900">Transfer</a>
            <a href="{{ route('deposit') }}" class="block py-2.5 text-sm font-medium text-bank-600 hover:text-bank-900">Deposit</a>
            <a href="{{ route('withdraw') }}" class="block py-2.5 text-sm font-medium text-bank-600 hover:text-bank-900">Withdraw</a>
            <div class="border-t border-gray-100 my-3"></div>
            <a href="{{ $m('find-a-branch') }}" class="block py-2.5 text-sm font-medium text-bank-600 hover:text-bank-900">Find a Branch</a>
            <a href="{{ $m('find-atm') }}" class="block py-2.5 text-sm font-medium text-bank-600 hover:text-bank-900">Find an ATM</a>
            <a href="{{ $m('help-support') }}" class="block py-2.5 text-sm font-medium text-bank-600 hover:text-bank-900">Help & Support</a>
        </nav>
        <div class="border-t border-gray-100 p-5">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full py-2.5 text-sm font-semibold text-bank-600 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">Sign Out</button>
            </form>
        </div>
    </div>

@else
    {{-- ═══ GUEST LAYOUT ═══ --}}
    {{-- Utility Bar --}}
    <div class="bg-bank-950 text-bank-400 text-[13px] hidden lg:block">
        <div class="max-w-[1400px] mx-auto px-8 flex justify-between items-center h-9">
            <div class="flex items-center gap-1">
                <span class="text-bank-100 font-semibold">Personal</span>
                <span class="text-bank-700 mx-1">|</span>
                <a href="{{ $m('business-banking') }}" class="hover:text-white transition-colors">Business</a>
                <span class="text-bank-700 mx-1">|</span>
                <a href="{{ $m('private-banking', 'wealth-management') }}" class="hover:text-white transition-colors">Wealth Management</a>
                <span class="text-bank-700 mx-1">|</span>
                <a href="{{ $m('institutional') }}" class="hover:text-white transition-colors">Institutional</a>
                <span class="text-bank-700 mx-1">|</span>
                <a href="{{ $m('about') }}" class="hover:text-white transition-colors">About Us</a>
                <span class="text-bank-700 mx-1">|</span>
                <a href="{{ $m('investor-relations') }}" class="hover:text-white transition-colors">Investor Relations</a>
            </div>
            <div class="flex items-center gap-1">
                <a href="{{ $m('find-a-branch') }}" class="hover:text-white transition-colors px-2">Find a Branch</a>
                <span class="text-bank-700">|</span>
                <a href="{{ $m('find-atm') }}" class="hover:text-white transition-colors px-2">Find an ATM</a>
                <span class="text-bank-700">|</span>
                <a href="{{ $m('contact-us') }}" class="hover:text-white transition-colors px-2">Contact Us</a>
            </div>
        </div>
    </div>

    {{-- Main Nav --}}
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm" id="main-header">
        <div class="max-w-[1400px] mx-auto px-4 lg:px-8 flex items-center justify-between h-[68px]">
            <a href="/" class="flex items-center gap-2.5 shrink-0">
                <div class="w-9 h-9 bg-bank-800 rounded-md flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M3 21h18M3 10h18M5 6l7-3 7 3M4 10v11M20 10v11M8 14v3M12 14v3M16 14v3"/></svg>
                </div>
                <span class="text-bank-900 font-bold text-xl tracking-tight">SecureBank</span>
            </a>

            {{-- Desktop Nav with Mega Menus --}}
            <nav class="hidden lg:flex items-center gap-0 h-full" id="desktop-nav">
                @php
                $megaMenus = [
                    'Banking' => [
                        'Checking' => [['Everyday Checking','Flexible checking for daily use'],['Premium Checking','Earn interest on your balance'],['Student Checking','No-fee banking for students'],['Compare Checking','See all checking features']],
                        'Savings' => [['Savings Accounts','Start saving today'],['High-Yield Savings','Earn 4.50% APY'],['Money Market','Higher rates, more access'],['Compare Savings','See all savings options']],
                        'Digital Banking' => [['Online Banking','Bank from any device'],['Mobile App','Banking on the go'],['Mobile Deposit','Deposit checks remotely'],['Bill Pay','Pay bills on time, every time']],
                    ],
                    'Accounts' => [
                        'Personal' => [['Checking Accounts','Everyday and premium options'],['Savings Accounts','Build your savings'],['CDs & IRAs','Fixed-term deposits'],['Joint Accounts','Bank together']],
                        'Business' => [['Business Checking','For small businesses'],['Business Savings','Earn on business funds'],['Nonprofit Accounts','For organizations'],['Compare Accounts','See all options']],
                        'Features' => [['Online Access','Manage anywhere'],['Mobile Deposit','Deposit with your phone'],['Statements','Go paperless'],['Alerts','Stay informed']],
                    ],
                    'Cards' => [
                        'Credit Cards' => [['Cash Back Card','Earn on every purchase'],['Travel Rewards Card','Points for travel'],['Everyday Rewards Card','Daily spending rewards'],['Premium Card','Exclusive benefits']],
                        'Debit Cards' => [['Standard Debit','Everyday purchases'],['Premium Debit','Enhanced features'],['Student Debit','No-fee option'],['Card Controls','Lock and manage']],
                        'Compare' => [['All Credit Cards','Compare features'],['All Debit Cards','Compare options'],['Card Benefits','See rewards'],['Apply Now','Get started']],
                    ],
                    'Loans' => [
                        'Personal' => [['Personal Loans','Flexible borrowing'],['Debt Consolidation','Combine payments'],['Line of Credit','Borrow as needed'],['Student Loans','Education financing']],
                        'Auto' => [['Auto Loans','New and used vehicles'],['Auto Refinance','Lower your rate'],['RV & Boat','Recreational vehicles'],['Apply Online','Quick application']],
                        'Business' => [['Business Loans','Grow your business'],['Equipment Financing','Purchase equipment'],['SBA Loans','Government-backed'],['Commercial Real Estate','Property loans']],
                    ],
                    'Mortgages' => [
                        'Home Purchase' => [['Fixed-Rate Mortgage','Stable monthly payments'],['Adjustable-Rate Mortgage','Lower initial rates'],['FHA Loans','Low down payment'],['VA Loans','For veterans']],
                        'Refinance' => [['Rate Refinance','Lower your rate'],['Cash-Out Refinance','Access equity'],['Streamlined Refinance','Fast process'],['Compare Options','See all choices']],
                        'Resources' => [['Mortgage Calculator','Estimate payments'],['Pre-Qualification','Check eligibility'],['First-Time Buyers','Getting started'],['Rate Lock','Secure your rate']],
                    ],
                    'Investments' => [
                        'Self-Directed' => [['Brokerage Account','Trade stocks & ETFs'],['Robo-Advisor','Automated investing'],['IRAs','Retirement accounts'],['529 Plans','Education savings']],
                        'Advisory' => [['Financial Planning','Goal-based strategy'],['Portfolio Review','Get expert input'],['Estate Planning','Protect your legacy'],['Tax Strategy','Optimize returns']],
                        'Products' => [['Mutual Funds','Diversified portfolios'],['ETFs','Exchange-traded funds'],['Bonds','Fixed-income options'],['CDs','Guaranteed returns']],
                    ],
                    'Wealth' => [
                        'Wealth Management' => [['Private Banking','Personalized service'],['Trust Services','Protect your assets'],['Family Office','Multi-generational wealth'],['Philanthropy','Giving strategy']],
                        'Planning' => [['Retirement Planning','Secure your future'],['Education Funding','Save for college'],['Insurance Planning','Protect against risk'],['Tax Planning','Minimize liability']],
                        'Investment' => [['Managed Portfolios','Expert management'],['Alternative Investments','Private equity & hedge funds'],['Real Estate Investments','Property portfolios'],['Structured Products','Custom solutions']],
                    ],
                    'Business' => [
                        'Accounts' => [['Business Checking','Daily operations'],['Business Savings','Grow reserves'],['Merchant Services','Accept payments'],['Treasury Management','Cash flow tools']],
                        'Lending' => [['Business Loans','Working capital'],['Commercial Mortgage','Property purchase'],['Equipment Finance',' machinery & vehicles'],['SBA Loans','Government-backed']],
                        'Services' => [['Payroll Services','Employee payments'],['Cash Management','Optimize cash'],['International Banking','Global trade'],['Industry Solutions','Sector expertise']],
                    ],
                ];
                @endphp
                @foreach($megaMenus as $label => $mega)
                    @if($mega)
                    <div class="mega-trigger relative h-full flex items-center">
                        <button type="button" class="px-3 xl:px-4 py-2 text-[15px] font-medium text-bank-600 hover:text-bank-900 rounded-md hover:bg-gray-50 transition-colors flex items-center gap-1 h-full whitespace-nowrap" aria-haspopup="true">
                            {{ $label }}
                            <svg class="w-3.5 h-3.5 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div class="mega-panel absolute top-full left-1/2 -translate-x-1/2 w-[760px] bg-white border border-gray-200 rounded-xl shadow-xl shadow-black/8 p-8 pt-6" role="menu">
                            <div class="grid grid-cols-3 gap-8">
                                @foreach($mega as $col => $items)
                                <div>
                                    <h4 class="text-xs font-bold text-bank-400 uppercase tracking-wider mb-3">{{ $col }}</h4>
                                    <ul class="space-y-2">
                                        @foreach($items as $item)
                                        <li><a href="{{ $m($item[0]) }}" class="text-sm text-bank-700 hover:text-bank-900 hover:underline transition-colors leading-snug block py-0.5" role="menuitem">{{ $item[0] }}</a>
                                            <p class="text-[11px] text-bank-400 leading-snug">{{ $item[1] }}</p>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endforeach
                            </div>
                            <div class="mt-6 pt-5 border-t border-gray-100 flex items-center gap-4">
                                <div class="w-16 h-16 bg-bank-50 rounded-lg overflow-hidden flex items-center justify-center">
                                    <svg class="w-8 h-8 text-bank-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-bank-800">Featured: High-Yield Savings</p>
                                    <p class="text-xs text-bank-500">Our top savings rate, no minimum balance. <a href="{{ route('marketing.show', 'high-yield-savings') }}" class="text-accent-600 font-semibold hover:underline">Open now →</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <a href="{{ $m($item[0]) }}" @if(request()->routeIs('marketing.show') && request()->route('page') === $item[0]) aria-current="page" @endif class="px-3 xl:px-4 py-2 text-[15px] font-medium text-bank-600 hover:text-bank-900 rounded-md hover:bg-gray-50 transition-colors h-full flex items-center whitespace-nowrap">{{ $label }}</a>
                    @endif
                @endforeach
            </nav>

            <div class="flex items-center gap-3">
                <button type="button" class="p-2 text-bank-500 hover:text-bank-800 transition-colors hidden lg:block" aria-label="Search">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </button>
                <a href="{{ route('login') }}" class="px-5 py-2 text-sm font-semibold text-white bg-bank-800 hover:bg-bank-900 rounded-lg transition-colors shadow-sm">Sign In</a>
                <a href="{{ route('register') }}" class="hidden sm:inline-flex px-5 py-2 text-sm font-semibold text-white bg-accent-500 hover:bg-accent-600 rounded-lg transition-colors shadow-sm">Open an Account</a>
                <button type="button" id="mobile-toggle" class="lg:hidden p-2 -mr-2 text-bank-600" aria-label="Open menu" aria-expanded="false" aria-controls="drawer-panel">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
        </div>
    </header>

    <div id="drawer-overlay" class="drawer-overlay fixed inset-0 bg-black/40 z-[60] lg:hidden" aria-hidden="true"></div>
    <div role="dialog" aria-modal="true" aria-label="Mobile navigation" tabindex="-1" aria-hidden="true" id="drawer-panel" class="drawer-panel fixed inset-y-0 left-0 w-[320px] max-w-[85vw] bg-white z-[70] lg:hidden shadow-2xl flex flex-col">
        <div class="flex items-center justify-between px-5 h-16 border-b border-gray-100">
            <span class="font-bold text-bank-900 text-lg">SecureBank</span>
            <button type="button" id="drawer-close" class="p-2 -mr-2 text-bank-500 hover:text-bank-800" aria-label="Close menu">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <nav class="flex-1 overflow-y-auto py-4 px-5 space-y-0.5" id="mobile-menu" aria-label="Mobile">
            @php
                $drawerGroups = [
                    'Banking' => ['checking-accounts', 'savings-accounts', 'credit-cards', 'cds'],
                    'Borrowing' => ['personal-loans', 'auto-loans', 'home-loans'],
                    'Invest & Protect' => ['investing', 'private-banking', 'insurance-planning'],
                    'More' => ['business-banking', 'financial-tools', 'find-a-branch', 'find-atm', 'help-support', 'contact-us'],
                ];
            @endphp
            @foreach ($drawerGroups as $heading => $links)
                <p class="text-[11px] font-bold text-bank-400 uppercase tracking-wider pt-4 pb-1">{{ $heading }}</p>
                @foreach ($links as $slug)
                    @php $active = request()->routeIs('marketing.show') && request()->route('page') === $slug; @endphp
                    <a href="{{ $m($slug) }}" @if ($active) aria-current="page" @endif class="block py-2.5 text-[15px] text-bank-700 hover:text-bank-900{{ $active ? ' font-semibold text-accent-700' : '' }}">{{ \App\Support\MarketingCatalog::get($slug)['title'] }}</a>
                @endforeach
            @endforeach
        </nav>
        <div class="border-t border-gray-100 p-5 space-y-3">
            <a href="{{ route('login') }}" class="block w-full py-2.5 text-sm font-semibold text-center text-white bg-bank-800 rounded-lg">Sign In</a>
            <a href="{{ route('register') }}" class="block w-full py-2.5 text-sm font-semibold text-center text-white bg-accent-500 rounded-lg">Open an Account</a>
        </div>
    </div>

    <div class="pt-0">
        @yield('content')
    </div>
@endauth

<script>
    // Mobile drawer
    const toggle = document.getElementById('mobile-toggle');
    const overlay = document.getElementById('drawer-overlay');
    const panel = document.getElementById('drawer-panel');
    const closeBtn = document.getElementById('drawer-close');
    let lastFocused = null;

    function focusables(){
        return panel ? [...panel.querySelectorAll('a[href], button:not([disabled]), input, select, textarea, [tabindex]:not([tabindex="-1"])')].filter(el => el.offsetParent !== null) : [];
    }
    function openDrawer(){
        if (!panel) return;
        lastFocused = document.activeElement;
        overlay?.classList.add('open');
        panel.classList.add('open');
        panel.removeAttribute('aria-hidden');
        overlay?.setAttribute('aria-hidden', 'false');
        toggle?.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden';
        const f = focusables();
        (f[0] ?? panel).focus?.();
    }
    function closeDrawer(){
        if (!panel) return;
        overlay?.classList.remove('open');
        panel.classList.remove('open');
        panel.setAttribute('aria-hidden', 'true');
        overlay?.setAttribute('aria-hidden', 'true');
        toggle?.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
        lastFocused?.focus?.();
    }
    toggle?.addEventListener('click', () => panel?.classList.contains('open') ? closeDrawer() : openDrawer());
    closeBtn?.addEventListener('click', closeDrawer);
    overlay?.addEventListener('click', closeDrawer);
    document.addEventListener('keydown', (e) => {
        if (!panel?.classList.contains('open')) return;
        if (e.key === 'Escape') { e.preventDefault(); closeDrawer(); return; }
        if (e.key === 'Tab') {
            const f = focusables();
            if (!f.length) return;
            const first = f[0], last = f[f.length - 1];
            if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
            else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
        }
    });
    // Close drawer if viewport grows to desktop while it is open
    window.matchMedia('(min-width: 1024px)').addEventListener('change', (e) => { if (e.matches) closeDrawer(); });

    // Scroll reveal
    const revealEls = document.querySelectorAll('.reveal');
    if ('IntersectionObserver' in window && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); observer.unobserve(e.target); } });
        }, { threshold: 0.1 });
        revealEls.forEach(el => observer.observe(el));
    } else {
        revealEls.forEach(el => el.classList.add('visible'));
    }

    // Sticky header shadow
    const header = document.getElementById('main-header');
    window.addEventListener('scroll', () => {
        if(window.scrollY > 10){ header?.classList.add('shadow-md'); }
        else { header?.classList.remove('shadow-md'); }
    });
</script>
@stack('scripts')
</body>
</html>
