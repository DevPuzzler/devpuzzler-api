<?php

namespace App\Providers;

use App\CQ\Queries\Query\BlogPost\GetBlogPostCollectionQuery;
use App\CQ\Queries\Query\BlogPost\GetBlogPostQuery;
use App\CQ\Queries\QueryHandler\BlogPost\GetBlogPostCollectionQueryHandler;
use App\CQ\Queries\QueryHandler\BlogPost\GetBlogPostQueryHandler;
use App\CQ\Queries\Query\PostCategory\{
    GetPostCategoryQuery,
    GetPostCategoryCollectionQuery,
};
use App\CQ\Queries\QueryHandler\PostCategories\{
    GetPostCategoryQueryHandler,
    GetPostCategoriesCollectionQueryHandler
};
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;

class BusQueryServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Bus::map([
            /* POST CATEGORIES */
            GetPostCategoryCollectionQuery::class => GetPostCategoriesCollectionQueryHandler::class,
            GetPostCategoryQuery::class => GetPostCategoryQueryHandler::class,

            /* BLOG POSTS */
            GetBlogPostQuery::class => GetBlogPostQueryHandler::class,
            GetBlogPostCollectionQuery::class => GetBlogPostCollectionQueryHandler::class,
        ]);
    }
}
