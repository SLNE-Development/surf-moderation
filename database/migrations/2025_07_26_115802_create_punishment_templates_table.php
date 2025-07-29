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
        Schema::create('punishment_templates', function (Blueprint $table) {
            $table->id();
            $table->string("category");
            $table->string("name");
            $table->text("description")->nullable();
            $table->enum("punishment_type", [
                "ban",
                "kick",
                "mute",
                "warn",
            ]);
            $table->integer("duration")->default(0); // Duration in seconds, 0 for permanent
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('punishment_templates');
    }
};
