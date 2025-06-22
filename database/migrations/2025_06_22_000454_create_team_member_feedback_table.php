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
        Schema::create('team_member_feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_member_id')
                ->constrained('team_members')
                ->cascadeOnDelete();
            $table->longText("content")->nullable();
            $table->timestamp("due_at")->nullable();
            $table->boolean("should_notify_supervisors")->default(false);
            $table->timestamp("closed_at")->nullable();
            $table->foreignId("closed_by")
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_member_feedback');
    }
};
