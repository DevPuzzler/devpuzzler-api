<?php

namespace App\CQ\Queries\QueryHandler\BlogPost;

use App\Enums\CollectionParamsEnum;
use App\Interfaces\CQ\Queries\Query\BlogPost\BlogPostCollectionQueryInterface;
use App\Models\BlogPost;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class GetBlogPostCollectionQueryHandler
{
    public function __invoke( BlogPostCollectionQueryInterface $query ): Collection
    {
        if ( $query->getIsIncludeCategory() ) {
            $blogPosts = BlogPost::with(BlogPost::RELATION_CATEGORY);
        } else {
            $blogPosts = BlogPost::where([]);
        }

        $this->addCategoryIdToQuery($blogPosts, $query);

        if ( ( $orderBy = $query->getOrderBy() ) ) {
            $blogPosts->orderBy(
                $orderBy,
                CollectionParamsEnum::DESC->value === $query->getSortOrder() ?
                    $query->getSortOrder() :
                    CollectionParamsEnum::ASC->value
            );
        }

        if ( ( $limit = $query->getLimit() ) ) {
            $blogPosts->limit($limit);

            if ( ($offset = $query->getOffset()) ) {
                $blogPosts->offset($offset);
            }
        }

        $blogPosts->with(BlogPost::RELATION_TAGS);

        if( ($tags = $query->getTags()) ) {
            $blogPosts->whereRelation(BlogPost::RELATION_TAGS, function(Builder $q) use ($tags) {
                $q->whereIn(Tag::COLUMN_NAME, $tags);
            });
        }

        return $blogPosts->get();
    }

    public function addCategoryIdToQuery( Builder &$queryBuilder, BlogPostCollectionQueryInterface $query ): void
    {
        if ( ( $categoryId = $query->getCategoryId() ) ) {
            $queryBuilder->where(
                BlogPost::COLUMN_CATEGORY_ID,
                '=',
                $categoryId
            );
        }
    }
}
