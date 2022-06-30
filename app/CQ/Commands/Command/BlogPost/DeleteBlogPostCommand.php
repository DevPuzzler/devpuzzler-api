<?php

namespace App\CQ\Commands\Command\BlogPost;

class DeleteBlogPostCommand
{
    public function __construct(
        private readonly int $id
    ) {}

    public function getId(): int
    {
        return $this->id;
    }
}
