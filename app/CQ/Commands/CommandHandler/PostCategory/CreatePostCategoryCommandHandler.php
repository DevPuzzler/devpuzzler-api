<?php

namespace App\CQ\Commands\CommandHandler\PostCategory;

use App\CQ\Commands\Command\PostCategory\CreatePostCategoryCommand;
use App\Models\PostCategory;

class CreatePostCategoryCommandHandler
{
    public function __invoke(CreatePostCategoryCommand $command): void
    {
        PostCategory::create($command->getRequest()->validated());
    }
}
