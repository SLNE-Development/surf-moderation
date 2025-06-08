<?php

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
        Schema::create('game_user_name_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_user_id')
                ->constrained('game_users')
                ->onDelete('cascade');
            $table->char('username', 16);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_user_name_histories');
    }
};
