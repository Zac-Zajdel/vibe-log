<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workspace_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workspace_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->boolean('is_active')->default(false);
            $table->timestamp('joined_at')->nullable();
            $table->timestamps();

            $table->unique(['workspace_id', 'user_id']);
            $table->index(['user_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workspace_users');
    }
};
