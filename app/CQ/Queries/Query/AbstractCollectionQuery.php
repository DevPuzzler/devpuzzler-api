<?php

namespace App\CQ\Queries\Query;

use App\Interfaces\CQ\Queries\Query\CollectionQueryInterface;

abstract class AbstractCollectionQuery implements CollectionQueryInterface
{
    public function __construct(
        private readonly ?int $limit = null,
        private readonly ?string $orderBy = null,
        private readonly ?string $sortOrder = null,
    ) {}

    public function getLimit(): ?int
    {
        return $this->limit;
    }

    public function getOrderBy(): ?string
    {
        return $this->orderBy;
    }

    public function getSortOrder(): ?string
    {
        return $this->sortOrder;
    }
}
