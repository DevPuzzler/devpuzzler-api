<?php

namespace App\Providers;

use App\CQ\Queries\Query\PostCategories\{
    GetPostCategoryQuery,
    GetPostCategoriesCollectionQuery,
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
            GetPostCategoriesCollectionQuery::class => GetPostCategoriesCollectionQueryHandler::class,
            GetPostCategoryQuery::class => GetPostCategoryQueryHandler::class,
        ]);
    }
}
