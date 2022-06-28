<?php

namespace App\CQ\Queries\QueryHandler\BlogPost;

use App\CQ\Queries\Query\BlogPost\GetBlogPostCollectionQuery;
use App\Models\BlogPost;

class GetBlogPostCollectionQueryHandler
{
    public function __invoke(GetBlogPostCollectionQuery $query)
    {
        return BlogPost::with('category')->get();
    }
}
