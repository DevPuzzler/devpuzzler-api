<?php

namespace App\Interfaces\CQ\Queries\Query;

interface CollectionQueryInterface {

    public function getLimit(): ?int;

    public function getOrderBy(): ?string;

    public function getSortOrder(): ?string;

}
