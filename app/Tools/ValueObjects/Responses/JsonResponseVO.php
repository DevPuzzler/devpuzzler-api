<?php

namespace App\Tools\ValueObjects\Responses;

use App\Interfaces\Responses\{JsonResponseValueObjectInterface,
    ResponseDataValueObjectInterface as ResponseData,
    ResponseErrorValueObjectInterface as ResponseError};

class JsonResponseVO implements JsonResponseValueObjectInterface
{
    public const PARAM_SUCCESS = 'success';
    public const PARAM_DATA = 'data';
    public const PARAM_ERROR = 'error';

    public function __construct(
        private readonly ResponseData $responseData,
        private readonly ResponseError   $responseError,
        private readonly ?bool $isSuccessResponse = null,
    ) {}

    /**
     * 'data' parameter for response content
     */
    public function getResponseData(): ResponseData
    {
        return $this->responseData;
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
            self::PARAM_DATA => $this->getResponseData()->getValue(),
            self::PARAM_ERROR => $this->getResponseError()->getValue(),
        ];
    }
}
