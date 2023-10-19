<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // couple of ways to add data

        // 1. looping through currencies array and insert one at a time
        // it is best to do this way to avoid incompatibility due to different database sql syntax
        // $currencies = [
        //     [
        //         'iso_code' => 'USD',
        //         'name' => 'United States Dollar',
        //         'current_rate' => 1.0, 
        //         'previous_rate' => 1.0,
        //         'base_currency' => 'USD',
        //     ],
        //     // Add more currencies as needed
        // ];
        // foreach ($currencies as $currency) {
        //     DB::table('currency')->insert($currency);
        // }

        // 2. using existing sql file instead
        $sql = file_get_contents(database_path('seeders/currency.sql'));
        DB::unprepared($sql);
    }
}
