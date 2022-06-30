<?php

namespace App\CQ\Commands\Command\PostCategory;

class DeletePostCategoryCommand
{
    public function __construct(
        private readonly int $id
    ) {}

    public function getId(): int
    {
        return $this->id;
    }
}
