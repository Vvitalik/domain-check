<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

    <div class="border-b border-slate-200 px-6 py-5">
        <h3 class="text-lg font-semibold text-slate-900">
            Checks History
        </h3>

        <p class="mt-1 text-sm text-slate-500">
            Latest domain monitoring results.
        </p>
    </div>

    <div class="overflow-x-auto">
        @include('domains.partials.checks-table')
    </div>

</div>

@include('shared.pagination', ['paginator' => $checks, 'class' => 'js-domain-checks-pagination'])
