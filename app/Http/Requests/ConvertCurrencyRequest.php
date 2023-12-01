<?php

namespace App\Http\Requests;

use App\Rules\CurrencyCode;

class ConvertCurrencyRequest extends ApiBaseRequest
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
            'base_currency' => ['required', 'size:3', 'alpha', new CurrencyCode],
            'target_currency' => ['required', 'size:3', 'alpha', new CurrencyCode],
            'amount' => 'sometimes|numeric|gt:0'
        ];
    }

    /**
     * Validated data - setup data format and default value
     */
    public function validated()
    {
        $data = parent::validated();
        // apply upper case on base_currency and target_currency since iso_code values in db are uppercase
        if (!empty($data['base_currency'])) $data['base_currency'] = strtoupper($data['base_currency']);
        if (!empty($data['target_currency'])) $data['target_currency'] = strtoupper($data['target_currency']);
        $data['amount'] = $data['amount'] ?? 1; // default to 1
        return $data;
    }
}
