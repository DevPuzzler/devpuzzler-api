<?php

namespace App\CQ\Commands\Command\PostCategory;

use App\Models\PostCategory;

class UpsertPostCategoryCommand
{
    public function __construct(
        private readonly string $name,
        private readonly string $description
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function toAssocArray(): array
    {
        return [
            PostCategory::COLUMN_NAME => $this->getName(),
            PostCategory::COLUMN_DESCRIPTION => $this->getDescription(),
        ];
    }
}
