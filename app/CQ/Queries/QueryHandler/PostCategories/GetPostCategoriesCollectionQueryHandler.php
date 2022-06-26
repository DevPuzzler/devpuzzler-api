<?php

namespace App\CQ\Queries\QueryHandler\PostCategories;

use App\CQ\Queries\Query\PostCategories\GetPostCategoriesCollectionQuery;
use App\Models\PostCategories;
use Illuminate\Database\Eloquent\Collection;

class GetPostCategoriesCollectionQueryHandler
{
    public function __invoke(GetPostCategoriesCollectionQuery $query): Collection
    {
        return PostCategories::all();
    }
}
