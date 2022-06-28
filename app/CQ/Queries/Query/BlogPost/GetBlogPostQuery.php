<?php

namespace App\CQ\Queries\Query\BlogPost;

class GetBlogPostQuery
{
    public function __construct(
        private readonly int $id
    ) {}

    public function getId(): int
    {
        return $this->id;
    }
}
