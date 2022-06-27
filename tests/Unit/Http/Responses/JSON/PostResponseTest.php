<?php

namespace Tests\Unit\Http\Responses\JSON;

use App\Http\Responses\JSON\PostResponse;
use App\Interfaces\Responses\{
    JsonResponseInterface,
    ResponseDataValueObjectInterface as ResponseDataInterface,
    ResponseErrorValueObjectInterface as ResponseError
};

class PostResponseTest extends JsonResponseTest
{
    protected function getResponseInstance(
        ?ResponseDataInterface $responseData = null,
        ?ResponseError $responseError = null,
        array $headers = []
    ): ?JsonResponseInterface
    {
        return new PostResponse($responseData, $responseError, $headers);
    }
}
