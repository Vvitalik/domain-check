<?php

namespace App\Http\Controllers;

use App\Enums\DomainCheckMethod;
use App\Enums\DomainStatus;
use App\Http\Requests\StoreDomainRequest;
use App\Http\Requests\UpdateDomainRequest;
use App\Models\Domain;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Services\DomainCheckService;
use Illuminate\Http\JsonResponse;

class DomainController extends Controller
{
    use AuthorizesRequests;

    public function index(): View
    {
        $all_domains = Auth::user()->domains()->with('latestCheck')->latest()->paginate(10);

        if (request()->ajax()) {
            return view('domains.partials.async-table', compact('all_domains'));
        }

        return view('domains.index', compact('all_domains'));
    }

    public function create()
    {
        return view('domains.create', ['methods' => DomainCheckMethod::cases()]);
    }

    public function store(StoreDomainRequest $request)
    {
        Auth::user()->domains()->create([
            ...$request->validated(),
            'is_active' => $request->boolean('is_active'),
            'last_status' => DomainStatus::Unknown,
            'next_check_at' => now(),
        ]);

        return redirect()->route('domains.index')->with('success', 'Domain Created.');
    }

    public function show(Domain $domain): View
    {
        $this->authorize('view', $domain);

        $domain->load('latestCheck');

        $checks = $domain->checks()->latest('checked_at')->paginate(6);

        if (request()->ajax()) {
            return view('domains.partials.async-checks-table', compact('domain', 'checks'));
        }

        return view('domains.show', compact('domain', 'checks'));
    }

    public function edit(Domain $domain): View
    {
        $this->authorize('update', $domain);

        return view('domains.edit', [
            'domain' => $domain,
            'methods' => DomainCheckMethod::cases(),
        ]);
    }

    public function update(UpdateDomainRequest $request, Domain $domain): RedirectResponse
    {
        $this->authorize('update', $domain);

        $domain->update([
            ...$request->validated(),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('domains.show', $domain)->with('success', 'Domain was updated.');
    }

    public function destroy(Domain $domain)
    {
        $this->authorize('delete', $domain);

        $domain->delete();

        if (request()->wantsJson()) {
            return response()->json(['message' => 'Domain was deleted']);
        }

        return redirect()->route('domains.index')->with('success', 'Domain was deleted.');
    }

    public function check(Domain $domain, DomainCheckService $domainCheckService): JsonResponse
    {
        $this->authorize('update', $domain);

        $domainCheckService->check($domain);
        $domain->refresh();

        return response()->json([
            'message' => 'Domain check completed.',
            'status' => $domain->last_status->value,
            'last_checked_at' => $domain->last_checked_at?->diffForHumans(),
        ]);
    }
}
