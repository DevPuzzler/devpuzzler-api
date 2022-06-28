<?php

namespace App\Http\Requests\BlogPost;

use App\Http\Requests\GenericCollectionRequest;
use App\Interfaces\CQ\Queries\Query\BlogPost\BlogPostCollectionInterface;

class BlogPostCollectionRequest extends GenericCollectionRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            ...$this->getCollectionRules(),
            BlogPostCollectionInterface::PARAM_INCLUDE_CATEGORY => ['boolean']
        ];
    }
}
