<?php

namespace App\CQ\Commands\Command\PostCategory;

use App\Http\Requests\PostCategory\CreatePostCategoryRequest;

class CreatePostCategoryCommand
{
    public function __construct(
        private readonly CreatePostCategoryRequest $request
    ) {}

    public function getRequest(): CreatePostCategoryRequest
    {
        return $this->request;
    }
}
