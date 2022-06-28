<?php

namespace App\Http\Requests;

use App\Enums\CollectionRulesEnum as CollectionRules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GenericCollectionRequest extends FormRequest
{
    public function getCollectionRules(): array
    {
        return [
             CollectionRules::LIMIT->value => [
                 'int',
                 'min:1'
             ],
             CollectionRules::ORDER_BY->value => [
                 'string',
                 Rule::in( ['created_at', 'updated_at'] )
             ],
             CollectionRules::SORT_ORDER->value => [
                 Rule::in( CollectionRules::getSortOrderArray() )
             ]
        ];
    }

    public function rules(): array
    {
        return [
            ...$this->getCollectionRules()
        ];
    }
}
