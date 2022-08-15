<?php

namespace App\CQ\Queries\QueryHandler\BlogPost;

use App\CQ\Queries\Query\BlogPost\GetBlogPostQuery;
use App\Models\BlogPost;

class GetBlogPostQueryHandler
{
    public function __invoke(GetBlogPostQuery $query): BlogPost
    {
        return BlogPost::with(BlogPost::RELATION_TAGS)->findOrFail( $query->getId() );
    }
}
