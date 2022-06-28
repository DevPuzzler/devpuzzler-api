<?php

namespace App\CQ\Commands\CommandHandler\PostCategories;

use App\CQ\Commands\Command\PostCategories\CreatePostCategoryCommand;
use App\Models\PostCategory;

class CreatePostCategoryCommandHandler
{
    public function __invoke(CreatePostCategoryCommand $command): void
    {
        PostCategory::create($command->getRequest()->validated());
    }
}
