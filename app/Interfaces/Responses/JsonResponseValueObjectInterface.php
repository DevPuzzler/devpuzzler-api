<?php

namespace App\Interfaces\Responses;

use App\Interfaces\Responses\{
    ResponseDataValueObjectInterface as ResponseData,
    ResponseErrorValueObjectInterface as ResponseError
};

interface JsonResponseValueObjectInterface
{
    public function getResponseData(): ResponseData;

    public function getResponseError(): ResponseError;

    public function getIsSuccessResponse(): bool;

    public function getResponseDataArray(): array;
}
