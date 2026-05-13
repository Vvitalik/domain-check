<div class="w-full overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

    <div class="flex items-center justify-between border-b border-slate-200 px-6 py-5">
        <div>
            <h2 class="text-lg font-semibold text-slate-900">
                Domains List
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Manage your domains and monitor their availability.
            </p>
        </div>

        <a href="{{ route('domains.create') }}"
           class="inline-flex items-center rounded-xl bg-blue-600 px-5 py-3 text-sm font-medium text-white transition hover:bg-blue-700">
            Add Domain
        </a>
    </div>

    <div class="overflow-x-auto">
        @include('domains.partials.table')
    </div>

</div>

@include('shared.pagination', ['paginator' => $all_domains, 'class' => 'js-domains-pagination'])
