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
        Schema::create('ticket_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId("ticket_id")
                ->constrained("tickets")
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->char("author_id", 20);
            $table->string("author_name", 64);
            $table->string("author_avatar_url")->nullable();
            $table->longText("json_content")->nullable();
            $table->char("references_message_id", 20)->nullable();
            $table->char("message_id", 20)->unique();
            $table->boolean("bot_message")->default(false);
            $table->timestamp("message_created_at")->nullable();
            $table->timestamp("message_edited_at")->nullable();
            $table->timestamp("message_deleted_at")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_messages');
    }
};
