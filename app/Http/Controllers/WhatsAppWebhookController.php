<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class WhatsAppWebhookController extends Controller
{
    /**
     * Menerima webhook status pesan WhatsApp dari Meta.
     */
    public function handle(Request $request): Response
    {
        $appSecret = config('services.whatsapp.app_secret');

        if (empty($appSecret)) {
            Log::error('WhatsApp webhook: App Secret belum dikonfigurasi.');
            return response('Webhook belum dikonfigurasi', 500);
        }

        $signature = $request->header('X-Hub-Signature-256');
        $expectedSignature = 'sha256=' . hash_hmac(
            'sha256',
            $request->getContent(),
            $appSecret
        );

        if (
            ! is_string($signature) ||
            ! hash_equals($expectedSignature, $signature)
        ) {
            Log::warning('WhatsApp webhook: tanda tangan tidak valid.');
            return response('Invalid signature', 401);
        }

        $payload = $request->json()->all();

        foreach ($payload['entry'] ?? [] as $entry) {
            foreach ($entry['changes'] ?? [] as $change) {
                $value = $change['value'] ?? [];

                foreach ($value['statuses'] ?? [] as $status) {
                    Log::info('WhatsApp delivery status', [
                        'message_id' => $status['id'] ?? null,
                        'recipient_id' => $status['recipient_id'] ?? null,
                        'status' => $status['status'] ?? null,
                        'timestamp' => $status['timestamp'] ?? null,
                        'errors' => $status['errors'] ?? [],
                    ]);
                }
            }
        }

        return response('EVENT_RECEIVED', 200);
    }
}
