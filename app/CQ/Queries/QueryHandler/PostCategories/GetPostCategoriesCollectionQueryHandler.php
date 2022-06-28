<?php

namespace App\CQ\Queries\QueryHandler\PostCategories;

use App\Enums\CollectionRulesEnum;
use App\Interfaces\CQ\Queries\Query\PostCategory\PostCategoryCollectionInterface;
use App\Models\PostCategories;
use Illuminate\Database\Eloquent\Collection;

class GetPostCategoriesCollectionQueryHandler
{
    public function __invoke( PostCategoryCollectionInterface $query ): Collection
    {

        if ( $query->getIsIncludePosts() ) {
            $postCategories = PostCategories::with('blogPosts');
        } else {
            $postCategories = PostCategories::where([]);
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
