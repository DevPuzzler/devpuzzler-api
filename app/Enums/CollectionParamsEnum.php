<?php

namespace App\Enums;

enum CollectionParamsEnum: string
{
    case ASC = 'asc';
    case DESC = 'desc';

    case LIMIT = 'limit';
    case OFFSET = 'offset';
    case ORDER_BY = 'orderBy';
    case SORT_ORDER = 'sortOrder';

    public static function getSortOrderArray(): array
    {
        return [
            self::ASC->value,
            self::DESC->value
        ];
    }

}
