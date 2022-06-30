<?php

namespace App\Http\Requests\BlogPost;

use App\Models\BlogPost;
use Illuminate\Foundation\Http\FormRequest;

class DeleteBlogPostRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            BlogPost::COLUMN_ID => [
                'required',
                'int',
                'exists:blog_posts,id'
            ]
        ];
    }

    public function all( $keys = null ): array
    {
        $data = parent::all();
        $data[BlogPost::COLUMN_ID] = $this->route(BlogPost::COLUMN_ID);

        return $data;
    }
}
