<x-mail::message>
# ⚠️ Pengingat Tugas Overdue

Halo {{ $task->user->name }},

Tugas berikut **sudah melewati deadline dan belum selesai**.

**Task:** {{ $task->title }}

**Project:** {{ $task->project->name }}

**Deadline:** {{ $task->due_date->timezone('Asia/Jakarta')->format('d F Y, H:i') }} WIB

@if($task->description)
**Deskripsi:**

{{ $task->description }}
@endif

Mohon segera selesaikan tugas tersebut.

<x-mail::button :url="route('tasks.index')">
Buka TaskHub
</x-mail::button>

Pengingat ini akan dikirim kembali setiap 24 jam selama tugas belum selesai.

Terima kasih,<br>
{{ config('app.name') }}
</x-mail::message>
