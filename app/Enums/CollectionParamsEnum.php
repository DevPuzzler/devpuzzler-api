<?php

namespace App\Enums;

enum CollectionParamsEnum: string
{
    case ASC = 'asc';
    case DESC = 'desc';

    case LIMIT = 'limit';
    case OFFSET = 'offset';
    case ORDER_BY = 'order_by';
    case SORT_ORDER = 'sort_order';

    public static function getSortOrderArray(): array
    {
        return [
            self::ASC->value,
            self::DESC->value
        ];
    }

}
