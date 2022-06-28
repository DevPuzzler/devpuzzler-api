<?php

namespace App\Interfaces\CQ\Queries\Query\BlogPost;

use App\Interfaces\CQ\Queries\Query\CollectionQueryInterface;

interface BlogPostCollectionInterface extends CollectionQueryInterface
{
    public const PARAM_INCLUDE_CATEGORY = 'include_category';

    public function getIsIncludeCategory(): ?bool;
}
