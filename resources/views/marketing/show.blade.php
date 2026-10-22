@extends('layouts.app')

@section('title', $content['title'].' | SecureBank')

@section('content')

{{-- Breadcrumb --}}
<nav aria-label="Breadcrumb" class="mb-6">
    <ol class="flex flex-wrap items-center gap-1.5 text-xs text-bank-400">
        <li><a href="{{ route('home') }}" class="hover:text-bank-700 transition-colors">Home</a></li>
        <li aria-hidden="true" class="text-bank-300">/</li>
        @if ($groupHub)
            <li><a href="{{ route('marketing.show', $groupHub) }}" class="hover:text-bank-700 transition-colors">{{ $content['eyebrow'] }}</a></li>
            <li aria-hidden="true" class="text-bank-300">/</li>
        @else
            <li class="text-bank-500">{{ $content['eyebrow'] }}</li>
            <li aria-hidden="true" class="text-bank-300">/</li>
        @endif
        <li aria-current="page" class="text-bank-700 font-medium">{{ $content['title'] }}</li>
    </ol>
</nav>

{{-- Hero --}}
<section class="relative -mx-4 lg:-mx-8 -mt-6 lg:-mt-8 px-4 lg:px-8 pt-14 pb-16 lg:pt-20 lg:pb-20 bg-bank-950 overflow-hidden">
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-gradient-to-br from-bank-950 via-bank-900 to-bank-950"></div>
        <div class="absolute -right-32 -top-32 w-[520px] h-[520px] rounded-full bg-accent-500/10 blur-3xl"></div>
    </div>
    <div class="relative max-w-[1400px] mx-auto">
        <div class="max-w-3xl">
            <p class="text-accent-400 text-xs font-bold uppercase tracking-[0.2em] mb-4">{{ $content['eyebrow'] }}</p>
            <h1 class="font-serif text-4xl md:text-5xl font-semibold text-white leading-[1.12] mb-6">{{ $content['title'] }}</h1>
            <p class="text-lg text-bank-300 leading-relaxed mb-9">{{ $content['lede'] }}</p>
            <div class="flex flex-wrap gap-4">
                <a href="{{ $ctaHref }}" class="inline-flex items-center gap-2.5 bg-accent-500 hover:bg-accent-600 text-white px-7 py-3.5 rounded-lg font-semibold transition-colors shadow-lg shadow-black/20">
                    {{ $content['cta']['label'] }}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
                <a href="{{ $contactHref }}" class="inline-flex items-center gap-2 border border-white/25 hover:border-white/50 text-white px-7 py-3.5 rounded-lg font-semibold transition-colors">
                    Contact Us
                </a>
            </div>
        </div>
    </div>
</section>

