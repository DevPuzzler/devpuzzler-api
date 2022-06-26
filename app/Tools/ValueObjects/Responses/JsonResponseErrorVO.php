<?php

namespace App\Tools\ValueObjects\Responses;

use App\Interfaces\Responses\ResponseErrorValueObjectInterface;

class JsonResponseErrorVO implements ResponseErrorValueObjectInterface
{
    public function __construct(private readonly mixed $responseError = null) {}

    public function getValue(): mixed
    {
        return $this->responseError;
    }
}
