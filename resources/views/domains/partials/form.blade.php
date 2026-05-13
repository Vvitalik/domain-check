<div class="space-y-6">

    <div>
        <label for="name" class="mb-2 block text-sm font-medium text-slate-700">
            Name
        </label>

        <input id="name"
               type="text"
               name="name"
               value="{{ old('name', $domain->name ?? '') }}"
               class="w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
               placeholder="Google">

        @error('name')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="url" class="mb-2 block text-sm font-medium text-slate-700">
            URL
        </label>

        <input id="url"
               type="url"
               name="url"
               value="{{ old('url', $domain->url ?? '') }}"
               class="w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
               placeholder="https://google.com">

        @error('url')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid gap-6 md:grid-cols-3">
        <div>
            <label for="interval_min" class="mb-2 block text-sm font-medium text-slate-700">
                Interval, minutes
            </label>

            <input id="interval_min"
                   type="number"
                   min="1"
                   max="1440"
                   name="interval_min"
                   value="{{ old('interval_min', $domain->interval_min ?? 3) }}"
                   class="w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

            @error('interval_min')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="timeout_sec" class="mb-2 block text-sm font-medium text-slate-700">
                Timeout, seconds
            </label>

            <input id="timeout_sec"
                   type="number"
                   min="1"
                   max="60"
                   name="timeout_sec"
                   value="{{ old('timeout_sec', $domain->timeout_sec ?? 5) }}"
                   class="w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

            @error('timeout_sec')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="method" class="mb-2 block text-sm font-medium text-slate-700">
                Method
            </label>

            <select id="method"
                    name="method"
                    class="w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                @foreach($methods as $method)
                    <option value="{{ $method->value }}"
                        @selected(old('method', isset($domain) ? $domain->method->value : 'GET') === $method->value)>
                        {{ $method->value }}
                    </option>
                @endforeach
            </select>

            @error('method')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <label class="flex items-center gap-3">
        <input type="checkbox"
               name="is_active"
               value="1"
               class="rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500"
            @checked(old('is_active', $domain->is_active ?? true))>

        <span class="text-sm font-medium text-slate-700">
            Active monitoring
        </span>
    </label>

</div>
