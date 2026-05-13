<?php

namespace App\Console\Commands;

use App\Models\Domain;
use App\Services\DomainCheckService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

class CheckDomainsCommand extends Command
{
    protected $signature = 'domains:check';

    protected $description = 'Check active domains availability';

    public function handle(DomainCheckService $domainCheckService): int
    {
        $checked = 0;
        $failed = 0;

        Domain::query()
            ->where('is_active', true)
            ->where(function ($query): void {
                $query->whereNull('next_check_at')
                    ->orWhere('next_check_at', '<=', now());
            })
            ->orderBy('next_check_at')
            ->chunkById(100, function ($domains) use ($domainCheckService, &$checked, &$failed): void {
                foreach ($domains as $domain) {
                    try {
                        $domainCheckService->check($domain);
                        $checked++;
                    } catch (Throwable $exception) {
                        $failed++;

                        Log::error('Domain check failed unexpectedly.', [
                            'domain_id' => $domain->id,
                            'url' => $domain->url,
                            'error' => $exception->getMessage(),
                        ]);
                    }
                }
            });

        $this->info("Domain checks completed. Checked: {$checked}. Failed: {$failed}.");

        return self::SUCCESS;
    }
}
