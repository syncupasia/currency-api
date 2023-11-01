<?php

namespace App\Http\Requests;

use App\Rules\CurrencyCode;
use App\Http\Requests\ApiBaseRequest;

class SearchCurrencyRequest extends ApiBaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'iso_codes' => ['sometimes', 'array'],
            'iso_codes.*' => ['size:3', 'alpha', new CurrencyCode], // Validate each iso_code within the array
        ];
    }

}
