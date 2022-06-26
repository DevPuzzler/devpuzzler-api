<?php

namespace App\Tools\ValueObjects\Responses;

use App\Interfaces\Responses\{
    ResponseDataValueObjectInterface as ResponseContent,
    ResponseErrorValueObjectInterface as ResponseError
};

class JsonResponseVO
{
    public const PARAM_SUCCESS = 'success';
    public const PARAM_DATA = 'data';
    public const PARAM_ERROR = 'error';

    public function __construct(
        private readonly ResponseContent $responseContent,
        private readonly ResponseError   $responseError,
        private readonly ?bool $isSuccessResponse = null,
    ) {}

    /**
     * 'data' parameter for response content
     */
    public function getResponseContent(): ResponseContent
    {
        return $this->responseContent;
    }

    public function getResponseError(): ResponseError
    {
        return $this->responseError;
    }

    public function getIsSuccessResponse(): bool
    {
        return $this->isSuccessResponse;
    }

    public function getResponseDataArray(): array
    {
        return [
            self::PARAM_SUCCESS => $this->getIsSuccessResponse(),
            self::PARAM_DATA => $this->responseContent->getValue(),
            self::PARAM_ERROR => $this->responseError->getValue(),
        ];
    }
}
