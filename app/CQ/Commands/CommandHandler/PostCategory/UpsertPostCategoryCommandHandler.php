<?php

namespace App\CQ\Commands\CommandHandler\PostCategory;

use App\CQ\Commands\Command\PostCategory\UpsertPostCategoryCommand;
use App\Models\PostCategory;

class UpsertPostCategoryCommandHandler
{
    public function __invoke( UpsertPostCategoryCommand $command ): int
    {
        /** @var PostCategory $postCategory */
        $postCategory = PostCategory::updateOrCreate(
            [PostCategory::COLUMN_NAME => $command->getName()],
            $command->toAssocArray()
        );

        return $postCategory->getAttribute( PostCategory::COLUMN_ID );
    }
}
