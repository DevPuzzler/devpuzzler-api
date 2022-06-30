<?php

namespace App\Providers;

use App\CQ\Commands\Command\BlogPost\UpsertBlogPostCommand;
use App\CQ\Commands\Command\BlogPost\UpdateBlogPostCommand;
use App\CQ\Commands\Command\PostCategory\DeletePostCategoryCommand;
use App\CQ\Commands\CommandHandler\BlogPost\UpsertBlogPostCommandHandler;
use App\CQ\Commands\CommandHandler\BlogPost\UpdateBlogPostCommandHandler;
use App\CQ\Commands\CommandHandler\PostCategory\CreatePostCategoryCommandHandler;
use App\CQ\Commands\Command\PostCategory\CreatePostCategoryCommand;
use App\CQ\Commands\CommandHandler\PostCategory\DeletePostCategoryCommandHandler;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;

class BusCommandServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Bus::map([
            /* POST CATEGORY */
            CreatePostCategoryCommand::class => CreatePostCategoryCommandHandler::class,
            DeletePostCategoryCommand::class => DeletePostCategoryCommandHandler::class,

            /* BLOG POST */
            UpsertBlogPostCommand::class => UpsertBlogPostCommandHandler::class,
            UpdateBlogPostCommand::class => UpdateBlogPostCommandHandler::class,
        ]);
    }
}
