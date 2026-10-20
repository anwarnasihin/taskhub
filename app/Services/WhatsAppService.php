<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    /**
     * Mengirim pesan teks melalui layanan WhatsApp lokal.
     */
    public function sendText(string $to, string $message): array
    {
        return $this->sendLocalMessage($to, $message);
    }

    /**
     * Mempertahankan kompatibilitas dengan pemanggil lama.
     * Template Meta diubah menjadi pesan teks biasa.
     */
    public function sendTemplate(
        string $to,
        string $templateName,
        string $languageCode,
        array $parameters
    ): array {
        
        $heading = match ($templateName) {
            'task_deadline_reminder' =>
                '⏰ PENGINGAT DEADLINE TASKHUB',
            'task_overdue_reminder' =>
                '⚠️ PENGINGAT TUGAS TERLAMBAT - TASKHUB',
            default => '📌 PENGINGAT TASKHUB',
        };


        $lines = array_map(
            fn ($value) => (string) $value,
            $parameters
        );

        $message = $heading . "\n\n" . implode("\n", $lines);

        return $this->sendLocalMessage($to, $message);
    }

    /**
     * Mengirim pesan ke layanan Node.js Baileys.
     */
    private function sendLocalMessage(
        string $to,
        string $message
    ): array {
        $url = rtrim(
            (string) config(
                'services.whatsapp.local_url',
                'http://127.0.0.1:3001'
            ),
            '/'
        ) . '/send';

        $apiKey = (string) config(
            'services.whatsapp.local_key',
            ''
        );

        if ($apiKey === '') {
            return [
                'success' => false,
                'status' => 0,
                'data' => [
                    'error' => 'WHATSAPP_SERVICE_KEY belum dikonfigurasi.',
                ],
            ];
        }

        $phone = preg_replace('/\D+/', '', $to);

        if (!$phone || !preg_match('/^\d{10,15}$/', $phone)) {
            return [
                'success' => false,
                'status' => 422,
                'data' => [
                    'error' => 'Format nomor WhatsApp tidak valid.',
                ],
            ];
        }

        try {
            $response = Http::acceptJson()
                ->withHeaders([
                    'x-api-key' => $apiKey,
                ])
                ->timeout(20)
                ->post($url, [
                    'phone' => $phone,
                    'message' => $message,
                ]);

            $data = $response->json();

            return [
                'success' => $response->successful()
                    && (bool) data_get($data, 'success', false),
                'status' => $response->status(),
                'data' => $data,
            ];
        } catch (\Throwable $e) {
            Log::error('Gagal menghubungi layanan WhatsApp lokal.', [
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'status' => 0,
                'data' => [
                    'error' => 'Layanan WhatsApp lokal tidak dapat dihubungi.',
                ],
            ];
        }
    }
}
