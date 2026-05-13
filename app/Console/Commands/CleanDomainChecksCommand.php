<?php

namespace App\Console\Commands;

use App\Models\DomainCheck;
use Illuminate\Console\Command;

class CleanDomainChecksCommand extends Command
{
    protected $signature = 'domain-checks:clean {--days=30}';

    protected $description = 'Delete old domain check history records';

    public function handle(): int
    {
        $days = (int) $this->option('days');

        if ($days <= 0) {
            $this->error('Days must be > 0.');
            return self::FAILURE;
        }

        $deleted = 0;
        $cutoff = now()->subDays($days);

        DomainCheck::query()
            ->where('checked_at', '<', $cutoff)
            ->chunkById(1000, function ($checks) use (&$deleted): void {
                DomainCheck::query()
                    ->whereIn('id', $checks->pluck('id'))
                    ->delete();

                $deleted += $checks->count();
            });

        $this->info("Done. Deleted: {$deleted} records older than {$days} days.");

        return self::SUCCESS;
    }
}
