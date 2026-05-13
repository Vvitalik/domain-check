<?php

namespace App\Models;

use App\Enums\DomainCheckMethod;
use App\Enums\DomainStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Domain extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'url',
        'is_active',
        'interval_min',
        'timeout_sec',
        'method',
        'last_status',
        'last_checked_at',
        'next_check_at',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'interval_minutes' => 'integer',
            'timeout_seconds' => 'integer',
            'method' => DomainCheckMethod::class,
            'last_status' => DomainStatus::class,
            'last_checked_at' => 'datetime',
            'next_check_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function checks(): HasMany
    {
        return $this->hasMany(DomainCheck::class);
    }

    public function latestCheck(): HasOne
    {
        return $this->hasOne(DomainCheck::class)->latestOfMany('checked_at');
    }
}
