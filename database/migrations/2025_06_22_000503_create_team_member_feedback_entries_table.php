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
        Schema::create('team_member_feedback_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_member_feedback_id')
                ->constrained('team_member_feedback')
                ->cascadeOnDelete();
            $table->foreignId("author_id")
                ->constrained('users')
                ->cascadeOnDelete();
            $table->enum("feedback_type", ["minecraft", "teamspeak", "discord", "ticket"]);
            $table->longText("content")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_member_feedback_entries');
    }
};
