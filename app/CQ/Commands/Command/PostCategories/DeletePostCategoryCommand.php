<?php

namespace App\CQ\Commands\Command\PostCategories;

use App\Http\Requests\DeletePostCategoryRequest;

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
