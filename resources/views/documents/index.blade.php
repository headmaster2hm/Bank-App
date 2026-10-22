@extends('layouts.banking')

@section('title', 'Documents')

@section('content')
    <x-page-header
        title="Statements and documents"
        subtitle="Everything SecureBank has sent you, in one place."
    />

    <x-panel title="Filter" class="mb-5">
        <form method="GET" action="{{ route('documents.index') }}" class="grid gap-3 p-4 sm:grid-cols-2 lg:grid-cols-4">
            <div>
                <label for="type" class="block text-xs font-medium text-slate-700">Document type</label>
                <select id="type" name="type" class="mt-1 w-full rounded-lg border border-slate-300 bg-white py-2 text-sm focus:border-brand-500 focus-ring">
                    <option value="">All types</option>
                    @foreach($types as $type)
                        <option value="{{ $type }}" @selected($filters['type'] === $type)>
                            {{ \App\Models\Document::typeLabel($type) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="account" class="block text-xs font-medium text-slate-700">Account</label>
                <select id="account" name="account" class="mt-1 w-full rounded-lg border border-slate-300 bg-white py-2 text-sm focus:border-brand-500 focus-ring">
                    <option value="">All accounts</option>
                    @foreach($accounts as $account)
                        <option value="{{ $account->id }}" @selected($filters['account'] === (string) $account->id)>
                            {{ $account->account_name }} ({{ $account->maskedNumber() }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="year" class="block text-xs font-medium text-slate-700">Year</label>
                <select id="year" name="year" class="mt-1 w-full rounded-lg border border-slate-300 bg-white py-2 text-sm focus:border-brand-500 focus-ring">
                    <option value="">All years</option>
                    @foreach($years as $year)
                        <option value="{{ $year }}" @selected($filters['year'] === (string) $year)>{{ $year }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 rounded-lg bg-brand-700 px-3 py-2 text-sm font-semibold text-white transition-colors hover:bg-brand-800 focus-ring">
                    Apply
                </button>
                @if($filters['type'] || $filters['year'] || $filters['account'])
                    <a href="{{ route('documents.index') }}"
                       class="rounded-lg border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 transition-colors hover:bg-slate-50 focus-ring">
                        Clear
                    </a>
                @endif
            </div>
        </form>
    </x-panel>

    @if($documents->isEmpty())
        <x-empty-state
            icon="document"
            title="No documents found"
            description="Statements, tax forms, and notices will appear here as SecureBank issues them."
            action-label="Clear filters"
            :action-href="route('documents.index')"
        />
    @else
        <x-panel :title="Str::plural('Document', $documents->count())" :description="'Matching your filters'">
            <div class="divide-y divide-slate-100">
                @foreach($documents as $document)
                    <div class="flex flex-wrap items-center gap-4 px-5 py-3.5">
                        <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-slate-50 text-slate-500 ring-1 ring-slate-200">
                            <x-icon name="document" class="h-5 w-5" />
                        </span>

                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-semibold text-slate-900">{{ $document->title }}</p>
                            <p class="mt-0.5 truncate text-xs text-slate-500">
                                {{ \App\Models\Document::typeLabel($document->document_type) }}
                                @if($document->account)
                                    · {{ $document->account->account_name }}
                                @endif
                                @if($document->period_label)
                                    · {{ $document->period_label }}
                                @endif
                            </p>
                        </div>

                        <div class="shrink-0 text-right">
                            <p class="text-xs font-medium text-slate-700">{{ $document->document_date->isoFormat('MMM D, Y') }}</p>
                            <p class="mt-0.5 text-xs text-slate-500">{{ $document->file_size_label }}</p>
                        </div>

                        <a href="{{ route('documents.download', $document) }}"
                           class="inline-flex shrink-0 items-center gap-1.5 rounded-lg border border-slate-300 px-2.5 py-1.5 text-xs font-semibold text-slate-700 transition-colors hover:bg-slate-50 focus-ring">
                            <x-icon name="download" class="h-3.5 w-3.5" />
                            Download
                        </a>
                    </div>
                @endforeach
            </div>
        </x-panel>

        <p class="mt-4 rounded-lg bg-slate-100 p-3 text-xs leading-relaxed text-slate-600">
            These are demonstration documents generated by the SecureBank prototype. They contain no real statement figures and are not valid for tax or legal purposes.
        </p>
    @endif
@endsection
