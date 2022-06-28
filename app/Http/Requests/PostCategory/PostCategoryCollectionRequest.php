<?php

namespace App\Http\Requests\PostCategory;

use App\Http\Requests\GenericCollectionRequest;
use App\Interfaces\CQ\Queries\Query\PostCategory\PostCategoryCollectionInterface;

class PostCategoryCollectionRequest extends GenericCollectionRequest
{
    public function rules(): array
    {
        return [
            ...$this->getCollectionRules(),
            PostCategoryCollectionInterface::PARAM_INCLUDE_POSTS => ['boolean']
        ];
    }
}
