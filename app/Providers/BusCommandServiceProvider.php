<?php

namespace App\Providers;

use App\CQ\Commands\Command\PostCategories\DeletePostCategoryCommand;
use App\CQ\Commands\CommandHandler\PostCategories\CreatePostCategoryCommandHandler;
use App\CQ\Commands\Command\PostCategories\CreatePostCategoryCommand;
use App\CQ\Commands\CommandHandler\PostCategories\DeletePostCategoryCommandHandler;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;

class BusCommandServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Bus::map([
            CreatePostCategoryCommand::class => CreatePostCategoryCommandHandler::class,
            DeletePostCategoryCommand::class => DeletePostCategoryCommandHandler::class,
        ]);
    }
}
