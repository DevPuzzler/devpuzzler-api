<?php

namespace App\Http\Responses\JSON;

use App\Http\Responses\AbstractJsonResponse;
use App\Interfaces\Responses\JsonResponseInterface;
use App\Tools\ValueObjects\Responses\{JsonResponseDataVO, JsonResponseErrorVO};
use Symfony\Component\HttpFoundation\Response;

class PostResponse extends AbstractJsonResponse
{
    protected $statusCode = Response::HTTP_CREATED;

    public static function create(
        ?array $data = null,
        mixed $error = null,
        array $headers = [],
    ): JsonResponseInterface {
        return new self(
            new JsonResponseDataVO( $data ),
            new JsonResponseErrorVO( $error ),
            $headers
        );
    }
}
