<?php

namespace App\CQ\Queries\QueryHandler\PostCategories;

use App\Enums\CollectionParamsEnum;
use App\Interfaces\CQ\Queries\Query\PostCategory\PostCategoryCollectionQueryInterface;
use App\Models\PostCategory;
use Illuminate\Database\Eloquent\Collection;

class GetPostCategoriesCollectionQueryHandler
{
    public function __invoke(PostCategoryCollectionQueryInterface $query ): Collection
    {

        if ( $query->getIsIncludePosts() ) {
            $postCategories = PostCategory::with('blogPosts');
        } else {
            $postCategories = PostCategory::where([]);
        }

        if ( null !== ( $orderBy = $query->getOrderBy() ) ) {
            $postCategories->orderBy(
                $orderBy,
                CollectionParamsEnum::DESC->value === $query->getSortOrder() ?
                    $query->getSortOrder() :
                    CollectionParamsEnum::ASC->value
            );
        }

        if ( null !== ( $limit = $query->getLimit() ) ) {
            $postCategories->limit($limit);
        }

        return $postCategories->get();
    }
}
