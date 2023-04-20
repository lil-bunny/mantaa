<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Area;
use Illuminate\Support\Facades\Http;

class AddPOI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:poi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will add poi informations to the area onboarded';

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
        // Fetching the area data for adding the poi informations
        $area_list = Area::where('areas.is_deleted', '=', 0)->whereNull('areas.gridTrends')->get();
        

        // iterating the list data and calling the coordinate API
        $area_nof = [];
        foreach($area_list as $area_info) {
            $error = '';
            try {
                $this->info("Adding POI process started for ".$area_info->id);

                // calling the alternate data API with respect to lat and lang and api key
                $api_url = env('FETCH_POI_URL');
                $api_key = env('FETCH_POI_KEY');
                
                // setting the header
                $headers = [
                    'apikey' => $api_key
                ];

                // setting the post input
                $post_input = [
                    'lat' => $area_info->lat,
                    'lng' => $area_info->lng,
                ];
                
                // fetching the response
                $response = Http::withHeaders($headers)->post($api_url, $post_input);
                $statusCode = $response->status();
                $responseBody = json_decode($response->getBody(), true);
            
                
                $poi_data = [];
                if($statusCode == '201') {
                    $gridTrends = $responseBody['gridTrends'];

                    foreach($gridTrends as $key => $value) {
                        $poi_data[$key] = $value;
                    }
                } else {
                    $error = $responseBody['error'];
                    $area_nof[] = $area_info->id;
                    $this->info("Error occured during POI addition for the area ".$area_info->id);
                }

                // assigning data to object
                $area_info->gridTrends = $poi_data;
                $area_info->error_response = $error != ''?$error:'';
                $area_info->save();
                $this->info("POI addition completed for the area ".$area_info->id);
            } catch(\Exception $e) {
                $area_nof[] = $area_info->id;
                $area_info->error_response = $e->getMessage();
                $area_info->save();
            }
        }

        if(count($area_nof) > 0) {
            $this->info("Failed area ids ".implode(',', $area_nof));
        }
        
        $this->info("Operation completed successfully");
        return TRUE;
    }
}
