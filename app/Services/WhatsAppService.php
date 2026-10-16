<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhatsAppService
{
    public function sendText(string $to, string $message): array
    {
        $version = config('services.whatsapp.api_version');
        $phoneNumberId = config('services.whatsapp.phone_number_id');
        $accessToken = config('services.whatsapp.access_token');

        $url = "https://graph.facebook.com/{$version}/{$phoneNumberId}/messages";

        $response = Http::withToken($accessToken)
            ->post($url, [
                'messaging_product' => 'whatsapp',
                'to' => $to,
                'type' => 'text',
                'text' => [
                    'body' => $message,
                ],
            ]);

        return [
            'success' => $response->successful(),
            'status' => $response->status(),
            'data' => $response->json(),
        ];
    }

    public function sendTemplate(
        string $to,
        string $templateName,
        string $languageCode,
        array $parameters
    ): array {
        $version = config('services.whatsapp.api_version');
        $phoneNumberId = config('services.whatsapp.phone_number_id');
        $accessToken = config('services.whatsapp.access_token');

        $url = "https://graph.facebook.com/{$version}/{$phoneNumberId}/messages";

        $bodyParameters = array_map(
            fn ($value) => [
                'type' => 'text',
                'text' => (string) $value,
            ],
            $parameters
        );

        $response = Http::withToken($accessToken)
            ->post($url, [
                'messaging_product' => 'whatsapp',
                'to' => $to,
                'type' => 'template',
                'template' => [
                    'name' => $templateName,
                    'language' => [
                        'code' => $languageCode,
                    ],
                    'components' => [
                        [
                            'type' => 'body',
                            'parameters' => $bodyParameters,
                        ],
                    ],
                ],
            ]);

            $data = $response->json();

            return [
                'success' => $response->successful(),
                'status' => $response->status(),
                'message_id' => data_get($data, 'messages.0.id'),
                'message_status' => data_get($data, 'messages.0.message_status'),
                'data' => $data,
            ];
    }
}



