@extends('layouts.app')

@section('header', 'Create Domain')

@section('content')

    <div class="max-w-3xl">
        <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
            <form method="POST" action="{{ route('domains.store') }}">
                @csrf

                @include('domains.partials.form')

                <div class="mt-8 flex items-center gap-3">
                    <button type="submit"
                            class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-medium text-white transition hover:bg-blue-700">
                        Create Domain
                    </button>

                    <a href="{{ route('domains.index') }}"
                       class="rounded-xl border border-slate-300 px-5 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

@endsection
