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
        Schema::create('team_member_roles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_member_id')
                ->constrained('team_members')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->enum('role', ["administrator", "management", "developer", "builder", "moderator", "moderator-a", "supporter", "supporter-a"]);
            $table->dateTime("assigned_at");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_member_roles');
    }
};
