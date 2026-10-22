<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Dashboard') · SecureBank</title>
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
            }
        }
    }
    </script>
    <style type="text/tailwindcss">
        @layer base {
            :root { color-scheme: light; }
            body { @apply bg-slate-100 text-slate-900 antialiased; }
            [x-cloak] { display: none !important; }
        }
        @layer components {
            .focus-ring { @apply focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-600 focus-visible:ring-offset-2; }
        }
    </style>
    <style>
        /* Respect reduced-motion for every transition in the banking shell. */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
                scroll-behavior: auto !important;
            }
        }
    </style>
</head>
<body class="h-full font-sans">
    <a href="#bank-main"
       class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[100] focus:rounded-lg focus:bg-brand-800 focus:px-4 focus:py-2.5 focus:text-sm focus:font-semibold focus:text-white">
        Skip to main content
    </a>

    <x-icon-sprite />

    @php
        $user = auth()->user();
        $unreadCount = $unreadCount ?? 0;
        $balancesVisibleDefault = $balancesVisibleDefault ?? true;
        $navGroups = \App\Support\BankingNavigation::groups();
        $mobilePrimary = \App\Support\BankingNavigation::mobilePrimary();
        $currentRoute = request()->route()?->getName();
    @endphp

    <div class="min-h-full lg:flex">
        {{-- Desktop sidebar --}}
        <aside class="hidden w-64 shrink-0 border-r border-bank-800 bg-bank-900 lg:flex lg:flex-col"
               aria-label="Primary">
            <div class="flex h-16 shrink-0 items-center gap-2.5 border-b border-bank-800 px-5">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-accent-500 font-serif text-lg font-bold text-bank-950">S</span>
                <span class="min-w-0">
                    <span class="block font-serif text-base font-semibold leading-none text-white">SecureBank</span>
                    <span class="mt-1 block text-[10px] font-semibold uppercase tracking-[0.16em] text-bank-400">Personal banking</span>
                </span>
            </div>

            <nav class="flex-1 space-y-5 overflow-y-auto px-3 py-5" aria-label="Banking sections">
                @foreach($navGroups as $group)
                    <div>
                        <h2 class="px-2.5 text-[10px] font-semibold uppercase tracking-[0.14em] text-bank-400">
                            {{ $group['label'] }}
                        </h2>
                        <ul class="mt-1.5 space-y-0.5">
                            @foreach($group['items'] as $item)
                                @php $active = $currentRoute === $item['route']; @endphp
                                <li>
                                    <a href="{{ route($item['route']) }}"
                                       @if($active) aria-current="page" @endif
                                       class="group flex items-center gap-2.5 rounded-lg px-2.5 py-2 text-sm font-medium transition-colors focus-ring
                                              {{ $active
                                                 ? 'bg-brand-700/60 text-white'
                                                 : 'text-bank-200 hover:bg-brand-800 hover:text-white' }}">
                                        <x-icon :name="$item['icon']" class="h-[18px] w-[18px] shrink-0 {{ $active ? 'text-accent-300' : 'text-bank-400 group-hover:text-accent-300' }}" />
                                        <span class="truncate">{{ $item['label'] }}</span>
                                        @if(($item['route'] === 'notifications.index') && $unreadCount > 0)
                                            <span class="ml-auto rounded-full bg-accent-500 px-1.5 py-0.5 text-[10px] font-bold tabular-nums text-bank-950">
                                                {{ $unreadCount }}
                                                <span class="sr-only">unread notifications</span>
                                            </span>
                                        @endif
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </nav>

            <div class="shrink-0 border-t border-bank-800 p-3">
                <div class="flex items-center gap-2.5 rounded-lg px-2.5 py-2">
                    <span class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-bank-700 text-xs font-bold text-white">
                        {{ $user->initials() }}
                    </span>
                    <span class="min-w-0 flex-1">
                        <span class="block truncate text-sm font-semibold text-white">{{ $user->name }}</span>
                        <span class="block truncate text-xs text-bank-400">{{ $user->email }}</span>
                    </span>
                </div>
            </div>
        </aside>

        <div class="flex min-w-0 flex-1 flex-col">
            {{-- Top header --}}
            <header class="sticky top-0 z-30 border-b border-slate-200 bg-white/95 backdrop-blur supports-[backdrop-filter]:bg-white/80"
                    x-data="{ search: false }">
                <div class="flex h-16 items-center gap-3 px-4 sm:px-6">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2 lg:hidden">
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-bank-900 font-serif text-lg font-bold text-accent-400">S</span>
                        <span class="font-serif text-base font-semibold text-bank-900">SecureBank</span>
                    </a>

                    {{-- Search --}}
                    <form action="{{ route('search') }}" method="GET" role="search" class="hidden min-w-0 flex-1 md:block">
                        <label for="bank-search" class="sr-only">Search accounts, transactions, and help</label>
                        <div class="relative max-w-md">
                            <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
                                <x-icon name="search" class="h-4 w-4" />
                            </span>
                            <input id="bank-search" name="q" type="search" autocomplete="off"
                                   value="{{ request('q') }}"
                                   placeholder="Search transactions, accounts, help"
                                   class="w-full rounded-lg border border-slate-300 bg-slate-50 py-2 pl-9 pr-3 text-sm text-slate-900 placeholder:text-slate-400 focus:border-brand-500 focus:bg-white focus-ring">
                        </div>
                    </form>

                    <div class="ml-auto flex items-center gap-1 sm:gap-1.5">
                        <a href="{{ route('search') }}"
                           class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-slate-600 transition-colors hover:bg-slate-100 focus-ring md:hidden"
                           aria-label="Search">
                            <x-icon name="search" />
                        </a>

                        <a href="{{ route('messages.create') }}"
                           class="hidden h-9 w-9 items-center justify-center rounded-lg text-slate-600 transition-colors hover:bg-slate-100 focus-ring sm:inline-flex"
                           aria-label="Get help from SecureBank">
                            <x-icon name="help" />
                        </a>

                        <a href="{{ route('notifications.index') }}"
                           class="relative inline-flex h-9 w-9 items-center justify-center rounded-lg text-slate-600 transition-colors hover:bg-slate-100 focus-ring"
                           aria-label="Notifications{{ $unreadCount > 0 ? ', ' . $unreadCount . ' unread' : '' }}">
                            <x-icon name="bell" />
                            @if($unreadCount > 0)
                                <span class="absolute right-1.5 top-1.5 h-2 w-2 rounded-full bg-rose-500 ring-2 ring-white" aria-hidden="true"></span>
                            @endif
                        </a>

                        {{-- Session status --}}
                        <a href="{{ route('security.index') }}"
                           class="hidden h-9 items-center gap-1.5 rounded-lg border border-slate-200 px-2.5 text-xs font-medium text-slate-600 transition-colors hover:bg-slate-50 focus-ring lg:inline-flex"
                           aria-label="Security status: two-step verification enabled">
                            <x-icon name="shield" class="h-4 w-4 text-emerald-600" />
                            <span class="hidden xl:inline">Protected</span>
                        </a>

                        {{-- Profile menu --}}
                        <div x-data="{ open: false }" class="relative">
                            <button type="button" @click="open = !open" :aria-expanded="open"
                                    class="inline-flex h-9 items-center gap-2 rounded-lg px-1.5 transition-colors hover:bg-slate-100 focus-ring"
                                    aria-haspopup="menu">
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-brand-100 text-xs font-bold text-brand-800">
                                    {{ $user->initials() }}
                                </span>
                                <span class="hidden text-sm font-semibold text-slate-800 sm:inline">{{ $user->firstName() }}</span>
                                <x-icon name="chevron-down" class="hidden h-4 w-4 text-slate-400 sm:block" />
                                <span class="sr-only">Account menu</span>
                            </button>

                            <div x-cloak x-show="open" @click.outside="open = false"
                                 @keydown.escape.window="open = false"
                                 x-transition.origin.top.right
                                 role="menu"
                                 class="absolute right-0 mt-2 w-60 origin-top-right overflow-hidden rounded-xl border border-slate-200 bg-white shadow-lg">
                                <div class="border-b border-slate-200 px-4 py-3">
                                    <p class="truncate text-sm font-semibold text-slate-900">{{ $user->name }}</p>
                                    <p class="truncate text-xs text-slate-500">{{ $user->email }}</p>
                                </div>
                                <div class="p-1.5">
                                    <a href="{{ route('accounts.index') }}" role="menuitem"
                                       class="flex items-center gap-2.5 rounded-lg px-2.5 py-2 text-sm text-slate-700 hover:bg-slate-50 focus-ring">
                                        <x-icon name="building" class="h-4 w-4 text-slate-400" /> My accounts
                                    </a>
                                    <a href="{{ route('settings.index') }}" role="menuitem"
                                       class="flex items-center gap-2.5 rounded-lg px-2.5 py-2 text-sm text-slate-700 hover:bg-slate-50 focus-ring">
                                        <x-icon name="cog" class="h-4 w-4 text-slate-400" /> Settings
                                    </a>
                                    <a href="{{ route('security.index') }}" role="menuitem"
                                       class="flex items-center gap-2.5 rounded-lg px-2.5 py-2 text-sm text-slate-700 hover:bg-slate-50 focus-ring">
                                        <x-icon name="shield" class="h-4 w-4 text-slate-400" /> Security
                                    </a>
                                </div>
                                <form method="POST" action="{{ route('logout') }}" class="border-t border-slate-200 p-1.5">
                                    @csrf
                                    <button type="submit" role="menuitem"
                                            class="flex w-full items-center gap-2.5 rounded-lg px-2.5 py-2 text-sm text-slate-700 hover:bg-slate-50 focus-ring">
                                        <x-icon name="logout" class="h-4 w-4 text-slate-400" /> Sign out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Flash messages --}}
            @if(session('success') || session('error'))
                <div class="space-y-2 px-4 pt-4 sm:px-6">
                    @if(session('success'))
                        <x-alert tone="success" icon="check-circle" title="{{ session('success') }}" />
                    @endif
                    @if(session('error'))
                        <x-alert tone="error" icon="alert" title="{{ session('error') }}" />
                    @endif
                </div>
            @endif

            @if($errors->any())
                <div class="px-4 pt-4 sm:px-6">
                    <x-alert tone="error" icon="alert" title="Please correct the following">
                        <ul class="list-inside list-disc space-y-0.5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </x-alert>
                </div>
            @endif

            <main id="bank-main" tabindex="-1" class="flex-1 px-4 py-5 sm:px-6 sm:py-6 focus:outline-none">
                {{ $slot ?? '' }}
                @yield('content')
            </main>

            {{-- Mobile bottom navigation --}}
            <nav class="sticky bottom-0 z-30 border-t border-slate-200 bg-white lg:hidden"
                 aria-label="Primary mobile">
                <div class="grid grid-cols-5">
                    @foreach($mobilePrimary as $item)
                        @php $active = $currentRoute === $item['route']; @endphp
                        <a href="{{ route($item['route']) }}"
                           @if($active) aria-current="page" @endif
                           class="flex flex-col items-center gap-1 px-1 py-2.5 text-[10px] font-medium transition-colors focus-ring
                                  {{ $active ? 'text-brand-800' : 'text-slate-500' }}">
                            <x-icon :name="$item['icon']" class="h-[19px] w-[19px]" />
                            <span class="truncate">{{ $item['label'] }}</span>
                        </a>
                    @endforeach

                    <div x-data="{ open: false }">
                        <button type="button" @click="open = true" class="flex w-full flex-col items-center gap-1 px-1 py-2.5 text-[10px] font-medium text-slate-500 focus-ring">
                            <x-icon name="more" class="h-[19px] w-[19px]" />
                            <span>More</span>
                        </button>

                        <div x-cloak x-show="open"
                             x-transition.opacity
                             class="fixed inset-0 z-50 lg:hidden" role="dialog" aria-modal="true" aria-label="More banking options">
                            <div class="absolute inset-0 bg-bank-950/50" @click="open = false"></div>

                            <div class="absolute inset-x-0 bottom-0 max-h-[85vh] overflow-y-auto rounded-t-2xl bg-white pb-6 shadow-2xl"
                                 x-show="open" x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="translate-y-full" x-transition:enter-end="translate-y-0">
                                <div class="sticky top-0 bg-white px-4 pb-2 pt-3">
                                    <div class="mx-auto mb-3 h-1 w-10 rounded-full bg-slate-300" aria-hidden="true"></div>
                                    <div class="flex items-center justify-between gap-3">
                                        <p class="text-base font-semibold text-slate-900">All features</p>
                                        <button type="button" @click="open = false" class="rounded-lg p-1.5 text-slate-500 hover:bg-slate-100 focus-ring">
                                            <x-icon name="close" />
                                            <span class="sr-only">Close menu</span>
                                        </button>
                                    </div>
                                </div>

                                @foreach($navGroups as $group)
                                    <div class="px-4 pt-3">
                                        <h2 class="text-[10px] font-semibold uppercase tracking-[0.14em] text-slate-500">{{ $group['label'] }}</h2>
                                        <ul class="mt-1.5 grid grid-cols-2 gap-1.5">
                                            @foreach($group['items'] as $item)
                                                @php $active = $currentRoute === $item['route']; @endphp
                                                <li>
                                                    <a href="{{ route($item['route']) }}"
                                                       @if($active) aria-current="page" @endif
                                                       class="flex items-center gap-2 rounded-lg border border-slate-200 px-2.5 py-2.5 text-xs font-medium focus-ring
                                                              {{ $active ? 'border-brand-300 bg-brand-50 text-brand-900' : 'text-slate-700' }}">
                                                        <x-icon :name="$item['icon']" class="h-4 w-4 shrink-0 text-slate-400" />
                                                        <span class="truncate">{{ $item['label'] }}</span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach

                                <div class="px-4 pt-4">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 focus-ring">
                                            <x-icon name="logout" class="h-4 w-4" /> Sign out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>

    {{-- Balance privacy toggle: preference only, no financial data is stored in the browser --}}
    <script>
        (function () {
            var STORAGE_KEY = 'securebank.balancesVisible';
            var root = document.documentElement;

            function stored() {
                try { return localStorage.getItem(STORAGE_KEY); } catch (e) { return null; }
            }

            function setVisible(visible) {
                root.dataset.balancesVisible = visible ? 'visible' : 'hidden';

                document.querySelectorAll('[data-balance-blank]').forEach(function (node) {
                    if (node.dataset.originalText === undefined) {
                        node.dataset.originalText = node.textContent.trim();
                    }
                    node.textContent = visible ? node.dataset.originalText : '••••••';
                });

                document.querySelectorAll('[data-balance-sensitive]').forEach(function (node) {
                    if (node.dataset.originalText === undefined) {
                        node.dataset.originalText = node.textContent.trim();
                    }
                    node.textContent = visible ? node.dataset.originalText : '••••••';
                });
            }

            var saved = stored();
            var visible = saved === null ? {{ $balancesVisibleDefault ? 'true' : 'false' }} : saved === 'true';
            setVisible(visible);

            document.addEventListener('click', function (event) {
                var toggle = event.target.closest('[data-toggle-balances]');
                if (!toggle) { return; }

                visible = !visible;
                setVisible(visible);

                try { localStorage.setItem(STORAGE_KEY, visible ? 'true' : 'false'); } catch (e) {}

                toggle.setAttribute('aria-pressed', visible ? 'true' : 'false');
                var label = toggle.querySelector('[data-balance-toggle-label]');
                if (label) {
                    label.textContent = visible ? 'Hide balances' : 'Show balances';
                }
            });
        })();
    </script>
</body>
</html>
