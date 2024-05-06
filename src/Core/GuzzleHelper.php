<?php

declare(strict_types=1);

namespace App\Core;

use Psr\Http\Message\ResponseInterface;

class GuzzleHelper
{
    public static function responseToArray(ResponseInterface $response): array
    {
        return json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
    }
}
