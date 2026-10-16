<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| TaskHub Scheduled Tasks
|--------------------------------------------------------------------------
|
| Pengingat deadline task dijalankan setiap hari pukul 08:00
| berdasarkan timezone Asia/Jakarta.
|
*/

Schedule::command('tasks:send-reminders')
    ->everyMinute()
    ->timezone('Asia/Jakarta');

// Sementara dinonaktifkan sampai pengujian overdue selesai.
// Schedule::command('tasks:send-overdue-reminders')
//     ->everyMinute()
//     ->timezone('Asia/Jakarta');



