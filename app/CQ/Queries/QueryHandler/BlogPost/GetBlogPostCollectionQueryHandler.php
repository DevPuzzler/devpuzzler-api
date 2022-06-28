<?php

namespace App\CQ\Queries\QueryHandler\BlogPost;

use App\Enums\CollectionRulesEnum;
use App\Interfaces\CQ\Queries\Query\BlogPost\BlogPostCollectionInterface;
use App\Models\BlogPost;
use Illuminate\Database\Eloquent\Collection;

class GetBlogPostCollectionQueryHandler
{
    public function __invoke( BlogPostCollectionInterface $query ): Collection
    {
        if ( $query->getIsIncludeCategory() ) {
            $blogPosts = BlogPost::with('category');
        } else {
            $blogPosts = BlogPost::where([]);
        }

        if ( null !== ( $orderBy = $query->getOrderBy() ) ) {
            $blogPosts->orderBy(
                $orderBy,
                CollectionRulesEnum::DESC->value === $query->getSortOrder() ?
                    $query->getSortOrder() :
                    CollectionRulesEnum::ASC->value
            );
        }

        if ( null !== ( $limit = $query->getLimit() ) ) {
            $blogPosts->limit($limit);
        }

        return $blogPosts->get();
    }
}
