<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WhatsAppWebhookController;

Route::post('/whatsapp/webhook', [
    WhatsAppWebhookController::class,
    'handle',
]);

Route::get('/test', function () {
    return response()->json([
        'success' => true,
        'message' => 'TaskHub API aktif',
    ]);
});

/*
|--------------------------------------------------------------------------
| WhatsApp Webhook Verification
|--------------------------------------------------------------------------
*/

Route::get('/whatsapp/webhook', function (Request $request) {

    $mode = $request->query('hub_mode');
    $token = $request->query('hub_verify_token');
    $challenge = $request->query('hub_challenge');

    if (
        $mode === 'subscribe' &&
        $token === config('services.whatsapp.webhook_verify_token')
    ) {
        return response($challenge, 200)
            ->header('Content-Type', 'text/plain');
    }

    return response('Forbidden', 403);
});
