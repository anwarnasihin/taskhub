
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->timestamp('email_overdue_reminder_sent_at')
                ->nullable();

            $table->timestamp('whatsapp_overdue_reminder_sent_at')
                ->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn([
                'email_overdue_reminder_sent_at',
                'whatsapp_overdue_reminder_sent_at',
            ]);
        });
    }
};
