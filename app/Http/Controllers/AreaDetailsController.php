<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Area;
use App\Models\Feedback;
use App\Models\SiteMerit;
use App\Models\ConnectRequest;
use App\Models\Notification;
use App\Models\User;
use App\Models\Download;
use Illuminate\Support\Facades\Http;
use Session;
use Validator;
use Hash;

class AreaDetailsController extends Controller
{
    public function index(Request $request, $id)
    {
        //area
        $data = Area::where('is_deleted', '=', 0)
                    ->where('status', '=', 1)->find($id);
        
        
        if(!$data) {
            return redirect()->route('frontend.home');
        }

        // fetching site merits
        $site_merits_arr = [];
        $site_merits = SiteMerit::where('is_deleted', '=', 0)
                            ->where('status', '=', 1)->get();
        foreach($site_merits as $site_merit) {
            $site_merits_arr[$site_merit->id] = [
                'title' => $site_merit->title,
                'icon' => $site_merit->icon
            ];
        }

        // generating poi data from area details
        $nearby_places = [];
        if(!empty($data->gridTrends)) {
            foreach($data->gridTrends as $key => $value) {
                if(strpos($key,"nearest") !== false && strpos($key,"distance") !== false) {
                    $nearest_arr[$key] = $value; 
                }
            }

            asort($nearest_arr);
            $nearest_arr_sliced = array_slice($nearest_arr,0, 6);
            foreach($nearest_arr_sliced as $k => $v) {
                $k_arr = explode('_', $k);
                $nearby_places_arr[implode('_', array_slice($k_arr, 1, (count($k_arr)-2)))] = $v;
            }

            // formatting the data
            foreach($nearby_places_arr as $ke => $val) {
                $val_arr = explode('.', $val);
                $nearby_places[$ke]['label'] = ucwords(str_replace('_', ' ', $ke));
                $nearby_places[$ke]['value'] = round($val, 2).' km from';
                $nearby_places[$ke]['image'] = url('public/front-assets/images').'/'.$ke.'.svg';
            }
        }
        
        

        // finding the recommendation lists with respect to city of the area
        $api_url = env('RECO_ENGINE_URL');
        $response = Http::post($api_url, [
            "title" => $data->title,
            "city_id" => $data->city_id
        ]);

        $statusCode = $response->status();
        $responseBody = json_decode($response->getBody(), true);

        if($statusCode == 200) {
            if(array_key_exists('recommendations', $responseBody)) {
                $reco_sites = $responseBody['recommendations'];
            } else {
                $reco_sites = $responseBody;
            }
        } else {
            $reco_sites = [];
        }
      
        // checking if message is on response
        if(array_key_exists('message', $reco_sites)) {
            $reco_sites = [];
        }

        

        //feedback
        $feedbacks = Feedback::where('is_deleted', '=', 0)
                    ->where('status', '=', 1)
                    ->where('area_id', '=', $id)
                    ->orderBy('id', 'desc')->limit(3)->get();
        
        return view('area-details.index', compact('data', 'id'), ['reco_sites' => $reco_sites, 'nearby_places' => $nearby_places, 'feedbacks' => $feedbacks, 'site_merits_arr' => $site_merits_arr]); 
    }

    public function autocompleteSearch(Request $request)
    {
        $query_text = $request->get('search');
        $res = [];
        
        // running the query for generating the result
        $filterResults = Area::select("title", "id", "site_location", "city_id")
                                ->where('is_deleted', '=', 0)
                                ->Where('status', '=', 1)
                                ->where(function($query) use ($query_text) {
                                    $query->where('title', 'LIKE', '%'.$query_text.'%')
                                    ->orWhere('site_location', 'LIKE', '%'.$query_text.'%');
                                })->limit(5)->get();
                                
        
        // preparing the results
        foreach($filterResults as $filterResult) {
            $res[] = [
                'value' => $filterResult->title.','.$filterResult->site_location,
                'id' => $filterResult->id,
                'city_id' => $filterResult->city_id,
            ];
        }
        
        return response()->json($res);
    }


