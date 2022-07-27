<?php

namespace App\CQ\Queries\Query\PostCategory;

use App\CQ\Queries\Query\AbstractCollectionQuery;
use App\Interfaces\CQ\Queries\Query\PostCategory\PostCategoryCollectionQueryInterface;

class GetPostCategoryCollectionQueryQuery extends AbstractCollectionQuery implements PostCategoryCollectionQueryInterface
{
    public function __construct(
        ?int $limit = null,
        ?int $offset = null,
        ?string $orderBy = null,
        ?string $sortOrder = null,
        private readonly bool $isIncludePosts = false
    )
    {
        parent::__construct($limit, $offset, $orderBy, $sortOrder);
    }

    public function getIsIncludePosts(): bool
    {
        return $this->isIncludePosts;
    }
}
