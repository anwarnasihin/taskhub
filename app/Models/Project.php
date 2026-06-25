<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    // Mengizinkan kolom-kolom ini diisi secara massal
    protected $fillable = ['user_id', 'name', 'color'];

    /**
     * Relasi balik ke User (Satu project dimiliki oleh satu user)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 👇 TAMBAHKAN FUNGSI INI DI PALING BAWAH
     * Relasi ke Model Task (Satu project bisa memiliki banyak task)
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
