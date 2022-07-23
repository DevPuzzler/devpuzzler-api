<?php

namespace App\CQ\Queries\Query\BlogPost;

use App\CQ\Queries\Query\AbstractCollectionQuery;
use App\Interfaces\CQ\Queries\Query\BlogPost\BlogPostCollectionInterface;

class GetBlogPostCollectionQuery extends AbstractCollectionQuery implements BlogPostCollectionInterface
{
    public function __construct(
        ?int $limit = null,
        ?int $offset = null,
        ?string $orderBy = null,
        ?string $sortOrder = null,
        private readonly bool $isIncludeCategory = false
    ) {
        parent::__construct( $limit, $offset, $orderBy, $sortOrder );
    }

    public function getIsIncludeCategory(): bool
    {
        return $this->isIncludeCategory;
    }
}
