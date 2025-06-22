<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('social_connections', function (Blueprint $table) {
            $table->id();
            $table->foreignId("game_user_id")
                ->constrained('game_users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->char('minecraft_uuid', 36)->unique();
            $table->char('discord_id', 20)->unique();
            $table->char('twitch_id', 64)->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_connections');
    }
};
