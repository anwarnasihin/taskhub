<x-mail::message>
# 🔔 Pengingat Deadline Task

Halo {{ $task->user->name }},

Ini adalah pengingat bahwa task berikut akan **jatuh tempo dalam 6 jam atau kurang**:

**Task:** {{ $task->title }}

**Project:** {{ $task->project->name }}

**Deadline:** {{ $task->due_date->format('d F Y, H:i') }} WIB

@if($task->description)
**Deskripsi:**

{{ $task->description }}
@endif

Mohon pastikan task tersebut sudah selesai sebelum deadline.

<x-mail::button :url="route('tasks.index')">
Buka TaskHub
</x-mail::button>

Terima kasih,<br>
{{ config('app.name') }}
</x-mail::message>



