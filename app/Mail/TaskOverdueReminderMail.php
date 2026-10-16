<?php

namespace App\Mail;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TaskOverdueReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Task $task)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '⚠️ TaskHub - Pengingat Tugas Overdue: ' . $this->task->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.tasks.overdue-reminder',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
