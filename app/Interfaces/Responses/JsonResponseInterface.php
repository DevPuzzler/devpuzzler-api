<?php

namespace App\Interfaces\Responses;

use App\Tools\ValueObjects\Responses\JsonResponseVO as JsonResponseData;
use Exception;

interface JsonResponseInterface
{
    public function getStatusCode(): int;
    public function getResponseData(): JsonResponseData;
}
