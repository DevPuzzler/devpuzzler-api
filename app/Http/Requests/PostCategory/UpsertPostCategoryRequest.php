<?php

namespace App\Http\Requests\PostCategory;

use App\Http\Requests\AbstractGenericRequest;
use App\Models\PostCategory;

class UpsertPostCategoryRequest extends AbstractGenericRequest
{
    public function rules()
    {
        return [
            PostCategory::COLUMN_NAME => 'required|string|min:4',
            PostCategory::COLUMN_DESCRIPTION => 'required|string'
        ];
    }
}
