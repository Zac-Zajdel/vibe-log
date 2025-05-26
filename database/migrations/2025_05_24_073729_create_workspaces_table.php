<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workspaces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('users');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('logo')->nullable();
            $table->boolean('is_default')->default(false);
            $table->timestamp('archived_at')->nullable();
            $table->timestamps();

            $table->unique(['owner_id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workspaces');
    }
};
