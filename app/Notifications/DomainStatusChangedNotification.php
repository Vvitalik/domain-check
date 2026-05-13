<?php

namespace App\Notifications;

use App\Enums\DomainStatus;
use App\Models\Domain;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DomainStatusChangedNotification extends Notification
{
    use Queueable;

    public function __construct(
        private readonly Domain $domain,
        private readonly DomainStatus $previousStatus,
        private readonly DomainStatus $currentStatus,
        private readonly ?int $statusCode = null,
        private readonly ?int $responseTimeMs = null,
        private readonly ?string $errorMessage = null,
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $isRecovered = $this->currentStatus === DomainStatus::Up;

        return (new MailMessage)
            ->subject($isRecovered ? "Domain recovered: {$this->domain->name}" : "Domain problem detected: {$this->domain->name}")
            ->greeting('Domain Monitor')
            ->line("Domain: {$this->domain->name}")
            ->line("URL: {$this->domain->url}")
            ->line("Previous status: {$this->previousStatus->value}")
            ->line("Current status: {$this->currentStatus->value}")
            ->line('HTTP code: ' . ($this->statusCode ?? 'N/A'))
            ->line('Response time: ' . ($this->responseTimeMs ? "{$this->responseTimeMs} ms" : 'N/A'))
            ->line('Error: ' . ($this->errorMessage ?: 'N/A'))
            ->action('Open dashboard', url('/dashboard'));
    }
}
