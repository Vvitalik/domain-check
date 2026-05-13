@extends('layouts.app')

@section('header', 'Edit Domain')

@section('content')

    <div class="mx-auto max-w-4xl space-y-6">

        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">
                    {{ $domain->name }}
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Update domain monitoring settings and configuration.
                </p>
            </div>

            <a href="{{ route('domains.show', $domain) }}"
               class="rounded-xl border border-slate-300 px-5 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                Back
            </a>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-8 py-5">
                <h3 class="text-lg font-semibold text-slate-900">
                    Domain Settings
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Configure check interval, timeout and request method.
                </p>
            </div>

            <form id="update-domain-form"
                  method="POST"
                  action="{{ route('domains.update', $domain) }}"
                  class="p-8">

                @csrf
                @method('PUT')

                @include('domains.partials.form')
            </form>

            <div class="flex items-center justify-between border-t border-slate-200 px-8 py-6">

                <form method="POST"
                      action="{{ route('domains.destroy', $domain) }}"
                      onsubmit="return confirm('Delete this domain?')">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="rounded-xl border border-red-200 px-5 py-3 text-sm font-medium text-red-600 transition hover:bg-red-50">
                        Delete Domain
                    </button>
                </form>

                <div class="flex items-center gap-3">
                    <a href="{{ route('domains.index') }}"
                       class="rounded-xl border border-slate-300 px-5 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                        Cancel
                    </a>

                    <button type="submit"
                            form="update-domain-form"
                            class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-medium text-white transition hover:bg-blue-700">
                        Save Changes
                    </button>
                </div>

            </div>
        </div>

    </div>

@endsection
