<?php

namespace App\Http\Requests;

use App\Http\Responses\JSON\DefaultErrorResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractGenericRequest extends FormRequest
{
    /**
     * Override original function to return unified format
     * of response.
     * IDE might highlight it as error, but it DOES EXTEND
     * Symfony\Component\HttpFoundation\Response
     */
    protected function failedValidation(Validator $validator)
    {
        if ($this->expectsJson()) {
            $errors = (new ValidationException($validator))->errors();
            throw new HttpResponseException(
                DefaultErrorResponse::create(
                    null,
                    $errors,
                    [],
                    Response::HTTP_UNPROCESSABLE_ENTITY
                )
            );
        }

        parent::failedValidation($validator);
    }
}
