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
        Schema::create('ticket_message_attachments', function (Blueprint $table) {
            $table->id();
            $table->char('attachment_id', 20)->nullable();
            $table->longText('filename')->nullable();
            $table->longText('url')->nullable();
            $table->longText('proxy_url')->nullable();
            $table->longText('waveform')->nullable();
            $table->string('content_type', 255)->nullable();
            $table->string('description', 1024)->nullable();
            $table->integer('size')->nullable();
            $table->integer('height')->nullable();
            $table->integer('width')->nullable();
            $table->boolean('ephemeral')->nullable();
            $table->float('duration_secs')->nullable();
            $table->foreignId('message_id')
                ->constrained('ticket_messages')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_message_attachments');
    }
};
