<?php

namespace App\Http\Requests;

use App\Models\PostCategory;
use Illuminate\Foundation\Http\FormRequest;

class DeletePostCategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            PostCategory::COLUMN_ID => 'required|int|exists:post_categories,id'
        ];
    }

    public function all( $keys = null ): array
    {
        $data = parent::all();
        $data[PostCategory::COLUMN_ID] = $this->route(PostCategory::COLUMN_ID);

        return $data;
    }
}
