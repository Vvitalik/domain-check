@extends('layouts.app')

@section('header', $domain->name)

@section('content')

    <div class="space-y-6">

        <div class="flex items-center justify-between">
            <a href="{{ route('domains.index') }}"
               class="text-sm font-medium text-slate-600 hover:text-slate-900">
                ← Back to domains
            </a>

            <a href="{{ route('domains.edit', $domain) }}"
               class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-medium text-white transition hover:bg-blue-700">
                Edit Domain
            </a>
        </div>

        <div class="grid gap-6 lg:grid-cols-4">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="text-sm text-slate-500">Status</div>

                <div class="mt-3">
                    @if($domain->last_status->value === 'up')
                        <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                        UP
                    </span>
                    @elseif($domain->last_status->value === 'down')
                        <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                        DOWN
                    </span>
                    @elseif($domain->last_status->value === 'timeout')
                        <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">
                        TIMEOUT
                    </span>
                    @else
                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                        UNKNOWN
                    </span>
                    @endif
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="text-sm text-slate-500">Method</div>
                <div class="mt-2 text-lg font-semibold text-slate-900">
                    {{ $domain->method->value }}
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="text-sm text-slate-500">Interval</div>
                <div class="mt-2 text-lg font-semibold text-slate-900">
                    {{ $domain->interval_min }} min
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="text-sm text-slate-500">Timeout</div>
                <div class="mt-2 text-lg font-semibold text-slate-900">
                    {{ $domain->timeout_sec }} sec
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">
                Domain Details
            </h2>

            <div class="mt-6 grid gap-6 md:grid-cols-2">
                <div>
                    <div class="text-sm text-slate-500">URL</div>
                    <div class="mt-1 font-medium text-slate-900 break-all">
                        {{ $domain->url }}
                    </div>
                </div>

                <div>
                    <div class="text-sm text-slate-500">Active</div>
                    <div class="mt-1 font-medium text-slate-900">
                        {{ $domain->is_active ? 'Yes' : 'No' }}
                    </div>
                </div>

                <div>
                    <div class="text-sm text-slate-500">Last checked at</div>
                    <div class="mt-1 font-medium text-slate-900">
                        {{ $domain->last_checked_at?->format('Y-m-d H:i:s') ?? 'Never' }}
                    </div>
                </div>

                <div>
                    <div class="text-sm text-slate-500">Next check at</div>
                    <div class="mt-1 font-medium text-slate-900">
                        {{ $domain->next_check_at?->format('Y-m-d H:i:s') ?? 'Not scheduled' }}
                    </div>
                </div>
            </div>
        </div>

        <div id="domain-checks-table">
            @include('domains.partials.async-checks-table')
        </div>
    </div>

@endsection
