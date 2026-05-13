@if ($paginator->hasPages())

    <div class="mt-6 flex items-center justify-between {{ $class }}">

        <div class="text-sm text-slate-500">
            Showing
            {{ $paginator->firstItem() }}
            -
            {{ $paginator->lastItem() }}
            of
            {{ $paginator->total() }}
            results
        </div>

        <div class="flex items-center gap-2">

            @if ($paginator->onFirstPage())

                <span class="rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-400">
                    ‹
                </span>

            @else

                <a href="{{ $paginator->previousPageUrl() }}"
                   class="rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-700 transition hover:bg-slate-50">
                    ‹
                </a>

            @endif

            @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)

                @if ($page === $paginator->currentPage())

                    <span class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white">
                        {{ $page }}
                    </span>

                @else

                    <a href="{{ $url }}"
                       class="rounded-lg border border-slate-200 px-4 py-2 text-sm text-slate-700 transition hover:bg-slate-50">
                        {{ $page }}
                    </a>

                @endif

            @endforeach

            @if ($paginator->hasMorePages())

                <a href="{{ $paginator->nextPageUrl() }}"
                   class="rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-700 transition hover:bg-slate-50">
                    ›
                </a>

            @else

                <span class="rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-400">
                    ›
                </span>

            @endif

        </div>

    </div>

@endif
