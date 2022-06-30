<?php

namespace App\CQ\Commands\CommandHandler\BlogPost;

use App\CQ\Commands\Command\BlogPost\DeleteBlogPostCommand;
use App\Exceptions\BlogPostException;
use App\Models\BlogPost;
use Symfony\Component\HttpFoundation\Response;

class DeleteBlogPostCommandHandler
{
    public function __invoke( DeleteBlogPostCommand $command ): void
    {
        /** @var BlogPost $blogPost */
        if ( null !== $blogPost = BlogPost::find($command->getId()) ) {
            $blogPost->delete();
        }

        throw new BlogPostException(
            'Blog post already deleted.',
            Response::HTTP_UNPROCESSABLE_ENTITY
        );


    }
}
