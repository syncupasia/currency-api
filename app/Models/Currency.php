<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    protected $table = "currency";

    // Define an accessor for the current_rate attribute
    public function getCurrentRateAttribute($value)
    {
        return (float)rtrim(rtrim($value, '0'), '.');
    }

    // Define an accessor for the previous_rate attribute
    public function getPreviousRateAttribute($value)
    {
        return (float)rtrim(rtrim($value, '0'), '.');
    }
}
