<?php

namespace App\Http\Requests\PostCategory;

use App\Models\PostCategory;
use Illuminate\Foundation\Http\FormRequest;

class CreatePostCategoryRequest extends FormRequest
{
    public function rules()
    {
        return [
            PostCategory::COLUMN_NAME => 'required|string|min:4',
            PostCategory::COLUMN_DESCRIPTION => 'required|string'
        ];
    }
}
