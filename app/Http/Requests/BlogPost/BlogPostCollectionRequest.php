<?php

namespace App\Http\Requests\BlogPost;

use App\Http\Requests\GenericCollectionRequest;
use App\Interfaces\CQ\Queries\Query\BlogPost\BlogPostCollectionQueryInterface;
use App\Models\BlogPost;

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
            BlogPostCollectionQueryInterface::PARAM_INCLUDE_CATEGORY => ['boolean'],
            BlogPost::COLUMN_CATEGORY_ID => ['int'],
        ];
    }
}
