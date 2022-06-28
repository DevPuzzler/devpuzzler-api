<?php

namespace App\CQ\Queries\Query\PostCategories;

class GetPostCategoryQuery
{
    public function __construct(
        private readonly int $id
    ) {}

    public function getId(): int
    {
        return $this->id;
    }
}
