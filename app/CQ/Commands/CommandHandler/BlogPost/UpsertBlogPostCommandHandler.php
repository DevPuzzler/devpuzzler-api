<?php

namespace App\CQ\Commands\CommandHandler\BlogPost;

use App\CQ\Commands\Command\BlogPost\UpsertBlogPostCommand;
use App\Models\BlogPost;

class UpsertBlogPostCommandHandler
{
    public function __invoke(UpsertBlogPostCommand $command ): int
    {
        $blogPost = BlogPost::updateOrCreate(
            [BlogPost::COLUMN_TITLE => $command->getTitle()],
            $command->toAssocArray()
        );

        return $blogPost->getAttribute( BlogPost::COLUMN_ID );
    }
}
