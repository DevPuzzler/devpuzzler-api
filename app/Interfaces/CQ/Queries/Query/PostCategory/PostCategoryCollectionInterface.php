<?php

namespace App\Interfaces\CQ\Queries\Query\PostCategory;

use App\Interfaces\CQ\Queries\Query\CollectionQueryInterface;

interface PostCategoryCollectionInterface extends CollectionQueryInterface
{
    public const PARAM_INCLUDE_POSTS = 'include_posts';

    public function getIsIncludePosts(): ?bool;
}
