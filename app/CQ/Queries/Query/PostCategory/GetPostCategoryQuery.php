<?php

namespace App\CQ\Queries\Query\PostCategory;

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
