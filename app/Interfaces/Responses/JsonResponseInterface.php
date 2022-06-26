<?php

namespace App\Interfaces\Responses;

use App\Tools\ValueObjects\Responses\JsonResponseVO as JsonResponseData;

interface JsonResponseInterface
{
    public function getStatusCode(): int;

    public function getResponseData(): JsonResponseData;

    public static function create(
        ?array $data,
        mixed $error,
        array $headers = []
    ): self;
}
