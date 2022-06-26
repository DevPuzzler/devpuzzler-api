<?php

namespace App\Tools\ValueObjects\Responses;

use App\Interfaces\Responses\ResponseDataValueObjectInterface;

class JsonResponseDataVO implements ResponseDataValueObjectInterface
{
    public function __construct(private readonly ?array $responseContent = null) {}

    public function getValue(): ?array
    {
        return $this->responseContent;
    }
}
