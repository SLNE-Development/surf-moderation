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
        Schema::create('bans', function (Blueprint $table) {
            $table->id();
            $table->char("punishment_id", 8)->unique();
            $table->char("punished_uuid", 36)->index();
            $table->longText("reason")->nullable();
            $table->char("issuer_uuid", 36)->nullable();
            $table->boolean("unpunished")->default(false);
            $table->timestamp("unpunished_date")->nullable();
            $table->char("unpunisher_uuid", 36)->nullable();
            $table->timestamp("expiration_date")->nullable();
            $table->boolean("permanent")->default(false);
            $table->boolean("security_ban")->default(false);
            $table->boolean("raw")->default(false);
            $table->foreignId("parent_id")->nullable();
            $table->timestamps();
        });

        Schema::table("bans", function (Blueprint $table) {
            $table->foreign("parent_id")
                ->references("id")
                ->on("bans")
                ->nullOnDelete()
                ->nullOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bans');
    }
};
