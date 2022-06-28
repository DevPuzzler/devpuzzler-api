<?php

namespace App\CQ\Commands\CommandHandler\PostCategories;

use App\CQ\Commands\Command\PostCategories\DeletePostCategoryCommand;
use App\Exceptions\PostCategoryException;
use App\Models\PostCategory;

class DeletePostCategoryCommandHandler
{
    /**
     * @throws PostCategoryException
     */
    public function __invoke(DeletePostCategoryCommand $command): void
    {
        if ( null !== ( $postCategory = PostCategory::find(
            $command->getRequest()->validated( PostCategory::COLUMN_ID )))
        ) {
            $postCategory->delete();
        } else {
            throw new PostCategoryException('Post category not found or not active.');
        }
    }
}
