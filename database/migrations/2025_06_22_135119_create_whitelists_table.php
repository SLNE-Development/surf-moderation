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
        Schema::create('whitelists', function (Blueprint $table) {
            $table->id();
            $table->char("uuid", 36);
            $table->string("server");
            $table->boolean("blocked")->default(false);
            $table->foreignId("game_user_id")->constrained("game_users")->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();

            $table->unique(['uuid', 'server'], 'whitelist_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whitelists');
    }
};
