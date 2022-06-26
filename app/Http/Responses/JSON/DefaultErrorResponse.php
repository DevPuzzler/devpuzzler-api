<?php

namespace App\Http\Responses\JSON;

use App\Http\Responses\AbstractJsonResponse;
use App\Interfaces\Responses\{
    ResponseDataValueObjectInterface as ResponseData,
    ResponseErrorValueObjectInterface as ResponseError,
    JsonResponseInterface
};
use App\Tools\ValueObjects\Responses\{
    JsonResponseDataVO,
    JsonResponseErrorVO
};
use Exception;
use Symfony\Component\HttpFoundation\Response;

class DefaultErrorResponse extends AbstractJsonResponse
{
    public const DEFAULT_ERROR_MESSAGE = 'Something went wrong.';

    protected $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;

    public function __construct(
        ResponseData $responseData = null,
        ResponseError $responseError = null,
        ?int $customStatusCode = null,
        array $headers = []
    ) {
        $this->statusCode = $customStatusCode ?? $this->statusCode;

        parent::__construct(
            $responseData,
            $responseError,
            $headers
        );
    }

    public static function buildFromException(Exception $exception): JsonResponseInterface
    {
        return new self(
            new JsonResponseDataVO(),
            new JsonResponseErrorVO($exception->getMessage()),
            $exception->getCode() === 0 ?
                Response::HTTP_INTERNAL_SERVER_ERROR :
                $exception->getCode()
        );
    }
}
