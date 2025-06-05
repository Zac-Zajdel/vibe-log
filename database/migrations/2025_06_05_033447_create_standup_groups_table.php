<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('standup_groups', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('owner_id')->constrained('users');
            $table->string('name');
            $table->text('description')->nullable();
            // TODO - Use ENUM...
            $table->string('visibility')->default('private');
            $table->boolean('is_active')->default(false);
            $table->json('days')->nullable();
            $table->string('timezone')->nullable();
            $table->boolean('send_reminders')->default(false);
            $table->datetime('reminder_time')->nullable();
            $table->dateTime('start_at')->nullable();
            $table->dateTime('end_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('standup_groups');
    }
};
