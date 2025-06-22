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
        Schema::create('team_members', function (Blueprint $table) {
            $table->id();
            $table->char('minecraft_uuid', 36)->unique();
            $table->char("discord_id", 32)->unique();
            $table->char("twitch_id", 64)->unique();

            $table->string("username")->unique();
            $table->string("team_email")->unique();
            $table->string("private_email")->unique();

            $table->string("first_name")->nullable();
            $table->date("birth_date")->nullable();
            $table->string("address_state")->nullable();
            $table->string("job")->nullable();
            $table->enum("gender", ["male", "female", "other"])->default("male");

            $table->timestamp("joined_at")->nullable();
            $table->timestamp("exit_date")->nullable();

            $table->foreignId("user_id")->nullable()->constrained("users")->nullOnDelete()->nullOnUpdate();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_members');
    }
};
