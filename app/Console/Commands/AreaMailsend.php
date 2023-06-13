<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Area;
use App\Models\SiteMerit;
use Illuminate\Support\Facades\Http;
use App\Models\Setting;
use Mail; 

class AreaMailsend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendsite:mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will send mail with full area list';

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
        
        
        // fetching the settings data and find whether sending dump is enabled or not
        $settings_data = Setting::latest()->first();
        if($settings_data->send_site_dump == 'no') {
            $this->info("Sending dump is not enabled");
            return true;
        } else {
            $this->info("Creation of csv for sending dump is started");
        }

        $filename = 'araedtl.csv';
        $area_list = Area::where('areas.is_deleted', '=', 0)->get();

        $columns = array('Location Name', 'Road Name', 'Area Name', 'Pincode', 'Latitude','Longitude','City','State', 'Location Type','Media Formats','Orientation','Media Tags','Width','Height','Illumination','Ad Spot (Duration in seconds)','Total Ad spot per day', 'Total Advertisers', 'Display Charges PM','Production Cost','Installation Cost', 'Media Partner Name','Site Position','Junction','Obstruction','Visibility','Clutter','Gym Count','Cafe Count','Mall Count','Park Count','Nearest City','Office Count','Others Count','School Count','Grocery Count','Lodging Count','Area Affluence','Bus Stop Count','Hospital Count','Pharmacy Count','Market Presence','Office Presence','Pet Store Count','Total POI Count','Warehouse Count','Pincode Category','Restaurant Count','Wholesaler Count','Bus Station Count','Cinema Hall Count','Event Venue Count','Liquor Shop Count','Other Store Count','Petrol Pump Count','Manufacturer Count','Sports Store Count','Travel Agent Count','Weekly Impressions','Doctor Clinic Count','Metro Station Count','Clothing Store Count','Footwear Store Count','Hardware Store Count','Market Concentration','Office Concentration','Police Station Count','Income Group Category','Jewellery Store Count','Nearest City Distance','Railway Station Count','Religious Place Count','Beauty And Salon Count','Monthly Average Income','Vegetable Market Count','Apartment Complex Count','Electronics Store Count','Nearest Cinema Distance','Nearest School Distance','Nearest Airport Distance','Nearest College Distance','Automotive Showroom Count','Nearest Bus Stop Distance','Nearest Religious Distance','Social Service Count (NGO)','Average Daily Footfall Count','College And University Count','Money Transfer Service Count','Mass Media Entertainment Count','Nearest Metro Station Distance','Nearest Shopping Mall Distance','Electronic Service Centre Count','Stationary And Xerox Shop Count','Nearest Railway Station Distance','Average Daily Traffic 12am-6am Count','Average Daily Traffic 12pm-6pm Count','Average Daily Traffic 6am-12pm Count','Average Daily Traffic 6pm-12am Count','Automotive Repair And Maintenance Count');
        $myfilePath = fopen(public_path('/'. $filename), "w");
        fputcsv($myfilePath, $columns);

        foreach($area_list as $area_info) {

            $area_data = Area::find($area_info['id']);
            $site_merits_values_assigned = [];
            $site_merits = SiteMerit::where('is_deleted', '=', 0)->where('status', '=', 1)->get();
            foreach($area_data->site_marit_values as $site_marit_value) {
                $site_merits_values_assigned[] = $site_marit_value->id;
            }

            $site_dtl= [];
            foreach($site_merits as $sitekey=>$site_merit){
                foreach($site_merit->site_merit_values as $site_merit_value){
                    if(in_array($site_merit_value->id, $site_merits_values_assigned)){

                        $site_dtl[$sitekey]['value']= $site_merit_value->id;
                        $site_dtl[$sitekey]['label']= $site_merit_value->title;
                    }else{

                        $site_dtl[$sitekey]['value']= "";
                        $site_dtl[$sitekey]['label']= "";
                    }
                }       
            }

            $poi_data = [];
            if(!empty($area_data->gridTrends)) {
                foreach($area_data->gridTrends as $key => $value) {
                    if($value != '0' && $value != '') {
                        $poi_data[$key]['value'] = $value;
                        $poi_data[$key]['label'] = ucwords(str_replace('_', ' ', $key));
                    }
                }
            }

            $gym_count="";
            $cafe_count="";
            $mall_count="";
            $park_count="";
            $nearest_city="";
            $office_count="";
            $others_count="";
            $school_count="";
            $grocery_count="";
            $lodging_count="";
            $area_affluence="";
            $bus_stop_count="";
            $hospital_count="";
            $pharmacy_count="";
            $market_presence="";
            $office_presence="";
            $pet_store_count="";
            $total_POI_count="";
            $warehouse_count="";
            $pincode_category="";
            $restaurant_count="";
            $wholesaler_count="";
            $bus_station_count="";
            $cinema_hall_count="";
            $event_venue_count="";
            $liquor_shop_count="";
            $other_store_count="";
            $petrol_pump_count="";
            $manufacturer_count="";
            $sports_store_count="";
            $travel_agent_count="";
            $weekly_impressions="";
            $doctor_clinic_count="";
            $metro_station_count="";
            $clothing_store_count="";
            $footwear_store_count="";
            $hardware_store_count="";
            $market_concentration="";
            $office_concentration="";
            $police_station_count="";
            $income_group_category="";
            $jewellery_store_count="";
            $nearest_city_distance="";
            $railway_station_count="";
            $religious_place_count="";
            $beauty_and_salon_count="";
            $monthly_average_income="";
            $vegetable_market_count="";
            $apartment_complex_count="";
            $electronics_store_count="";
            $nearest_cinema_distance="";
            $nearest_school_distance="";
            $nearest_airport_distance="";
            $nearest_college_distance="";
            $automotive_showroom_count="";
            $nearest_bus_stop_distance="";
            $nearest_religious_distance="";
            $social_service_count_ngo="";
            $average_daily_footfall_count="";
            $college_and_university_count="";
            $money_transfer_service_count="";
            $mass_media_entertainment_count="";
            $nearest_metro_station_distance="";
            $nearest_shopping_mall_distance="";
            $electronic_service_centre_count="";
            $stationary_and_xerox_shop_count="";
            $nearest_railway_station_distance="";
            $average_daily_traffic_12am="";
            $average_daily_traffic_12pm="";
            $average_daily_traffic_6am="";
            $average_daily_traffic_6pm="";
            $automotive_repair_and_maintenance_count="";
           

            if (count($poi_data) > 0){

                if (isset($poi_data['gym_count']['value'])) {
                    $gym_count=$poi_data['gym_count']['value'];
                }

                if (isset($poi_data['cafe_count']['value'])) {

                    $cafe_count=$poi_data['cafe_count']['value'];
                }

                if (isset($poi_data['mall_count']['value'])) {

                    $mall_count=$poi_data['mall_count']['value'];
                }
               
                if (isset($poi_data['park_count']['value'])) {

                    $park_count=$poi_data['park_count']['value'];
                }

                if (isset($poi_data['nearest_city']['value'])) {

                    $nearest_city=$poi_data['nearest_city']['value'];
                }


                if (isset($poi_data['office_count']['value'])) {

                    $office_count=$poi_data['office_count']['value'];
                }
               
                if (isset($poi_data['others_count']['value'])) {
                    $others_count=$poi_data['others_count']['value'];
                }

                if (isset($poi_data['school_count']['value'])) {
                    $school_count=$poi_data['school_count']['value'];
                }


                if (isset($poi_data['grocery_count']['value'])) {
                    $grocery_count=$poi_data['grocery_count']['value'];
                }

                if (isset($poi_data['lodging_count']['value'])) {
                    $lodging_count=$poi_data['lodging_count']['value'];
                }


                if (isset($poi_data['area_affluence']['value'])) {
                    $area_affluence=$poi_data['area_affluence']['value'];
                }

                if (isset($poi_data['bus_stop_count']['value'])) {
                    $bus_stop_count=$poi_data['bus_stop_count']['value'];
                }

                if (isset($poi_data['hospital_count']['value'])) {
                    $hospital_count=$poi_data['hospital_count']['value'];

                }

                if (isset($poi_data['pharmacy_count']['value'])) {
                    $pharmacy_count=$poi_data['pharmacy_count']['value'];

                }

                if (isset($poi_data['market_presence']['value'])) {
                    $market_presence=$poi_data['market_presence']['value'];
                }

                if (isset($poi_data['office_presence']['value'])) {
                    $office_presence=$poi_data['office_presence']['value'];

                }

                if (isset($poi_data['pet_store_count']['value'])) {
                    $pet_store_count=$poi_data['pet_store_count']['value'];

                }

                if (isset($poi_data['total_POI_count']['value'])) {
                    $total_POI_count=$poi_data['total_POI_count']['value'];
                }

                if (isset($poi_data['warehouse_count']['value'])) {
                    $warehouse_count=$poi_data['warehouse_count']['value'];
                }

                if (isset($poi_data['pincode_category']['value'])) {
                    $pincode_category=$poi_data['pincode_category']['value'];
                }
                if (isset($poi_data['restaurant_count']['value'])) {
                    $restaurant_count=$poi_data['restaurant_count']['value'];
                }

                if (isset($poi_data['wholesaler_count']['value'])) {
                    $wholesaler_count=$poi_data['wholesaler_count']['value'];
                }


                if (isset($poi_data['bus_station_count']['value'])) {
                    $bus_station_count=$poi_data['bus_station_count']['value'];
                }

                if (isset($poi_data['cinema_hall_count']['value'])) {
                    $cinema_hall_count=$poi_data['cinema_hall_count']['value'];
                }

                if (isset($poi_data['event_venue_count']['value'])) {
                    $event_venue_count=$poi_data['event_venue_count']['value'];
                }
                if (isset($poi_data['other_store_count']['value'])) {
                    $liquor_shop_count=$poi_data['other_store_count']['value'];
                }

                if (isset($poi_data['other_store_count']['value'])) {
                    $other_store_count=$poi_data['other_store_count']['value'];
                }

                if(isset($poi_data['petrol_pump_count']['value'])){

                    $petrol_pump_count=$poi_data['petrol_pump_count']['value'];
                }


                if(isset($poi_data['manufacturer_count']['value'])){

                    $manufacturer_count=$poi_data['manufacturer_count']['value'];
                }

                if(isset($poi_data['sports_store_count']['value'])){

                    $sports_store_count=$poi_data['sports_store_count']['value'];
                }

                if(isset($poi_data['travel_agent_count']['value'])){

                    $travel_agent_count=$poi_data['travel_agent_count']['value'];
                }

                if(isset($poi_data['weekly_impressions']['value'])){

                    $weekly_impressions=$poi_data['weekly_impressions']['value'];
                }

                if(isset($poi_data['doctor_clinic_count']['value'])){

                    $doctor_clinic_count=$poi_data['doctor_clinic_count']['value'];
                }

                if(isset($poi_data['metro_station_count']['value'])){

                    $metro_station_count=$poi_data['metro_station_count']['value'];
                }

                if(isset($poi_data['clothing_store_count']['value'])){

                    $clothing_store_count=$poi_data['clothing_store_count']['value'];
                }

                if(isset($poi_data['footwear_store_count']['value'])){

                    $footwear_store_count=$poi_data['footwear_store_count']['value'];
                }


                if(isset($poi_data['hardware_store_count']['value'])){

                    $hardware_store_count=$poi_data['hardware_store_count']['value'];
                }


                if(isset($poi_data['market_concentration']['value'])){

                    $market_concentration=$poi_data['market_concentration']['value'];
                }

                if(isset($poi_data['office_concentration']['value'])){

                    $office_concentration=$poi_data['office_concentration']['value'];
                }

                if(isset($poi_data['police_station_count']['value'])){

                    $police_station_count=$poi_data['police_station_count']['value'];
                }
                
                if(isset($poi_data['income_group_category']['value'])){

                    $income_group_category=$poi_data['income_group_category']['value'];
                }

                if(isset($poi_data['jewellery_store_count']['value'])){

                    $jewellery_store_count=$poi_data['jewellery_store_count']['value'];
                }

                if(isset($poi_data['nearest_city_distance']['value'])){

                    $nearest_city_distance=$poi_data['nearest_city_distance']['value'];
                }

                if(isset($poi_data['railway_station_count']['value'])){

                    $railway_station_count=$poi_data['railway_station_count']['value'];
                }
                if(isset($poi_data['religious_place_count']['value'])){

                    $religious_place_count=$poi_data['religious_place_count']['value'];
                }

                if(isset($poi_data['beauty_and_salon_count']['value'])){

                    $beauty_and_salon_count=$poi_data['beauty_and_salon_count']['value'];
                }

                if(isset($poi_data['monthly_average_income']['value'])){

                    $monthly_average_income=$poi_data['monthly_average_income']['value'];
                }

                if(isset($poi_data['vegetable_market_count']['value'])){

                    $vegetable_market_count=$poi_data['vegetable_market_count']['value'];
                }

                if(isset($poi_data['apartment_complex_count']['value'])){

                    $apartment_complex_count=$poi_data['apartment_complex_count']['value'];
                }

                if(isset($poi_data['electronics_store_count']['value'])){

                    $electronics_store_count=$poi_data['electronics_store_count']['value'];
                }

                if(isset($poi_data['nearest_cinema_distance']['value'])){

                    $nearest_cinema_distance=$poi_data['nearest_cinema_distance']['value'];
                }

                if(isset($poi_data['nearest_school_distance']['value'])){

                    $nearest_school_distance=$poi_data['nearest_school_distance']['value'];
                }

                if(isset($poi_data['nearest_airport_distance']['value'])){

                    $nearest_airport_distance=$poi_data['nearest_airport_distance']['value'];
                }

                if(isset($poi_data['nearest_college_distance']['value'])){

                    $nearest_college_distance=$poi_data['nearest_college_distance']['value'];
                }

                if(isset($poi_data['automotive_showroom_count']['value'])){

                    $automotive_showroom_count=$poi_data['automotive_showroom_count']['value'];
                }

                if(isset($poi_data['nearest_bus_stop_distance']['value'])){

                    $nearest_bus_stop_distance=$poi_data['nearest_bus_stop_distance']['value'];
                }

                if(isset($poi_data['nearest_religious_distance']['value'])){

                    $nearest_religious_distance=$poi_data['nearest_religious_distance']['value'];
                }

                if(isset($poi_data['social_service_count_(NGO)']['value'])){

                    $social_service_count_ngo=$poi_data['social_service_count_(NGO)']['value'];
                }

                if(isset($poi_data['average_daily_footfall_count']['value'])){

                    $average_daily_footfall_count=$poi_data['average_daily_footfall_count']['value'];
                }

                if(isset($poi_data['college_and_university_count']['value'])){

                    $college_and_university_count=$poi_data['college_and_university_count']['value'];
                }

                if(isset($poi_data['money_transfer_service_count']['value'])){

                    $money_transfer_service_count=$poi_data['money_transfer_service_count']['value'];
                }

                if(isset($poi_data['mass_media_entertainment_count']['value'])){

                    $mass_media_entertainment_count=$poi_data['mass_media_entertainment_count']['value'];
                }
                if(isset($poi_data['nearest_metro_station_distance']['value'])){

                    $nearest_metro_station_distance=$poi_data['nearest_metro_station_distance']['value'];
                }

                if(isset($poi_data['nearest_shopping_mall_distance']['value'])){

                    $nearest_shopping_mall_distance=$poi_data['nearest_shopping_mall_distance']['value'];
                }

                if(isset($poi_data['electronic_service_centre_count']['value'])){

                    $electronic_service_centre_count=$poi_data['electronic_service_centre_count']['value'];
                }

                if(isset($poi_data['stationary_and_xerox_shop_count']['value'])){

                    $stationary_and_xerox_shop_count=$poi_data['stationary_and_xerox_shop_count']['value'];
                }

                if(isset($poi_data['nearest_railway_station_distance']['value'])){

                    $nearest_railway_station_distance=$poi_data['nearest_railway_station_distance']['value'];
                }


                if(isset($poi_data['average_daily_traffic_12am-6am_count']['value'])){

                    $average_daily_traffic_12am=$poi_data['average_daily_traffic_12am-6am_count']['value'];
                }

                if(isset($poi_data['average_daily_traffic_12pm-6pm_count']['value'])){

                    $average_daily_traffic_12pm=$poi_data['average_daily_traffic_12pm-6pm_count']['value'];
                }

                if(isset($poi_data['average_daily_traffic_6am-12pm_count']['value'])){

                    $average_daily_traffic_6am=$poi_data['average_daily_traffic_6am-12pm_count']['value'];
                }

                if(isset($poi_data['average_daily_traffic_6pm-12am_count']['value'])){

                    $average_daily_traffic_6pm=$poi_data['average_daily_traffic_6pm-12am_count']['value'];
                }

                if(isset($poi_data['automotive_repair_and_maintenance_count']['value'])){

                    $automotive_repair_and_maintenance_count=$poi_data['automotive_repair_and_maintenance_count']['value'];
                }  
                
            }


            fputcsv($myfilePath, array($area_data->site_location, $area_data->road_name, $area_data->title, $area_data->pin_code, $area_data->lat,$area_data->lng,$area_data->city->name,$area_data->state->name,$area_data->place_type,$area_data->media_formats,$area_data->orientation, $area_data->media_tags,$area_data->width,$area_data->height,$area_data->illumination,$area_data->ad_spot_durations,$area_data->ad_spot_per_second,$area_data->total_advertiser,$area_data->display_charge_pm,$area_data->production_cost,$area_data->installation_cost,$area_data->media_partner_name,$site_dtl[0]['label'],$site_dtl[1]['label'],$site_dtl[2]['label'],$site_dtl[3]['label'],$site_dtl[4]['label'], $gym_count,$cafe_count,$mall_count,$park_count,$nearest_city,$office_count,$others_count,$school_count,$grocery_count,$lodging_count,$area_affluence,$bus_stop_count,$hospital_count,$pharmacy_count,
            $market_presence,$office_presence,$pet_store_count,$total_POI_count,$warehouse_count,$pincode_category,$restaurant_count,$wholesaler_count,$bus_station_count,$cinema_hall_count,$event_venue_count,$liquor_shop_count,$other_store_count,$petrol_pump_count,$manufacturer_count,
            $sports_store_count,$travel_agent_count,$weekly_impressions,$doctor_clinic_count,$metro_station_count,$clothing_store_count,
            $footwear_store_count,$hardware_store_count,$market_concentration,$office_concentration,$police_station_count,
            $income_group_category,$jewellery_store_count,$nearest_city_distance,$railway_station_count,$religious_place_count,
            $beauty_and_salon_count,$monthly_average_income,$vegetable_market_count,$apartment_complex_count,$electronics_store_count,$nearest_cinema_distance,$nearest_school_distance,$nearest_airport_distance,$nearest_college_distance,$automotive_showroom_count,
            $nearest_bus_stop_distance,$nearest_religious_distance,$social_service_count_ngo,$average_daily_footfall_count,
            $college_and_university_count,$money_transfer_service_count,$mass_media_entertainment_count,$nearest_metro_station_distance,$nearest_shopping_mall_distance,$electronic_service_centre_count,$stationary_and_xerox_shop_count,$nearest_railway_station_distance,$average_daily_traffic_12am,$average_daily_traffic_12pm,$average_daily_traffic_6am,$average_daily_traffic_6pm,$automotive_repair_and_maintenance_count));
            
        }
        
        fclose($myfilePath);
        $content = "Please find the site details attached";
        Mail::send(['html' => 'mail'], ['content' => $content], function ($message){
            $message->subject("Site Details");
            $message->to("subhajit.mukherjee@indusnet.co.in");
            $message->attach(public_path('/araedtl.csv'));
        });
        
        $this->info("Mail sent successfull");
        return true;
    }
}
