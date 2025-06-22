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
        Schema::create('team_member_contact_people', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_member_id')
                ->constrained('team_members')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId("contact_person_id")
                ->nullable()
                ->constrained("team_members")
                ->nullOnDelete()
                ->nullOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_member_contact_people');
    }
};
