<?php

namespace App\Http\Requests;

class OrderRequest extends MainRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'phone' => 'required|string|min:10',
        ];
    }
}