    public function areaSearch(Request $request)
    {
        $filters['area_id'] = $request->get('area_id_filter')?$request->get('area_id_filter'):$request->get('area_id');
        $filters['city_id'] = $request->get('city_id_filter')?$request->get('city_id_filter'):$request->get('city_id');
        $filters['search_text'] = $request->get('searchText_filter')?$request->get('searchText_filter'):$request->get('searchText');
        $filters['min_price'] = $request->get('min_price');
        $filters['max_price'] = $request->get('max_price');
        $filters['media_formats'] = $request->get('media_formats');
        $ext_filter = false;

        $res = [];
        
        $data = Area::where('is_deleted', '=', 0)
                    ->where('status', '=', 1);
        if($filters['min_price']) {
            $ext_filter = true;
            $data->where('display_charge_pm', '>=', $filters['min_price']);
        }
        
        if($filters['max_price']) {
            $ext_filter = true;
            $data->where('display_charge_pm', '<=', $filters['max_price']);
        }

        if($filters['media_formats']) {
            $ext_filter = true;
            $data->where('media_formats', '=', $filters['media_formats']);
        }
        
        if(!empty($filters['area_id']) && !empty($filters['search_text'])) {
            $data->where('id', '=', $filters['area_id'])->where(function($query) use ($filters) {
                $query->where('title', 'LIKE', '%'.$filters['search_text'].'%')
                ->orWhere('site_location', 'LIKE', '%'.$filters['search_text'].'%')
                ->orWhere('city_id', '=', $filters['city_id']);
            });

            $data = $data->orderByRaw("CASE WHEN id = ".$filters['area_id']." THEN 0 ELSE 1 END, id")
                    ->paginate(8);
        } else if($ext_filter == true) {
            $data = $data->where(function($query) use ($filters) {
                $query->where('title', 'LIKE', '%'.$filters['search_text'].'%')
                ->orWhere('site_location', 'LIKE', '%'.$filters['search_text'].'%')
                ->orWhere('city_id', '=', $filters['city_id']);
            })->paginate(8);
        } else if($filters['city_id']) {
            $data = $data->where('city_id', '=', $filters['city_id'])->paginate(8);
        } else {
            $data = $data->paginate(8);
        }
        
        // media formats assignment
        $media_formats = [
            'Billboard' => 'Billboard',
            'Bus Stop' => 'Bus Stop',
            'Digital POD' => 'Digital POD',
            'Facedes' => 'Facedes',
            'Wall Wraps' => 'Wall Wraps',
            'Gantry' => 'Gantry',
            'Panels' => 'Panels',
            'LED Billboard' => 'LED Billboard',
            'LED Walls(Indoor)' => 'LED Walls(Indoor)',
            'Light Box' => 'Light Box',
            'Utilities' => 'Utilities',
            'Ambient(others)' => 'Ambient(others)',
            'Street(others)' => 'Street(others)',
        ];

        // min price assignment
        $min_price = [10000, 50000, 100000, 150000, 200000, 250000, 300000, 350000, 400000, 450000, 500000, 550000,
                    600000, 650000, 700000, 750000, 800000, 850000, 900000, 950000, 1000000, 1050000, 1100000,
                    1150000, 1200000, 1250000, 1300000, 1350000, 1400000, 1450000, 1500000, 1550000, 1600000, 1650000,
                    1700000, 1750000, 1800000, 1850000, 1900000, 1950000, 2000000, 2050000, 2100000, 2150000, 2200000,
                    2250000, 2300000, 2350000, 2400000, 2450000, 2500000, 2600000, 2650000, 2700000, 2750000, 2800000, 
                    2850000, 2900000, 2950000, 3000000, 3050000, 3100000, 3150000, 3200000, 3250000, 3300000, 3350000, 
                    3400000, 3450000, 3500000, 3550000, 3600000, 3650000, 3700000, 3750000, 3800000, 3850000, 3900000, 
                    3950000, 4000000, 4050000, 4100000, 4150000, 4200000, 4250000, 4300000, 4350000, 4400000, 4450000, 
                    4500000, 4550000, 4600000, 4650000, 4700000, 4750000, 4800000, 4850000, 4900000, 4950000, 5000000                                        
                    ];
        $max_price = [10000, 50000, 100000, 150000, 200000, 250000, 300000, 350000, 400000, 450000, 500000, 550000,
                    600000, 650000, 700000, 750000, 800000, 850000, 900000, 950000, 1000000, 1050000, 1100000,
                    1150000, 1200000, 1250000, 1300000, 1350000, 1400000, 1450000, 1500000, 1550000, 1600000, 1650000,
                    1700000, 1750000, 1800000, 1850000, 1900000, 1950000, 2000000, 2050000, 2100000, 2150000, 2200000,
                    2250000, 2300000, 2350000, 2400000, 2450000, 2500000, 2600000, 2650000, 2700000, 2750000, 2800000, 
                    2850000, 2900000, 2950000, 3000000, 3050000, 3100000, 3150000, 3200000, 3250000, 3300000, 3350000, 
                    3400000, 3450000, 3500000, 3550000, 3600000, 3650000, 3700000, 3750000, 3800000, 3850000, 3900000, 
                    3950000, 4000000, 4050000, 4100000, 4150000, 4200000, 4250000, 4300000, 4350000, 4400000, 4450000, 
                    4500000, 4550000, 4600000, 4650000, 4700000, 4750000, 4800000, 4850000, 4900000, 4950000, 5000000                                        
                    ];
        
        
        // generating the location data
        $locations = [];
        foreach($data as $data_info) {
            $locations[] = [$data_info->title.' ('.$data_info->width.' x '.$data_info->height.')', $data_info->lat, $data_info->lng];
        }

        if ($request->ajax()) {
            $view = view('area-details.area_search_ajax', ['area_lists_ajax' => $data])->render();
            if(count($locations) > 0) {
                return response()->json(['html'=>$view, 'locations_ajax' => json_encode($locations)]);
            } else {
                return response()->json(['html'=>$view, 'locations_ajax' => '']);
            }
            
        }
        
        return view('area-details.area_search', ['locations' => json_encode($locations), 'area_lists' => $data, 'filters' => $filters, 'media_formats' => $media_formats, 'min_price' => $min_price, 'max_price' => $max_price]);
    }

