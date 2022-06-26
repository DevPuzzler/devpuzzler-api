<?php

namespace App\Http\Responses\JSON;

use App\Http\Responses\AbstractJsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PostResponse extends AbstractJsonResponse
{
    protected $statusCode = Response::HTTP_CREATED;
}
