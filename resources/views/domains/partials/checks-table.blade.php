<table class="w-full divide-y divide-slate-200">
    <thead class="bg-slate-50">
    <tr>
        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
            Checked At
        </th>

        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
            Status
        </th>

        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
            Code
        </th>

        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
            Response Time
        </th>

        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
            Error
        </th>
    </tr>
    </thead>

    <tbody class="divide-y divide-slate-100 bg-white">
    @forelse($checks as $check)
        <tr class="transition hover:bg-slate-50">
            <td class="whitespace-nowrap px-6 py-5 text-sm text-slate-600">
                {{ $check->checked_at->format('Y-m-d H:i:s') }}
            </td>

            <td class="whitespace-nowrap px-6 py-5">
                @if($check->status->value === 'up')
                    <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                        UP
                    </span>
                @elseif($check->status->value === 'down')
                    <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                        DOWN
                    </span>
                @elseif($check->status->value === 'timeout')
                    <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">
                        TIMEOUT
                    </span>
                @else
                    <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                        UNKNOWN
                    </span>
                @endif
            </td>

            <td class="whitespace-nowrap px-6 py-5 text-sm text-slate-600">
                {{ $check->status_code ?? '—' }}
            </td>

            <td class="whitespace-nowrap px-6 py-5 text-sm text-slate-600">
                {{ $check->response_time_ms ? $check->response_time_ms . ' ms' : '—' }}
            </td>

            <td class="px-6 py-5 text-sm text-slate-600">
                <span class="line-clamp-2">
                    {{ $check->error_message ?? '—' }}
                </span>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5" class="px-6 py-16 text-center text-slate-500">
                No checks yet.
            </td>
        </tr>
    @endforelse
    </tbody>
</table>
