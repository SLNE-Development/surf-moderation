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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->char("transaction_id", 36)->unique();
            $table->foreignId("currency_id")->constrained("currencies")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId("sender_id")->nullable()->constrained("game_users")->nullOnDelete()->nullOnUpdate();
            $table->foreignId("receiver_id")->nullable()->constrained("game_users")->nullOnDelete()->nullOnUpdate();
            $table->decimal("amount", 16, 10);
            $table->longText("data");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
