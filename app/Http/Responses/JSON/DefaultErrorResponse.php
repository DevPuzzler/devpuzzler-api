<?php

namespace App\Http\Responses\JSON;

use App\Http\Responses\AbstractJsonResponse;
use App\Tools\ValueObjects\Responses\JsonResponseDataVO;
use App\Tools\ValueObjects\Responses\JsonResponseErrorVO;
use App\Interfaces\Responses\{JsonResponseInterface,
    ResponseDataValueObjectInterface as ResponseData,
    ResponseErrorValueObjectInterface as ResponseError};
use Symfony\Component\HttpFoundation\Response;

class DefaultErrorResponse extends AbstractJsonResponse
{
    public const DEFAULT_ERROR_MESSAGE = 'Something went wrong.';

    protected $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;

    public function __construct(
        ResponseData $responseData = null,
        ResponseError $responseError = null,
        array $headers = [],
        ?int $customStatusCode = null
    ) {
        $this->statusCode = $customStatusCode ?? $this->statusCode;

        parent::__construct(
            $responseData,
            $responseError,
            $headers
        );
    }

    public static function create(
        ?array $data,
        mixed $error = null,
        array $headers = [],
        ?int $customStatusCode = null,
    ): JsonResponseInterface {
        return new self(
            new JsonResponseDataVO( $data ),
            new JsonResponseErrorVO( $error ?? self::DEFAULT_ERROR_MESSAGE ),
            $headers,
            $customStatusCode
        );
    }
}
