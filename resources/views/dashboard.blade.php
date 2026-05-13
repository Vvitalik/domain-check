@extends('layouts.app')

@section('header', 'Dashboard')

@section('content')

    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="text-sm font-medium text-slate-500">
                Total Domains
            </div>

            <div class="mt-3 text-3xl font-bold text-slate-900">
                {{ $totalDomains }}
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="text-sm font-medium text-slate-500">
                Active Domains
            </div>

            <div class="mt-3 text-3xl font-bold text-slate-900">
                {{ $activeDomains }}
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="text-sm font-medium text-slate-500">
                UP
            </div>

            <div class="mt-3 text-3xl font-bold text-emerald-600">
                {{ $upDomains }}
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="text-sm font-medium text-slate-500">
                DOWN / TIMEOUT
            </div>

            <div class="mt-3 text-3xl font-bold text-red-600">
                {{ $downDomains }}
            </div>
        </div>
    </div>

    <div class="mt-8 rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
        <h2 class="text-lg font-semibold text-slate-900">
            Domain monitoring
        </h2>

        <p class="mt-2 text-sm text-slate-600">
            Add domains, configure check interval, timeout and request method.
            Automatic checks are executed by Laravel Scheduler.
        </p>

        <div class="mt-6">
            <a href="{{ route('domains.index') }}"
               class="inline-flex rounded-xl bg-blue-600 px-5 py-3 text-sm font-medium text-white transition hover:bg-blue-700">
                Manage Domains
            </a>
        </div>
    </div>

@endsection
