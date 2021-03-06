<?php

namespace App\Interfaces\CQ\Queries\Query\PostCategory;

use App\Interfaces\CQ\Queries\Query\CollectionQueryInterface;

interface PostCategoryCollectionQueryInterface extends CollectionQueryInterface
{
    public const PARAM_INCLUDE_POSTS = 'include_posts';
    public const PARAM_LIMIT_POSTS = 'limit_posts';

    public function getIsIncludePosts(): ?bool;

    public function getLimitPosts(): ?int;
}
