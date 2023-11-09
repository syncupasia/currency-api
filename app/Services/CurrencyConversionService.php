<?php

namespace App\Services;

use App\Models\Currency;

class CurrencyConversionService
{
    /**
     * Calculate currency conversion
     * 
     * @param array $params (base_currency, target_currency, amount)
     * @return float|bool $convertedAmount
     */
    public function calculate(array $params) {
        if (!isset($params['amount'])) {
            // shouldn't have this case if we validated the request
            return false;
        }

        if ($params['base_currency'] === $params['target_currency']) {
            // Conversion to the same currency, no change needed
            return floatval($params['amount']);
        }

        $currencies = Currency::all()->keyBy('iso_code');
        if (!isset($currencies[$params['base_currency']]) || !isset($currencies[$params['target_currency']])) {
            // Handle invalid currency ISO codes - shouldn't have this case if we validated the request
            return false;
        }

        $convertedAmount = ($currencies[$params['target_currency']]->getAttributeValue('current_rate') / 
                                $currencies[$params['base_currency']]->getAttributeValue('current_rate')) * $params['amount'];

        return $convertedAmount;
    }
}