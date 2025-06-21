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
        Schema::create('ban_ip_addresses', function (Blueprint $table) {
            $table->id();
            $table->char("ip_address", 45);
            $table->foreignId('punishment_id')
                ->constrained('bans', 'id')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ban_ip_addresses');
    }
};
