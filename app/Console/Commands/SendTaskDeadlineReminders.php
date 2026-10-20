<?php

namespace App\Console\Commands;

use App\Mail\TaskDeadlineReminderMail;
use App\Models\Task;
use App\Services\WhatsAppService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTaskDeadlineReminders extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'tasks:send-reminders';

    /**
     * The console command description.
     */
    protected $description = 'Mengirim pengingat 6 jam sebelum deadline task';

    public function __construct(
        private WhatsAppService $whatsapp
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $now = now('Asia/Jakarta');
        $sixHoursFromNow = $now->copy()->addHours(6);

        $this->info(
            "Sekarang: {$now->format('Y-m-d H:i:s')}"
        );

        $this->info(
            "Mencari task dengan deadline sampai: {$sixHoursFromNow->format('Y-m-d H:i:s')}"
        );

        $tasks = Task::with(['user', 'project'])
            ->where('is_completed', false)
            ->whereNotNull('due_date')
            ->where('due_date', '>', $now)
            ->where('due_date', '<=', $sixHoursFromNow)
            ->get();

        if ($tasks->isEmpty()) {
            $this->info('Tidak ada task yang perlu dikirim reminder.');
            return self::SUCCESS;
        }

        
        foreach ($tasks as $task) {
            if (!$task->user) {
                $this->warn(
                    "Task #{$task->id} dilewati karena user tidak ditemukan."
                );
                continue;
            }

            /*
            * EMAIL REMINDER
            */
            if ($task->email_reminder_sent_at === null) {
                if (!$task->user->email) {
                    $this->warn(
                        "Email reminder Task #{$task->id} dilewati: email user kosong."
                    );
                } else {
                    try {
                        Mail::to($task->user->email)
                            ->send(new TaskDeadlineReminderMail($task));

                        $task->email_reminder_sent_at = now('Asia/Jakarta');
                        $task->save();

                        $this->info(
                            "Email reminder terkirim untuk Task #{$task->id}: {$task->title}"
                        );
                    } catch (\Throwable $e) {
                        $this->error(
                            "Email reminder Task #{$task->id} gagal: {$e->getMessage()}"
                        );
                    }
                }
            } else {
                $this->info(
                    "Email reminder Task #{$task->id} sudah pernah terkirim."
                );
            }

            /*
            * WHATSAPP REMINDER
            */
            if (!config('services.whatsapp.enabled', false)) {
                $this->info(
                    "WhatsApp reminder OFF - Task #{$task->id} dilewati."
                );
                continue;
            }

            if ($task->whatsapp_reminder_sent_at !== null) {
                $this->info(
                    "WhatsApp reminder Task #{$task->id} sudah pernah terkirim."
                );
                continue;
            }

            if (!$task->user->whatsapp_number) {
                $this->warn(
                    "WhatsApp reminder Task #{$task->id} dilewati: nomor user kosong."
                );
                continue;
            }

            try {
                $result = $this->whatsapp->sendTemplate(
                    $task->user->whatsapp_number,
                    'task_deadline_reminder',
                    'id',
                    [
                        $task->user->name,
                        $task->title,
                        $task->project?->name ?? '-',
                        $task->due_date
                            ->timezone('Asia/Jakarta')
                            ->format('d F Y, H:i'),
                    ]
                );

                if ($result['success']) {
                    $task->whatsapp_reminder_sent_at = now('Asia/Jakarta');
                    $task->save();

                    $this->info(
                        "WhatsApp reminder diterima API untuk Task #{$task->id}: {$task->title}"
                    );

                    if (!empty($result['message_id'])) {
                        $this->line(
                            'Message ID: ' . $result['message_id']
                        );
                    }
                } else {
                    $this->error(
                        "WhatsApp reminder Task #{$task->id} gagal. " .
                        "HTTP {$result['status']} - " .
                        json_encode($result['data'])
                    );
                }
            } catch (\Throwable $e) {
                $this->error(
                    "WhatsApp reminder Task #{$task->id} gagal: {$e->getMessage()}"
                );
            }
        }


        return self::SUCCESS;
    }
}



