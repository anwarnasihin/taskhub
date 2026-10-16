<?php

namespace App\Console\Commands;

use App\Mail\TaskDeadlineReminderMail;
use App\Mail\TaskOverdueReminderMail;
use App\Models\Task;
use App\Services\WhatsAppService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTaskOverdueReminders extends Command
{
    protected $signature = 'tasks:send-overdue-reminders';

    protected $description = 'Mengirim pengingat harian untuk task overdue';

    public function __construct(
        private WhatsAppService $whatsapp
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $now = now('Asia/Jakarta');

        $this->info(
            "Memeriksa task overdue pada {$now->format('Y-m-d H:i:s')}"
        );


        $tasks = Task::with(['user', 'project'])
            ->where('is_completed', false)
            ->whereNotNull('due_date')
            ->where('due_date', '<', $now)
            ->get();


        if ($tasks->isEmpty()) {
            $this->info('Tidak ada task overdue yang perlu diingatkan.');

            return self::SUCCESS;
        }

        foreach ($tasks as $task) {
            try {
                if (!$task->user) {
                    $this->warn(
                        "Task #{$task->id} dilewati karena user tidak ditemukan."
                    );

                    continue;
                }

                /*
                 * EMAIL OVERDUE
                 */
                $lastEmail = $task->email_overdue_reminder_sent_at;

                $emailDue = $lastEmail === null
                    || $lastEmail->lte($now->copy()->subDay());

                if ($emailDue) {
                    if (!$task->user->email) {
                        $this->warn(
                            "Email Task #{$task->id} dilewati: email user kosong."
                        );
                    } else {
                        try {
                            Mail::to($task->user->email)
                                ->send(new TaskOverdueReminderMail($task));

                            $task->email_overdue_reminder_sent_at = $now;
                            $task->save();

                            $this->info(
                                "Email overdue terkirim untuk Task #{$task->id}."
                            );
                        } catch (\Throwable $e) {
                            $this->error(
                                "Email overdue Task #{$task->id} gagal: {$e->getMessage()}"
                            );
                        }
                    }
                }

                /*
                 * WHATSAPP OVERDUE
                 */
                $lastWhatsapp = $task->whatsapp_overdue_reminder_sent_at;

                $whatsappDue = $lastWhatsapp === null
                    || $lastWhatsapp->lte($now->copy()->subDay());

                if (
                    $whatsappDue
                    && config('services.whatsapp.enabled', false)
                ) {
                    if (!$task->user->whatsapp_number) {
                        $this->warn(
                            "WhatsApp Task #{$task->id} dilewati: nomor belum diisi."
                        );
                    } else {
                        try {
                            $result = $this->whatsapp->sendTemplate(
                                $task->user->whatsapp_number,
                                'task_overdue_reminder',
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
                                    $task->whatsapp_overdue_reminder_sent_at = $now;
                                    $task->save();

                                    $this->info(
                                        "WhatsApp overdue diterima API untuk Task #{$task->id}."
                                    );

                                    $this->line(
                                        'Message ID: ' . ($result['message_id'] ?? 'Tidak tersedia')
                                    );

                                    $this->line(
                                        'Message Status: ' . ($result['message_status'] ?? 'Belum tersedia')
                                    );
                                } else {
                                $this->error(
                                    "WhatsApp overdue Task #{$task->id} gagal. " .
                                    "HTTP {$result['status']} - " .
                                    json_encode($result['data'])
                                );
                            }
                        } catch (\Throwable $e) {
                            $this->error(
                                "WhatsApp overdue Task #{$task->id} gagal: {$e->getMessage()}"
                            );
                        }
                    }
                }
            } catch (\Throwable $e) {
                $this->error(
                    "Gagal memproses Task #{$task->id}: {$e->getMessage()}"
                );
            }
        }

        return self::SUCCESS;
    }
}
