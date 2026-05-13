<?php

namespace App\Http\Controllers;

use App\Enums\DomainStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $user = Auth::user();

        $domains = $user->domains();

        $totalDomains = (clone $domains)->count();
        $activeDomains = (clone $domains)->where('is_active', true)->count();
        $upDomains = (clone $domains)->where('last_status', DomainStatus::Up->value)->count();
        $downDomains = (clone $domains)->whereIn('last_status', [
            DomainStatus::Down->value,
            DomainStatus::Timeout->value,
        ])->count();

        return view('dashboard', compact(
            'totalDomains',
            'activeDomains',
            'upDomains',
            'downDomains'
        ));
    }
}
