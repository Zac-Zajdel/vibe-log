<?php

declare(strict_types=1);

use App\Enums\StandupGroup\StandupGroupVisibility;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('standup_groups', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('workspace_id')->constrained();
            $table->foreignId('owner_id')->constrained('workspace_users');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('visibility')->default(StandupGroupVisibility::PRIVATE->value);
            $table->boolean('is_active')->default(false);
            $table->json('days')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('standup_groups');
    }
};
