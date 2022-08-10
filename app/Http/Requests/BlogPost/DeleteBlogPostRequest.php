<?php

namespace App\Http\Requests\BlogPost;

use App\Http\Requests\AbstractGenericRequest;
use App\Models\BlogPost;

class DeleteBlogPostRequest extends AbstractGenericRequest
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
