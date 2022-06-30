<?php

namespace App\CQ\Commands\Command\PostCategory;

use App\Http\Requests\PostCategory\DeletePostCategoryRequest;

class DeletePostCategoryCommand
{
    public function __construct(
        private readonly DeletePostCategoryRequest $request
    ) {}

    public function getRequest(): DeletePostCategoryRequest
    {
        return $this->request;
    }
}
