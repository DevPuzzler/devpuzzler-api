<?php

namespace App\Http\Responses;

use App\Interfaces\Responses\JsonResponseInterface;
use InvalidArgumentException;
use App\Interfaces\Responses\{
    ResponseDataValueObjectInterface as ResponseContent,
    ResponseErrorValueObjectInterface as ResponseError
};
use App\Tools\ValueObjects\Responses\JsonResponseVO as JsonResponseData;
use Symfony\Component\HttpFoundation\{JsonResponse, Response};

abstract class AbstractJsonResponse extends JsonResponse implements JsonResponseInterface
{
    public const STATUS_CODE_EXCEPTION_PATTERN = 'Status code [%s] is not supported.';

    /** Override in child or end up with error */
    protected $statusCode = null;

    public function __construct(
        private readonly ResponseContent $responseContent,
        private readonly ResponseError   $responseError,
        array $headers = []
    ) {
        parent::__construct(
            $this->getResponseData()->getResponseDataArray(),
            $this->getValidatedStatusCode(),
            $headers
        );
    }

    protected function getValidatedStatusCode(): int
    {
        if ( !in_array( $this->statusCode, array_keys( self::$statusTexts ) ) ) {
            throw new InvalidArgumentException(
                sprintf( self::STATUS_CODE_EXCEPTION_PATTERN, $this->statusCode )
            );
        }

        return $this->statusCode;
    }

    public function getResponseData(): JsonResponseData
    {
        return new JsonResponseData (
            $this->responseContent,
            $this->responseError,
            $this->isSuccessResponse()
        );
    }

    protected function isSuccessResponse(): bool
    {
        return
            $this->getStatusCode() >= Response::HTTP_OK &&
            $this->getStatusCode() < Response::HTTP_MULTIPLE_CHOICES;
    }

}
