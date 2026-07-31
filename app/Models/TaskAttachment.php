<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskAttachment extends Model
{
    protected $fillable = ['task_id', 'file_path', 'original_name', 'mime_type', 'file_size'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function icon(): string
    {
        return match(true) {
            str_starts_with($this->mime_type, 'image/') => 'image',
            $this->mime_type === 'application/pdf'      => 'pdf',
            default                                       => 'doc',
        };
    }
}
