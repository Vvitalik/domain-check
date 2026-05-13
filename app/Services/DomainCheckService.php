<?php

namespace App\Services;

use App\Enums\DomainStatus;
use App\Models\Domain;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Throwable;
use App\Notifications\DomainStatusChangedNotification;

class DomainCheckService
{
    public function check(Domain $domain): void
    {
        $checkedAt = now();
        $startedAt = microtime(true);

        $status = DomainStatus::Down;
        $statusCode = null;
        $responseTimeMs = null;
        $errorMessage = null;

        try {
            $response = Http::timeout($domain->timeout_sec)
                ->send($domain->method->value, $domain->url);

            $responseTimeMs = (int)round((microtime(true) - $startedAt) * 1000);
            $statusCode = $response->status();

            $status = $response->successful() ? DomainStatus::Up : DomainStatus::Down;
        } catch (ConnectionException $exception) {
            $responseTimeMs = (int)round((microtime(true) - $startedAt) * 1000);
            $status = DomainStatus::Timeout;
            $errorMessage = $exception->getMessage();
        } catch (Throwable $exception) {
            $responseTimeMs = (int)round((microtime(true) - $startedAt) * 1000);
            $status = DomainStatus::Down;
            $errorMessage = $exception->getMessage();
        }

        $previousStatus = $domain->last_status;

        DB::transaction(function () use (
            $domain,
            $checkedAt,
            $status,
            $statusCode,
            $responseTimeMs,
            $errorMessage
        ): void {
            $domain->checks()->create([
                'checked_at' => $checkedAt,
                'status' => $status,
                'status_code' => $statusCode,
                'response_time_ms' => $responseTimeMs,
                'error_message' => $errorMessage,
            ]);

            $domain->update([
                'last_status' => $status,
                'last_checked_at' => $checkedAt,
                'next_check_at' => $checkedAt->copy()->addMinutes($domain->interval_min),
            ]);
        });

        if ($previousStatus !== $status && $previousStatus !== DomainStatus::Unknown) {
            $domain->user->notify(
                new DomainStatusChangedNotification(
                    domain: $domain,
                    previousStatus: $previousStatus,
                    currentStatus: $status,
                    statusCode: $statusCode,
                    responseTimeMs: $responseTimeMs,
                    errorMessage: $errorMessage,
                )
            );
        }
    }
}
