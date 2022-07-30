<?php

namespace App\Http\Requests\PostCategory;

use App\Http\Requests\GenericCollectionRequest;
use App\Interfaces\CQ\Queries\Query\PostCategory\PostCategoryCollectionQueryInterface;

class PostCategoryCollectionRequest extends GenericCollectionRequest
{
    public function rules(): array
    {
        return [
            ...$this->getCollectionRules(),
            PostCategoryCollectionQueryInterface::PARAM_INCLUDE_POSTS => ['boolean'],
            PostCategoryCollectionQueryInterface::PARAM_LIMIT_POSTS => ['int']
        ];
    }
}