    public function connect_request(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
          'user_id' => 'required',
          'area_id' => 'required'
        ]);
 
        $save = new ConnectRequest;
 
        $save->user_id = $request->user_id;
        $save->area_id = $request->area_id;
 
        $save ->save();

        // adding notification
        $super_admin_users = User::with('role')
        ->whereRelation('role', 'role_id', '=', 'admin')
        ->get();

        
        
        foreach($super_admin_users as $super_admin_user) {
            $notifications = Notification::create([
                'title' => 'A new connect request has been raised by '.$user->full_name,
                'route' => 'admin.connect_request_view',
                'object_id' => $save->id,
                'user_id' => $super_admin_user->id,
                'type' => 'connect_request',
                'is_read' => 0
            ]);
        }
 
        return response()->json(['status'=>'200']);
    }

    public function dload_file(Request $request)
    {
         
        $validatedData = $request->validate([
          'user_id' => 'required',
          'area_id' => 'required'
        ]);
        
        // saving download data
        $save = new Download;
        $save->user_id = $request->user_id;
        $save->area_id = $request->area_id;
        $save ->save();

        // fetching area data
        $area_data = Area::find($request->area_id);
        $file_url = url('public/application_files/area_images').'/'.$area_data->area_pic1;

        return response()->json(['status'=>'200', 'file_name' => $area_data->area_pic1, 'file_url' => $file_url]);
    }
}
