<?php

namespace App\Http\Requests\PostCategory;

use App\Http\Requests\AbstractGenericRequest;
use App\Models\PostCategory;

class DeletePostCategoryRequest extends AbstractGenericRequest
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
