<?php

namespace App\Http\Requests;

use App\Enums\CollectionParamsEnum as CollectionRules;
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
             ],
            CollectionRules::OFFSET->value => ['int', 'min:0']
        ];
    }

    public function rules(): array
    {
        return [
            ...$this->getCollectionRules()
        ];
    }
}
