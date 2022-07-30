<?php

namespace App\CQ\Queries\QueryHandler\PostCategory;

use App\Enums\CollectionParamsEnum;
use App\Interfaces\CQ\Queries\Query\PostCategory\PostCategoryCollectionQueryInterface;
use App\Models\BlogPost;
use App\Models\PostCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GetPostCategoryCollectionQueryHandler
{
    public function __invoke( PostCategoryCollectionQueryInterface $query ): Collection
    {
        $queryBuilder = PostCategory::where([]);

        if ( null !== ( $orderBy = $query->getOrderBy() ) ) {
            $queryBuilder->orderBy(
                $orderBy,
                CollectionParamsEnum::DESC->value === $query->getSortOrder() ?
                    $query->getSortOrder() :
                    CollectionParamsEnum::ASC->value
            );
        }

        if ( null !== ( $limit = $query->getLimit() ) ) {
            $queryBuilder
                ->limit($limit)
                ->offset($query->getOffset());
        }

        $postCategories = $queryBuilder->get();

        if ( $query->getIsIncludePosts() ) {
            $postCategories->each( function (&$postCategory) use ($query) {
                $postCategory->load(
                    [
                        PostCategory::COLUMN_BLOG_POSTS => function ($relationQueryBuilder) use ($query) {
                            $relationQueryBuilder->limit( $query->getLimitPosts() );
                        }
                    ]
                )->get();
            });
        }

        return $postCategories;
    }
}
