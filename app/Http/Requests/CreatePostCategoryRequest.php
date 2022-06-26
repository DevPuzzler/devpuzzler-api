<?php

namespace App\Http\Requests;

use App\Models\PostCategories;
use Illuminate\Foundation\Http\FormRequest;

class CreatePostCategoryRequest extends FormRequest
{
    public function rules()
    {
        return [
            PostCategories::COLUMN_NAME => 'required|string|min:4',
            PostCategories::COLUMN_DESCRIPTION => 'required|string'
        ];
    }
}
