<?php

namespace App\CQ\Commands\Command\BlogPost;

use App\Models\BlogPost;

class UpsertBlogPostCommand
{
    public function __construct(
        private readonly string $title,
        private readonly string $excerpt,
        private readonly string $categoryId,
        private readonly string $content,
        private readonly bool $isActive,
        private readonly bool $isRestricted,
    ) {}

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getExcerpt(): string
    {
        return $this->excerpt;
    }

    public function getCategoryId(): string
    {
        return $this->categoryId;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getIsActive(): bool
    {
        return $this->isActive;
    }

    public function getIsRestricted(): bool
    {
        return $this->isRestricted;
    }

    public function toAssocArray(): array
    {
        return [
            BlogPost::COLUMN_TITLE => $this->getTitle(),
            BlogPost::COLUMN_EXCERPT => $this->getExcerpt(),
            BlogPost::COLUMN_CATEGORY_ID => $this->getCategoryId(),
            BlogPost::COLUMN_CONTENT => $this->getContent(),
            BlogPost::COLUMN_IS_ACTIVE => $this->getIsActive(),
            BlogPost::COLUMN_IS_RESTRICTED => $this->getIsRestricted(),
        ];
    }
}
