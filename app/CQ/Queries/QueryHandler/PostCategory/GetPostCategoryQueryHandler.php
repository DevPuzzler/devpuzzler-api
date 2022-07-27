<?php

namespace App\CQ\Queries\QueryHandler\PostCategory;

use App\CQ\Queries\Query\PostCategory\GetPostCategoryQuery;
use App\Models\PostCategory;

class GetPostCategoryQueryHandler
{
    public function __invoke(GetPostCategoryQuery $query) {
        return PostCategory::findOrFail($query->getId());
    }
}
