<?php

namespace App\CQ\Queries\Query\BlogPost;

use App\CQ\Queries\Query\AbstractCollectionQuery;
use App\Interfaces\CQ\Queries\Query\BlogPost\BlogPostCollectionQueryInterface;

class GetBlogPostCollectionQueryQuery extends AbstractCollectionQuery implements BlogPostCollectionQueryInterface
{
    public function __construct(
        ?int $limit = null,
        ?int $offset = null,
        ?string $orderBy = null,
        ?string $sortOrder = null,
        private readonly bool $isIncludeCategory = false,
        private readonly ?int $categoryId = null,
    ) {
        parent::__construct( $limit, $offset, $orderBy, $sortOrder );
    }

    public function getIsIncludeCategory(): bool
    {
        return $this->isIncludeCategory;
    }

    public function getCategoryId(): ?int
    {
        return $this->categoryId;
    }
}
