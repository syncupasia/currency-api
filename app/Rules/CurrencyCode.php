<?php

namespace App\Rules;

use App\Models\Currency;
use Illuminate\Contracts\Validation\Rule;

class CurrencyCode implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // only allow lowercase as it's best for url format
        if (strtolower($value) === $value) {
            // if it's real production env then should think about checking static list or cache instead of db since iso_code doesn't change
            return Currency::where('iso_code', strtoupper($value))->exists();
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid currency code.';
    }
}
