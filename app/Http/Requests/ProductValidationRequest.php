<?php

namespace App\Http\Requests;

use App\Rules\PriceValidation;

class ProductValidationRequest extends MainRequest
{
    public function rules()
    {
        return [
            'filter.categories.*' => 'nullable|numeric|exists:categories,id',
            'filter.min_price'    => [
                'nullable', 'numeric', 'min:0',
                new PriceValidation(
                    $this->input('min_price'),
                    $this->input('max_price'),
                ),
            ],
            'filter.max_price'    => [
                'nullable', 'numeric', 'max:1000000000',
                new PriceValidation(
                    $this->input('min_price'),
                    $this->input('max_price'),
                    false
                ),
            ],
            'filter.width'        => 'nullable|numeric|min:0',
            'filter.length'       => 'nullable|numeric|min:0',
            'filter.the_weight'   => 'nullable|numeric|min:0',
        ];
    }
}
