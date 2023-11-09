<?php

namespace App\Console\Commands;

use App\Models\Currency;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GetCurrenciesData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:currencies-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Currencies Rate';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $url = 'https://open.er-api.com/v6/latest/USD'; // can move this to .env in real case
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        curl_close($ch);
        if (!$res){
            $this->error('Failed to fetch JSON data.');
        } else {
            $data = json_decode($res, true);
            $updatedSuccessfully = false;
            if (!empty($data['result']) && $data['result'] === 'success'  && is_array($data['rates'])) {
                foreach ($data['rates'] as $isoCode => $newRate) {
                    $rateUpdateResult = Currency::where(['iso_code' => $isoCode])
                        ->update([
                            'previous_rate' => DB::raw('current_rate'),
                            'current_rate' => $newRate,
                            'updated_at' => now()
                        ]);
                    if (!$updatedSuccessfully && $rateUpdateResult) {
                        $updatedSuccessfully = true;
                        // it's demo so we check once and don't care any inactive or new currency 
                    }
                }
            }
            if ($updatedSuccessfully) { 
                $this->info('JSON data fetched successfully.');
            } else {
                // Laravel provides a logging system and in real production we may want to check it and/or send alert.
                $this->error('Failed to fetch JSON data.');
            }
        }
    }
}