<div class="max-w-[1400px] mx-auto px-4 lg:px-8">

    {{-- Highlights --}}
    @if (! empty($content['highlights']))
    <section class="-mt-10 lg:-mt-12 relative z-10" aria-label="Key details">
        <div class="grid grid-cols-2 lg:grid-cols-{{ count($content['highlights']) >= 4 ? '4' : '3' }} gap-4">
            @foreach ($content['highlights'] as [$label, $value])
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                <p class="font-serif text-2xl md:text-3xl font-semibold text-bank-900 tracking-tight leading-tight">{{ $value }}</p>
                <p class="text-xs text-bank-500 mt-1.5 leading-snug">{{ $label }}</p>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- Body --}}
    @if (! empty($content['features']))
    <section class="py-20" aria-label="Overview">
        <div class="grid lg:grid-cols-12 gap-12">
            <div class="lg:col-span-4">
                <h2 class="font-serif text-2xl md:text-3xl font-semibold text-bank-900 mb-4">What you get</h2>
                <p class="text-bank-500 leading-relaxed">
                    Every product comes with clear pricing, straightforward terms, and access to a banker who can answer questions before and after you open it.
                </p>
            </div>
            <div class="lg:col-span-8 grid sm:grid-cols-2 gap-x-8 gap-y-9">
                @foreach ($content['features'] as [$heading, $description])
                <div>
                    <div class="flex items-start gap-3">
                        <span class="mt-0.5 w-6 h-6 rounded-full bg-accent-50 text-accent-700 flex items-center justify-center shrink-0">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </span>
                        <div>
                            <h3 class="font-semibold text-bank-900 text-[15px] mb-1.5 leading-snug">{{ $heading }}</h3>
                            <p class="text-sm text-bank-500 leading-relaxed">{{ $description }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- FAQ --}}
    @if (! empty($content['faq']))
    <section class="pb-20" aria-labelledby="faq-heading">
        <div class="max-w-3xl mx-auto">
            <h2 id="faq-heading" class="font-serif text-2xl md:text-3xl font-semibold text-bank-900 text-center mb-3">Common questions</h2>
            <p class="text-sm text-bank-500 text-center mb-10">Answers to the things people ask most about this product.</p>
            <div class="space-y-3">
                @foreach ($content['faq'] as $index => [$question, $answer])
                <details class="group border border-gray-200 rounded-xl bg-white overflow-hidden" @if($index === 0) open @endif>
                    <summary class="flex items-center justify-between gap-4 px-6 py-5 cursor-pointer list-none font-semibold text-bank-900 text-[15px] hover:bg-bank-50 transition-colors">
                        {{ $question }}
                        <span class="shrink-0 w-6 h-6 rounded-full bg-bank-50 group-open:bg-accent-100 text-bank-600 group-open:text-accent-700 flex items-center justify-center transition-colors" aria-hidden="true">
                            <svg class="w-3.5 h-3.5 accordion-icon" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14"/></svg>
                        </span>
                    </summary>
                    <div class="px-6 pb-6 -mt-1">
                        <p class="text-sm text-bank-600 leading-relaxed">{{ $answer }}</p>
                    </div>
                </details>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Related --}}
    @if (! empty($related))
    <section class="pb-20" aria-labelledby="related-heading">
        <h2 id="related-heading" class="font-serif text-2xl md:text-3xl font-semibold text-bank-900 mb-8">Related</h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach ($related as $slug => $item)
            <a href="{{ route('marketing.show', $slug) }}" class="group border border-gray-200 rounded-xl p-6 bg-white hover:border-bank-300 hover:shadow-md transition-all">
                <p class="text-[11px] font-bold uppercase tracking-wider text-accent-600 mb-2">{{ $item['eyebrow'] }}</p>
                <h3 class="font-semibold text-bank-900 text-[15px] mb-2 leading-snug group-hover:text-accent-700 transition-colors">{{ $item['title'] }}</h3>
                <p class="text-sm text-bank-500 leading-relaxed">{{ \Illuminate\Support\Str::limit($item['lede'], 90) }}</p>
                <span class="inline-flex items-center gap-1 mt-4 text-xs font-semibold text-bank-700 group-hover:text-accent-700 transition-colors">
                    Learn more
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </span>
            </a>
            @endforeach
        </div>
    </section>
    @endif

    {{-- More in this category --}}
    @if (! empty($siblings))
    <section class="pb-20" aria-labelledby="siblings-heading">
        <h2 id="siblings-heading" class="font-serif text-2xl md:text-3xl font-semibold text-bank-900 mb-8">More in {{ $content['group'] }}</h2>
        <div class="border-t border-gray-200">
            @foreach ($siblings as $slug => $item)
                @continue($slug === $page)
            <a href="{{ route('marketing.show', $slug) }}" class="group flex items-center justify-between gap-6 py-4 border-b border-gray-200 hover:bg-bank-50 transition-colors px-2 -mx-2">
                <span>
                    <span class="font-medium text-bank-900 text-[15px] group-hover:text-accent-700 transition-colors">{{ $item['title'] }}</span>
                    <span class="block text-sm text-bank-500 mt-0.5">{{ \Illuminate\Support\Str::limit($item['lede'], 110) }}</span>
                </span>
                <svg class="w-4 h-4 text-bank-300 group-hover:text-accent-600 shrink-0 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
            @endforeach
        </div>
    </section>
    @endif

    {{-- CTA --}}
    <section class="mb-24 -mx-4 lg:-mx-8 px-4 lg:px-8 py-16 bg-bank-950 rounded-none">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="font-serif text-3xl md:text-4xl font-semibold text-white mb-4">Ready to get started?</h2>
            <p class="text-bank-300 leading-relaxed mb-8">
                Open an account online in a few minutes, or talk to a banker if you would rather have a conversation first.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ $ctaHref }}" class="px-8 py-3.5 bg-accent-500 hover:bg-accent-600 text-white rounded-lg font-semibold transition-colors">{{ $content['cta']['label'] }}</a>
                <a href="{{ $contactHref }}" class="px-8 py-3.5 border border-white/25 hover:border-white/50 text-white rounded-lg font-semibold transition-colors">Talk to a Banker</a>
            </div>
        </div>
    </section>
</div>

@endsection
