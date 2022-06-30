<?php

namespace App\Providers;

use App\CQ\Commands\Command\BlogPost\DeleteBlogPostCommand;
use App\CQ\Commands\Command\BlogPost\UpsertBlogPostCommand;
use App\CQ\Commands\Command\PostCategory\DeletePostCategoryCommand;
use App\CQ\Commands\CommandHandler\BlogPost\DeleteBlogPostCommandHandler;
use App\CQ\Commands\CommandHandler\BlogPost\UpsertBlogPostCommandHandler;
use App\CQ\Commands\CommandHandler\PostCategory\UpsertPostCategoryCommandHandler;
use App\CQ\Commands\Command\PostCategory\UpsertPostCategoryCommand;
use App\CQ\Commands\CommandHandler\PostCategory\DeletePostCategoryCommandHandler;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;

class BusCommandServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Bus::map([
            /* POST CATEGORY */
            UpsertPostCategoryCommand::class => UpsertPostCategoryCommandHandler::class,
            DeletePostCategoryCommand::class => DeletePostCategoryCommandHandler::class,

            /* BLOG POST */
            UpsertBlogPostCommand::class => UpsertBlogPostCommandHandler::class,
            DeleteBlogPostCommand::class => DeleteBlogPostCommandHandler::class,
        ]);
    }
}
