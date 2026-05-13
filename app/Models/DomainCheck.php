<?php

namespace App\Models;

use App\Enums\DomainStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DomainCheck extends Model
{
    use HasFactory;

    protected $fillable = [
        'domain_id',
        'checked_at',
        'status',
        'status_code',
        'response_time_ms',
        'error_message',
    ];

    protected function casts(): array
    {
        return [
            'checked_at' => 'datetime',
            'status' => DomainStatus::class,
            'status_code' => 'integer',
            'response_time_ms' => 'integer',
        ];
    }

    public function domain(): BelongsTo
    {
        return $this->belongsTo(Domain::class);
    }
}
