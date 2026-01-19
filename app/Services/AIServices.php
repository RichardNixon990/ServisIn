<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Psy\Util\Str;
use Throwable;

class AIServices
{
    protected Client $client;
    protected string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.key');

        $this->client = new Client([
            'base_uri' => 'https://generativelanguage.googleapis.com',
            'timeout'  => 30,
        ]);
    }

    public function estimasiRepair(string $deskripsi, string $merk, String $device_type): ?array
    {
        Log::info('DESKRIPSI:', [$deskripsi]);
        Log::info('MERK:', [$merk]);

        $prompt = <<<PROMPT
BALASAN WAJIB JSON VALID.
JANGAN GUNAKAN MARKDOWN.
JANGAN TAMBAHKAN TEKS APA PUN SELAIN JSON.

Struktur WAJIB:
{
  "spareparts": [
    { "nama": string, "harga": number }
  ],
  "estimasi": {
    "total_harga_sparepart": number,
    "biaya_jasa": number,
    "total_estimasi": number
  }
}

GUNAKAN ESTIMASI HARGA OFFICIAL STORE ATAU HARGA PASAR UMUM DI INDONESIA TERUTAMA PULAU JAWA, DAN PASTIKAN CROSSCHECK HARGA DI BEBERAPA SUMBER. JANGAN KEMAHALAN JANGAN KEMURAHAN, PASTIKAN DEVICE SESUAI DENGAN MERK DAN JENIS DEVICE BERDASARKAN DATA.
PROMPT;

        $body = [
            'contents' => [
                [
                    'parts' => [
                        [
                            'text' => "JENIS DEVICE :{$device_type} (DESKRIPSI KERUSAKAN : {$deskripsi}, MERK DEVICE: {$merk})\n{$prompt}"
                        ]
                    ]
                ]
            ]
        ];

        try {
            $response = $this->client->post(
                '/v1beta/models/gemini-2.5-flash-lite:generateContent',
                [
                    'headers' => [
                        'Content-Type'   => 'application/json',
                        'X-goog-api-key' => $this->apiKey,
                    ],
                    'json' => $body,
                ]
            );

            $content = (string) $response->getBody();

            Log::info('AI RAW RESPONSE:');
            Log::info($content);

            $data = json_decode($content, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::warning('JSON tidak valid, mencoba extract manual');
                return $this->extractJson($content);
            }

            return $data;

        } catch (Throwable $e) {
            Log::error('GEMINI ERROR: ' . $e->getMessage());
            return null;
        }
    }

    private function extractJson(string $text): ?array
    {
        $text = str_replace(['```json', '```'], '', $text);
        $text = trim($text);

        $start = strpos($text, '{');
        $end   = strrpos($text, '}');

        if ($start === false || $end === false) {
            return null;
        }

        $json = substr($text, $start, $end - $start + 1);
        return json_decode($json, true);
    }
}
