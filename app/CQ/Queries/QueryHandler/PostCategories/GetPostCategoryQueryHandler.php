<?php

namespace App\CQ\Queries\QueryHandler\PostCategories;

use App\CQ\Queries\Query\PostCategories\GetPostCategoryQuery;
use App\Models\PostCategories;

class GetPostCategoryQueryHandler
{
    public function __invoke(GetPostCategoryQuery $query) {
        return PostCategories::findOrFail($query->getPostCategoryId());
    }
}
