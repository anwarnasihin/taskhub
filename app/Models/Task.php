<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'user_id',
        'title',
        'description',
        'priority',
        'due_date',
        'is_completed',
        'reminder_sent_at',
        'email_reminder_sent_at',
        'whatsapp_reminder_sent_at',
        'email_overdue_reminder_sent_at',
        'whatsapp_overdue_reminder_sent_at',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'is_completed' => 'boolean',
        'reminder_sent_at' => 'datetime',
        'email_reminder_sent_at' => 'datetime',
        'whatsapp_reminder_sent_at' => 'datetime',
        'email_overdue_reminder_sent_at' => 'datetime',
        'whatsapp_overdue_reminder_sent_at' => 'datetime',
    ];

    public function project() { return $this->belongsTo(Project::class); }
    public function user()    { return $this->belongsTo(User::class); }

    public function isOverdue(): bool
    {
        return ! $this->is_completed
            && $this->due_date !== null
            && $this->due_date->isPast();
    }

    public function attachments()
    {
        return $this->hasMany(TaskAttachment::class);
    }
}
