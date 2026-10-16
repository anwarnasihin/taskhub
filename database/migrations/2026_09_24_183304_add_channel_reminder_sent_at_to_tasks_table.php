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
        Schema::table('tasks', function (Blueprint $table) {
            $table->timestamp('email_reminder_sent_at')
                ->nullable()
                ->after('reminder_sent_at');

            $table->timestamp('whatsapp_reminder_sent_at')
                ->nullable()
                ->after('email_reminder_sent_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn([
                'email_reminder_sent_at',
                'whatsapp_reminder_sent_at',
            ]);
        });
    }
};
