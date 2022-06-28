<?php

namespace App\CQ\Queries\QueryHandler\PostCategories;

use App\Enums\CollectionRulesEnum;
use App\Interfaces\CQ\Queries\Query\PostCategory\PostCategoryCollectionInterface;
use App\Models\PostCategory;
use Illuminate\Database\Eloquent\Collection;

class GetPostCategoriesCollectionQueryHandler
{
    public function __invoke( PostCategoryCollectionInterface $query ): Collection
    {

        if ( $query->getIsIncludePosts() ) {
            $postCategories = PostCategory::with('blogPosts');
        } else {
            $postCategories = PostCategory::where([]);
        }

        if ( null !== ( $orderBy = $query->getOrderBy() ) ) {
            $postCategories->orderBy(
                $orderBy,
                CollectionRulesEnum::DESC->value === $query->getSortOrder() ?
                    $query->getSortOrder() :
                    CollectionRulesEnum::ASC->value
            );
        }

        if ( null !== ( $limit = $query->getLimit() ) ) {
            $postCategories->limit($limit);
        }

        return $postCategories->get();
    }
}
