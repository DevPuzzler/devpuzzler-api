<?php

namespace App\CQ\Commands\CommandHandler\PostCategories;

use App\CQ\Commands\Command\PostCategories\CreatePostCategoryCommand;
use App\Models\PostCategories;

class CreatePostCategoryCommandHandler
{
    public function __invoke(CreatePostCategoryCommand $command): void
    {
        PostCategories::create($command->getRequest()->validated());
    }
}
