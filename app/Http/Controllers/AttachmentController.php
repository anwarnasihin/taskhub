<?php

namespace App\Http\Controllers;

use App\Models\TaskAttachment;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    public function destroy(TaskAttachment $attachment)
    {
        // Proteksi kepemilikan via task
        abort_if($attachment->task->user_id !== auth()->id(), 403);

        // Hapus file fisik dari storage public
        Storage::disk('public')->delete($attachment->file_path);

        // Hapus record dari database
        $attachment->delete();

        return back()->with('success', 'Lampiran berhasil dihapus!');
    }
}
