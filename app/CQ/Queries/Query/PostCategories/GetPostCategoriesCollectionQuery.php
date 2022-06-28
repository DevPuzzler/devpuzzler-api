<?php

namespace App\CQ\Queries\Query\PostCategories;

use App\CQ\Queries\Query\AbstractCollectionQuery;
use App\Interfaces\CQ\Queries\Query\PostCategory\PostCategoryCollectionInterface;

class GetPostCategoriesCollectionQuery extends AbstractCollectionQuery implements PostCategoryCollectionInterface
{
    public function __construct(
        ?int $limit = null,
        ?string $orderBy = null,
        ?string $sortOrder = null,
        private readonly bool $isIncludePosts = false
    )
    {
        parent::__construct($limit, $orderBy, $sortOrder);
    }

    public function getIsIncludePosts(): ?bool
    {
        return $this->isIncludePosts;
    }
}
