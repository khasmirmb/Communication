<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->id();
            $table->string('message_id')->unique(); // Unique message ID from Mailgun
            $table->string('from_email'); // Sender email
            $table->string('from_name')->nullable(); // Sender name
            $table->string('to_email'); // Recipient email
            $table->string('subject')->nullable(); // Email subject
            $table->text('body')->nullable(); // Email body
            $table->text('html_body')->nullable(); // Email body (HTML)
            $table->json('attachments')->nullable(); // Store attachments as JSON
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emails');
    }
};
