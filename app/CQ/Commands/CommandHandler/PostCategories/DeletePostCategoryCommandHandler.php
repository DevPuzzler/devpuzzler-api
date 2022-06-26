<?php

namespace App\CQ\Commands\CommandHandler\PostCategories;

use App\CQ\Commands\Command\PostCategories\DeletePostCategoryCommand;
use App\Exceptions\PostCategoryException;
use App\Models\PostCategories;

class DeletePostCategoryCommandHandler
{
    /**
     * @throws PostCategoryException
     */
    public function __invoke(DeletePostCategoryCommand $command): void
    {
        if ( null !== ( $postCategory = PostCategories::find(
            $command->getRequest()->validated( PostCategories::COLUMN_ID )))
        ) {
            $postCategory->delete();
        } else {
            throw new PostCategoryException('Post category not found or not active.');
        }
    }
}
