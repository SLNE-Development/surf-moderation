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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->char("ticket_id", 36)->unique();

            $table->char("ticket_author_id", 20);
            $table->char("ticket_author_name", 64);
            $table->string("ticket_author_avatar_url")->nullable();

            $table->char("guild_id", 20)->nullable();
            $table->char("thread_id", 20)->nullable();
            $table->enum("ticket_type", ["survival_support", "event_support", "discord_support", "bugreport", "whitelist", "report", "unban"]);

            $table->timestamp("opened_at");

            $table->char("closed_by_id", 20)->nullable();
            $table->char("closed_by_name", 64)->nullable();
            $table->string("closed_by_avatar_url")->nullable();
            $table->timestamp("closed_at")->nullable();
            $table->longText("closed_reason")->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
