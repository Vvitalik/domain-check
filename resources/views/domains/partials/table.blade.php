<table class="w-full divide-y divide-slate-200">
    <thead class="bg-slate-50">
    <tr>
        <th class="w-16 px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
            #
        </th>

        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
            Domain
        </th>

        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
            Status
        </th>

        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
            Method
        </th>

        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
            Interval
        </th>

        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
            Last Check
        </th>

        <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
            Actions
        </th>
    </tr>
    </thead>

    <tbody class="divide-y divide-slate-100 bg-white">

    @forelse($all_domains as $domain)

        <tr id="domain-row-{{ $domain->id }}" class="transition hover:bg-slate-50">

            <td class="whitespace-nowrap px-6 py-5 text-sm font-medium text-slate-500">
                {{ $loop->iteration + ($all_domains->currentPage() - 1) * $all_domains->perPage() }}
            </td>

            <td class="px-6 py-5">
                <div class="font-medium text-slate-900">
                    {{ $domain->name }}
                </div>

                <div class="mt-1 max-w-xl truncate text-sm text-slate-500">
                    {{ $domain->url }}
                </div>
            </td>

            <td class="px-6 py-5">
                <div data-status-badge>

                    @if($domain->last_status->value === 'up')

                        <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                UP
            </span>

                    @elseif($domain->last_status->value === 'down')

                        <span class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                DOWN
            </span>

                    @elseif($domain->last_status->value === 'timeout')

                        <span class="inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">
                TIMEOUT
            </span>

                    @else

                        <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                UNKNOWN
            </span>

                    @endif

                </div>
            </td>

            <td class="whitespace-nowrap px-6 py-5 text-sm font-medium text-slate-700">
                {{ $domain->method->value }}
            </td>

            <td class="whitespace-nowrap px-6 py-5 text-sm text-slate-600">
                {{ $domain->interval_min }} min
            </td>

            <td class="px-6 py-5 text-sm text-slate-600"
                data-last-check>
                {{ $domain->last_checked_at?->diffForHumans() ?? 'Never' }}
            </td>

            <td class="whitespace-nowrap px-6 py-5">
                <div class="flex items-center justify-end gap-2">

                    <a href="{{ route('domains.show', $domain) }}"
                       class="rounded-lg border border-slate-200 px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                        View
                    </a>

                    <a href="{{ route('domains.edit', $domain) }}"
                       class="rounded-lg border border-slate-200 px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                        Edit
                    </a>
                    <button type="button"
                            data-check-url="{{ route('domains.check', $domain) }}"
                            class="js-check-domain rounded-lg border border-emerald-200 px-3 py-2 text-sm font-medium text-emerald-700 transition hover:bg-emerald-50">
                        Check Now
                    </button>
                    <button type="button"
                            data-delete-url="{{ route('domains.destroy', $domain) }}"
                            class="js-delete-domain rounded-lg border border-red-200 px-3 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50">
                        Delete
                    </button>
                </div>
            </td>

        </tr>

    @empty

        <tr>
            <td colspan="7" class="px-6 py-20 text-center">
                <div class="mx-auto max-w-md">
                    <h3 class="text-base font-semibold text-slate-900">
                        No domains yet
                    </h3>

                    <p class="mt-2 text-sm text-slate-500">
                        Add your first domain to start automatic availability monitoring.
                    </p>

                    <div class="mt-6">
                        <a href="{{ route('domains.create') }}"
                           class="inline-flex items-center rounded-xl bg-blue-600 px-5 py-3 text-sm font-medium text-white transition hover:bg-blue-700">
                            Add Domain
                        </a>
                    </div>
                </div>
            </td>
        </tr>

    @endforelse

    </tbody>
</table>

