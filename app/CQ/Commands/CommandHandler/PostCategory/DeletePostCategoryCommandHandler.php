<?php

namespace App\CQ\Commands\CommandHandler\PostCategory;

use App\CQ\Commands\Command\PostCategory\DeletePostCategoryCommand;
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
            throw new PostCategoryException('Post category not found or not active.', 422);
        }
    }
}
