<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApiBaseRequest extends FormRequest
{
    // overriding failed validation behaviour to return json format and 422 status code
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'The given data is invalid.',
            'error' => $validator->errors() // can think about returning error code
        ], 422));
    }

    // overriding to include route parameters
    public function all($keys = null)
    {
        if (is_null($this->route())) {
            return parent::all();
        } else {
            return array_merge(parent::all(), $this->route()->parameters());
        }
    }
}
