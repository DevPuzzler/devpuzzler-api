<?php

namespace App\Providers;

use App\CQ\Queries\Query\BlogPost\GetBlogPostCollectionQueryQuery;
use App\CQ\Queries\Query\BlogPost\GetBlogPostQuery;
use App\CQ\Queries\QueryHandler\BlogPost\GetBlogPostCollectionQueryHandler;
use App\CQ\Queries\QueryHandler\BlogPost\GetBlogPostQueryHandler;
use App\CQ\Queries\Query\PostCategory\{
    GetPostCategoryQuery,
    GetPostCategoryCollectionQueryQuery,
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
            GetPostCategoryCollectionQueryQuery::class => GetPostCategoriesCollectionQueryHandler::class,
            GetPostCategoryQuery::class => GetPostCategoryQueryHandler::class,

            /* BLOG POSTS */
            GetBlogPostQuery::class => GetBlogPostQueryHandler::class,
            GetBlogPostCollectionQueryQuery::class => GetBlogPostCollectionQueryHandler::class,
        ]);
    }
}
