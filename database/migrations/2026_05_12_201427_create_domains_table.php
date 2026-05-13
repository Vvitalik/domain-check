<?php

use App\Enums\DomainStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('domains', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('url', 2048);
            $table->boolean('is_active')->default(true);
            $table->string('name');
            $table->unsignedSmallInteger('interval_min')->default(10);
            $table->unsignedSmallInteger('timeout_sec')->default(15);
            $table->string('method', 10)->default('GET');
            $table->string('last_status', 20)->default('unknown');
            $table->timestamp('last_checked_at')->nullable();
            $table->timestamp('next_check_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'is_active']);
            $table->index(['user_id', 'created_at']);
            $table->index(['is_active', 'next_check_at']);
            $table->index(['last_status', 'last_checked_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('domains');
    }
};
