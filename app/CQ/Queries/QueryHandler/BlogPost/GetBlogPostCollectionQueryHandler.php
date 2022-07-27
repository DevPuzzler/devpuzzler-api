<?php

namespace App\CQ\Queries\QueryHandler\BlogPost;

use App\Enums\CollectionParamsEnum;
use App\Interfaces\CQ\Queries\Query\BlogPost\BlogPostCollectionQueryInterface;
use App\Models\BlogPost;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class GetBlogPostCollectionQueryHandler
{
    public function __invoke( BlogPostCollectionQueryInterface $query ): Collection
    {
        if ( $query->getIsIncludeCategory() ) {
            $blogPosts = BlogPost::with('category');
        } else {
            $blogPosts = BlogPost::where([]);
        }

        $this->addCategoryIdToQuery($blogPosts, $query);

        if ( null !== ( $orderBy = $query->getOrderBy() ) ) {
            $blogPosts->orderBy(
                $orderBy,
                CollectionParamsEnum::DESC->value === $query->getSortOrder() ?
                    $query->getSortOrder() :
                    CollectionParamsEnum::ASC->value
            );
        }

        if ( null !== ( $limit = $query->getLimit() ) ) {
            $blogPosts->limit($limit);
        }

        if ( null !== ($offset = $query->getOffset()) ) {
            $blogPosts->offset($offset);
        }

        return $blogPosts->get();
    }

    public function addCategoryIdToQuery( Builder &$queryBuilder, BlogPostCollectionQueryInterface $query ): void
    {
        if ( $query->getCategoryId() ) {
            $queryBuilder->where(BlogPost::COLUMN_CATEGORY_ID, '=', $query->getCategoryId());
        }
    }
}
