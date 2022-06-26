<?php

namespace App\CQ\Queries\QueryHandler\PostCategories;

use App\CQ\Queries\Query\PostCategories\GetPostCategoriesCollectionQuery;
use App\Models\PostCategories;

class GetPostCategoriesCollectionQueryHandler
{
    public function __invoke(GetPostCategoriesCollectionQuery $query) {
        return PostCategories::all();
    }
}
