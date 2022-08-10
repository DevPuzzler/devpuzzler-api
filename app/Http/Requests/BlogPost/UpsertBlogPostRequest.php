<?php

namespace App\Http\Requests\BlogPost;

use App\Http\Requests\AbstractGenericRequest;
use App\Models\BlogPost;

class UpsertBlogPostRequest extends AbstractGenericRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            BlogPost::COLUMN_TITLE => [
                'required',
                'string'
            ],
            BlogPost::COLUMN_EXCERPT => [
                'required',
                'string'
            ],
            BlogPost::COLUMN_CATEGORY_ID => [
                'required',
                'int',
                'exists:post_categories,id'
            ],
            BlogPost::COLUMN_CONTENT => [
                'required',
                'string'
            ],
            BlogPost::COLUMN_IS_ACTIVE => [
                'required',
                'boolean'
            ],
            BlogPost::COLUMN_IS_RESTRICTED => [
                'required',
                'boolean'
            ],
        ];
    }
}
