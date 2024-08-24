<?php

declare(strict_types=1);

namespace App\Core;

use GuzzleHttp\Client;

class GrowthMindsetService
{
    private Client $client;

    public function __construct(string $token)
    {
        $this->client = new Client([
            'base_uri' => 'https://rud.icu/api/',
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
        ]);
    }

    public function getRandomQuoteWithTranslation(string $locale): string
    {
        return $this->client->get('quotes/category/34?' . http_build_query(['language_code' => $locale]))
            ->getBody()
            ->getContents();
    }
}
