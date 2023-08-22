<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\Area;
use App\Models\State;
use App\Models\City;
use App\Models\User;
use App\Models\Notification;
use App\Models\SiteMerit;
use App\Models\SiteMeritValue;
use Illuminate\Support\Facades\Http;
use Validator;
use Mail; 

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $filters = [
            'area_id' => $request->query('area_id'),
            'area_name' => $request->query('area_name'),
            'status' => $request->query('status'),
        ];

        // fetching city lists
        $areas = Area::sortable()->where('areas.is_deleted', '=', 0);
        
        // checks if search filters are set
        if($filters['area_id'] != '') {
            $areas->where('areas.id', 'like', '%'.$filters['area_id'].'%');
        }
        if($filters['area_name'] != '') {
            $areas->where('areas.title', 'like', '%'.$filters['area_name'].'%');
        }
        if($filters['status'] != '') {
            $areas->where('areas.status', '=', $filters['status']);
        }
        $areas = $areas->orderBy('status', 'ASC')->paginate(100);
        
        return view('admin::area.index', ['areas'=>$areas, 'filters' => $filters]);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function campaign_generate_pdf(Request $request)
    {
        return view('admin::area.campaign_generate');
    }


    /**
     * Display Add city template
     * @return Renderable
     */
    public function add()
    {
        
        
        // $site_merit_values = SiteMeritValue::where('is_deleted', '=', 0)
        //                     ->where('status', '=', 1)->get();
        // foreach($site_merit_values as $site_merit_value) {
        //     dd($site_merit_value->site_merit);exit;
        // }

        // $areas = Area::with('site_merit_values')
        //                 ->where('is_deleted', '=', 0)
        //                 ->where('status', '=', 1)
        //                 ->where('id', '=', '13236')->get();
        // foreach($areas as $area) {
        //     dd($area->site_marit_values->site_merit);exit;
        // }

        // // fetching cities
        // $cities = City::where('is_deleted', '=', 0)
        //                     ->where('status', '=', 1)->get();
        // // fetching states
        // $states = State::where('is_deleted', '=', 0)
        //                     ->where('status', '=', 1)->get();

        // city tags assignment
        $city_tags = [
            'Mega' => 'Mega',
            'Metro' => 'Metro',
            'Mini' => 'Mini',
        ];

        // location type assignment
        $location_types = [
            'Impact' => 'Impact',
            'Filter' => 'Filter',
        ];

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

        // orientations assignment
        $orientations = [
            'Static' => 'Static',
            'Digital' => 'Digital',
        ];


        // media tags assignment
        $media_tags = [
            'Impact' => 'Impact',
            'Frequency' => 'Frequency',
            'Ambience' => 'Ambience',
        ];

        // Illumination assignment
        $illuminations = [
            'Frontlit' => 'Frontlit',
            'Backlit' => 'Backlit',
            'Digital' => 'Digital',
            'Nonlit' => 'Nonlit',
        ];

        // Illumination assignment
        $priority = [
            'priority1' => 'priority1',
            'priority2' => 'priority2',
            'priority3' => 'priority3',
        ];

        // ad spot duration
        $ad_spot_durations = ['NA', '5', '10', '15', '20', '25', '30', '35', '40', '45', '50', '55', '60'];

        $site_merits = SiteMerit::where('is_deleted', '=', 0)
                            ->where('status', '=', 1)->get();
        
        
        // site count generation
        $site_count = [];
        for($sCount = 1; $sCount <=50; $sCount++) {
            $site_count[] = $sCount;
        }

        return view('admin::area.add', ['site_count' => $site_count, 'priority' => $priority, 'city_tags' => $city_tags, 'location_types' => $location_types, 'media_formats' => $media_formats, 'orientations' => $orientations, 'media_tags' => $media_tags, 'illuminations' => $illuminations, 'ad_spot_durations' => $ad_spot_durations, 'site_merits' => $site_merits]);
    }

    /**
     * Adds city record
     * @return Renderable
     */
    public function create_area(Request $request)
    {
        //echo "<pre>";print_r($request->input('city_name'));exit;
        // Validation
        $validator = Validator::make($request->all(), [
            'site_location' => 'required',
            'road_name' => 'required',
            'area_name' => 'required',
            'pin_code' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'height' => 'required',
            'city_name' => 'required',
            'state_name' => 'required',
            'city_tag' => 'required',
            'area_pic1' => 'required|mimes:png,jpg,jpeg|max:7168',
            //'nearby_places' => 'required|array|max:6',
        ]);

        
        if ($validator->passes()) {
            $area_pic1 = '';

            // finding city name and if not found then create city
            $states = State::where('is_deleted', '=', 0)
                            ->where('name', '=', $request->input('state_name'))
                            ->where('status', '=', 1)->get();
            if($states->count()) {
                foreach($states as $state) {
                    $state_id = $state->id;
                }
            } else {
                // create a state
                $state_obj = State::create([
                    'name' => $request->input('state_name'),
                    'status' => 1,
                ]);
                $state_id = $state_obj->id;
            }
            
            // finding city name and if not found then create city
            $cities = City::where('is_deleted', '=', 0)
                            ->where('name', '=', $request->input('city_name'))
                            ->where('status', '=', 1)->get();
            if($cities->count()) {
                foreach($cities as $city) {
                    $city_id = $city->id;
                }
            } else {
                // create a city
                $city_obj = City::create([
                    'name' => $request->input('city_name'),
                    'state_id' => $state_id,
                    'status' => 1,
                ]);
                $city_id = $city_obj->id;
            }
            

            // checking for area pic1
            if($request->area_pic1) {
                // picture upload
                $fileName1 = auth()->id() . '_' . time() . '.'. $request->area_pic1->extension();  
                $type1 = $request->area_pic1->getClientMimeType();
                $size1 = $request->area_pic1->getSize();
                $request->area_pic1->move(public_path('application_files/area_images'), $fileName1);
                $area_pic1 = $fileName1;
            }
            
            // checking for area pic2
            $area_pic2 = '';
            if($request->area_pic2) {
                // picture upload
                $fileName2 = auth()->id() . '_' .rand(1111,9999). '_'. time() . '.'. $request->area_pic2->extension();  
                $type2 = $request->area_pic2->getClientMimeType();
                $size2 = $request->area_pic2->getSize();
                $request->area_pic2->move(public_path('application_files/area_images'), $fileName2);
                $area_pic2 = $fileName2;
            }

            //checking for area videos
            $area_video = '';
            if($request->area_video) {
                // picture upload
                $fileName3 = auth()->id() . '_' .rand(2222,9999). '_'. time() . '.'. $request->area_video->extension();  
                $type3 = $request->area_video->getClientMimeType();
                $size3 = $request->area_video->getSize();
                $request->area_video->move(public_path('application_files/area_videos'), $fileName3);
                $area_video = $fileName3;
            }

            // create area record
            $areas = Area::create([
                'title' => $request->input('area_name'),
                'site_location' => $request->input('site_location'),
                'priority' => $request->input('priority'),
                'road_name' => $request->input('road_name'),
                'pin_code' => $request->input('pin_code'),
                'lat' => $request->input('lat'),
                'lng' => $request->input('lng'),
                'state_id' => $state_id,
                'city_id' => $city_id,
                'city_tag' => $request->input('city_tag'),
                'face_traffic_from' => $request->input('face_traffic_from'),
                'media_formats' => $request->input('media_formats'),
                'orientation' => $request->input('orientation'),
                'media_tags' => $request->input('media_tags'),
                'height' => $request->input('height'),
                'width' => $request->input('width'),
                'illumination' => $request->input('illumination'),
                'ad_spot_per_second' => $request->input('ad_spot_per_second'),
                'total_ad_spot_perday' => $request->input('total_ad_spot_perday'),
                'total_advertiser' => $request->input('total_advertiser'),
                'display_charge_pm' => $request->input('display_charge_pm'),
                'production_cost' => $request->input('production_cost'),
                'installation_cost' => $request->input('installation_cost'),
                'media_partner_name' => $request->input('media_partner_name'),
                'media_partner_email' => $request->input('media_partner_email'),
                'site_count' => $request->input('site_count'),
                'area_pic1' => $area_pic1,
                'area_pic2' => $area_pic2,
                'area_video' => $area_video,
                'status' => 0
                //'nearby_places' => json_encode($request->input('nearby_places')),
            ]);

            // fetching site merit values and assigning to area object
            $site_merits = SiteMerit::where('is_deleted', '=', 0)
                    ->where('status', '=', 1)->get();
            $site_merit_values = [];
            foreach($site_merits as $site_merit) {
                $site_merit_values[] = $request->input('site_merit_'.$site_merit->id);
            }
            $areas->site_marit_values()->attach($site_merit_values);


            
            // adding notification
            $super_admin_users = User::with('role')
            ->whereRelation('role', 'role_id', '=', 'admin')
            ->get();
            foreach($super_admin_users as $super_admin_user) {
                $notifications = Notification::create([
                    'title' => 'A new area has been added',
                    'route' => 'admin.area_edit',
                    'object_id' => $areas->id,
                    'user_id' => $super_admin_user->id,
                    'type' => 'area',
                    'is_read' => 0
                ]);
            }

            // redirecting to the fetch poi section
            return redirect()->route('admin.fetch_poi', ['id' => $areas->id]);
        } else {
            $dt = $request->except(['area_pic1', 'area_pic2', 'area_video']);
            $errors=$validator->errors();//dd($errors);exit;
            return redirect()->route('admin.area_add')->with('errors',$errors)->with('requestInput',$dt);
        }

        return redirect()->intended('admin/areas')->withSuccess('Area created successfully');
    }

    /**
     * Display Edit area template
     * @return Renderable
     */
    public function edit($id)
    {

        // updating nottifications
        Notification::where("object_id",$id)->where("is_read",0)->where("type", "area")->update(array('is_read' => 1));


        // fetching user details
        $area_data = Area::find($id);
        
        // city tags assignment
        $city_tags = [
            'Mega' => 'Mega',
            'Metro' => 'Metro',
            'Mini' => 'Mini',
        ];

        // location type assignment
        $location_types = [
            'Impact' => 'Impact',
            'Filter' => 'Filter',
        ];

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

        // orientations assignment
        $orientations = [
            'Static' => 'Static',
            'Digital' => 'Digital',
        ];


        // media tags assignment
        $media_tags = [
            'Impact' => 'Impact',
            'Frequency' => 'Frequency',
            'Ambient' => 'Ambient',
        ];

        // Illumination assignment
        $illuminations = [
            'Frontlit' => 'Frontlit',
            'Backlit' => 'Backlit',
            'Digital' => 'Digital',
            'Nonlit' => 'Nonlit',
        ];

        // Illumination assignment
        $priority = [
            'priority1' => 'priority1',
            'priority2' => 'priority2',
            'priority3' => 'priority3',
        ];

        // ad spot duration
        $ad_spot_durations = ['NA', '5', '10', '15', '20', '25', '30', '35', '40', '45', '50', '55', '60'];

        // fetching site merits
        $site_merits_values_assigned = [];
        $site_merits = SiteMerit::where('is_deleted', '=', 0)
                            ->where('status', '=', 1)->get();
        foreach($area_data->site_marit_values as $site_marit_value) {
            $site_merits_values_assigned[] = $site_marit_value->id;
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

        // site count generation
        $site_count = [];
        for($sCount = 1; $sCount <=50; $sCount++) {
            $site_count[] = $sCount;
        }

        if(isset($area_data->gridTrends['average_daily_traffic_12am-6am_count']) && isset($area_data->gridTrends['average_daily_traffic_12pm-6pm_count']) && isset($area_data->gridTrends['average_daily_traffic_6am-12pm_count']) && isset($area_data->gridTrends['average_daily_traffic_6pm-12am_count'])) {
            $weekly_traffic_count = ($area_data->gridTrends['average_daily_traffic_12am-6am_count']+$area_data->gridTrends['average_daily_traffic_12pm-6pm_count']+$area_data->gridTrends['average_daily_traffic_6am-12pm_count']+$area_data->gridTrends['average_daily_traffic_6pm-12am_count'])*7;
        } else {
            $weekly_traffic_count = 'NA';
        }

        // loading role object from auth user id
        $user_role_obj = User::find(auth()->user()->id);
        $role_id = $user_role_obj->role->role_id;
        
        
        return view('admin::area.edit', ['role_id' => $role_id, 'weekly_traffic_count' => $weekly_traffic_count, 'site_count' => $site_count, 'poi_data' => $poi_data, 'priority' => $priority, 'area_data' => $area_data, 'city_tags' => $city_tags, 'location_types' => $location_types, 'media_formats' => $media_formats, 'orientations' => $orientations, 'media_tags' => $media_tags, 'illuminations' => $illuminations, 'ad_spot_durations' => $ad_spot_durations, 'site_merits' => $site_merits, 'site_merits_values_assigned' => $site_merits_values_assigned]);
    }


    /**
     * Display Fetch poi template
     * @return Renderable
     */
    public function fetch_poi($id)
    {
        // fetching user details
        $area_data = Area::find($id);

        // fetching api key and url
        $api_url = env('FETCH_POI_URL');
        $api_key = env('FETCH_POI_KEY');
        
        // setting the header
        $headers = [
            'apikey' => $api_key
        ];

        // setting the post input
        $post_input = [
            'lat' => $area_data->lat,
            'lng' => $area_data->lng,
        ];
        
        // fetching the response
        $response = Http::withHeaders($headers)->post($api_url, $post_input);

        if($response) {
            $statusCode = $response->status();
            $responseBody = json_decode($response->getBody(), true);
        
            
            $poi_data = [];
            if($statusCode == '201') {
                $gridTrends = $responseBody['gridTrends'];

                foreach($gridTrends as $key => $value) {
                    $poi_data[$key]['value'] = $value;
                    $poi_data[$key]['label'] = ucwords(str_replace('_', ' ', $key));
                }
            } else {
                $area_data->error_response = json_encode($responseBody);
                $area_data->save();
                return redirect()->intended('admin/areas')->withError('Something went wrong');
            }
            
            return view('admin::area.fetch_poi', ['area_id' => $id, 'poi_data' => $poi_data]);
        } else {
            $error = 'No data received';
            $area_data->error_response = $error != ''?$error:'';
            $area_data->save();
            return redirect()->intended('admin/areas')->withError('Something went wrong');
        }    
    }

    /**
     * Display Fetch poi template
     * @return Renderable
     */
    public function add_poi(Request $request) {
        // fetching area details
        $model= Area::find($request->input('area_id'));
        
        $poi_data = [];
        foreach($request->all() as $key => $value) {
            if($key != '_token' && $key != 'area_id') {
                $poi_data[$key] = $value;
            }
        }
        $model->gridTrends = $poi_data;
        $model->save();

        return redirect()->route('admin.view_poi', ['id' => $request->input('area_id')]);
    }


    /**
     * Display Fetch poi template
     * @return Renderable
     */
    public function view_poi($id) {
        // fetching area details
        $model= Area::find($id);
        
        if(!empty($model->gridTrends)) {
            $poi_data = [];
            foreach($model->gridTrends as $key => $value) {
                if($value != '0' && $value != '') {
                    $poi_data[$key]['value'] = $value;
                    $poi_data[$key]['label'] = ucwords(str_replace('_', ' ', $key));
                }
            }
        } else {
            return redirect()->intended('admin/areas')->withSuccess('Area created successfully');
        }
        
        
        return view('admin::area.view_poi', ['poi_data' => $poi_data]);
    }


    /**
     * Updates city record
     * @return Renderable
     */
    public function update_area(Request $request, $id)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'site_location' => 'required',
            'road_name' => 'required',
            'area_name' => 'required',
            'pin_code' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'height' => 'required',
            'city_name' => 'required',
            'state_name' => 'required',
            'city_tag' => 'required',
            //'area_pic1' => 'required|mimes:png,jpg,jpeg|max:7168',
        ]);

        
        if ($validator->passes()) {
            // finding city name and if not found then create city
            $states = State::where('is_deleted', '=', 0)
                            ->where('name', '=', $request->input('state_name'))
                            ->where('status', '=', 1)->get();
            if($states->count()) {
                foreach($states as $state) {
                    $state_id = $state->id;
                }
            } else {
                // create a state
                $state_obj = State::create([
                    'name' => $request->input('state_name'),
                    'status' => 1,
                ]);
                $state_id = $state_obj->id;
            }
            
            // finding city name and if not found then create city
            $cities = City::where('is_deleted', '=', 0)
                            ->where('name', '=', $request->input('city_name'))
                            ->where('status', '=', 1)->get();
            if($cities->count()) {
                foreach($cities as $city) {
                    $city_id = $city->id;
                }
            } else {
                // create a city
                $city_obj = City::create([
                    'name' => $request->input('city_name'),
                    'state_id' => $state_id,
                    'status' => 1,
                ]);
                $city_id = $city_obj->id;
            }

            // fetching the area data wrt id
            $model= Area::find($id);

            // checking for area pic1
            $area_pic1 = '';
            if($request->area_pic1) {
                // picture upload
                $fileName1 = auth()->id() . '_' . time() . '.'. $request->area_pic1->extension();  
                $type1 = $request->area_pic1->getClientMimeType();
                $size1 = $request->area_pic1->getSize();
                $request->area_pic1->move(public_path('application_files/area_images'), $fileName1);
                $area_pic1 = $fileName1;
            }
            
            // checking for area pic2
            $area_pic2 = '';
            if($request->area_pic2) {
                // picture upload
                $fileName2 = auth()->id() . '_' .rand(1111,9999).'_'.time() . '.'. $request->area_pic2->extension();  
                $type2 = $request->area_pic2->getClientMimeType();
                $size2 = $request->area_pic2->getSize();
                $request->area_pic2->move(public_path('application_files/area_images'), $fileName2);
                $area_pic2 = $fileName2;
            }

            //checking for area videos
            $area_video = '';
            if($request->area_video) {
                // picture upload
                $fileName3 = auth()->id() . '_' .rand(1111,9999).'_'.time() . '.'. $request->area_video->extension();  
                $type3 = $request->area_video->getClientMimeType();
                $size3 = $request->area_video->getSize();
                $request->area_video->move(public_path('application_files/area_videos'), $fileName3);
                $area_video = $fileName3;
            }

            $model->title = $request->input('area_name');
            $model->site_location = $request->input('site_location');
            $model->priority = $request->input('priority');
            $model->road_name = $request->input('road_name');
            $model->pin_code = $request->input('pin_code');
            $model->lat = $request->input('lat');
            $model->lng = $request->input('lng');
            $model->state_id = $state_id;
            $model->city_id = $city_id;
            $model->city_tag = $request->input('city_tag');
            $model->face_traffic_from = $request->input('face_traffic_from');
            $model->media_formats = $request->input('media_formats');
            $model->orientation = $request->input('orientation');
            $model->media_tags = $request->input('media_tags');
            $model->height = $request->input('height');
            $model->width = $request->input('width');
            $model->illumination = $request->input('illumination');
            $model->ad_spot_per_second = $request->input('ad_spot_per_second');
            $model->total_ad_spot_perday = $request->input('total_ad_spot_perday');
            $model->total_advertiser = $request->input('total_advertiser');
            $model->display_charge_pm = $request->input('display_charge_pm');
            $model->production_cost = $request->input('production_cost');
            $model->installation_cost = $request->input('installation_cost');
            $model->media_partner_name = $request->input('media_partner_name');
            $model->media_partner_email = $request->input('media_partner_email');
            $model->site_Count = $request->input('site_count');
            if($area_pic1 != '') {
                $model->area_pic1 = $area_pic1;
            }
            if($area_pic2 != '') {
                $model->area_pic2 = $area_pic2;
            }
            if($area_video != '') {
                $model->area_video = $area_video;
            }
            if(app('request')->exists('status')) {
                $model->status = $request->input('status');
            }
            $model->updated_at = date("Y-m-d H:i:s");

            // update user record
            $model->save();

            // fetching site merit values and assigning to area object
            $site_merits = SiteMerit::where('is_deleted', '=', 0)
                    ->where('status', '=', 1)->get();
            $site_merit_values = [];
            foreach($site_merits as $site_merit) {
                $site_merit_values[] = $request->input('site_merit_'.$site_merit->id);
            }
            $model->site_marit_values()->sync($site_merit_values);

            return redirect()->intended('admin/areas')->withSuccess('Area updated successfully');
        } else {
            $errors=$validator->errors();
            return redirect()->route('admin.area_edit', ['id' => $id])->with('errors',$errors);
        }
    }


    /**
     * Soft delete city record
     * @return Renderable
     */
    public function area_delete(Request $request, $id)
    {
        // fetching the city data wrt id
        $model= Area::find($id);

        // creating city data updation object
        $model->is_deleted = 1;
        
        // update city record
        $model->save();

        return redirect()->intended('admin/areas')->withSuccess('Area deleted successfully');
    }


    public function test(){

        $filename = time().'.csv';
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
        $content = "New mail";
        Mail::send(['html' => 'mail'], ['content' => $content], function ($message){
            $message->subject("excel send");
            $message->to("sutapa.majumder@indusnet.co.in");
            $message->attach(public_path('/industry.csv'));
        });
       
    }


    /*public function test(){

        $area_data = Area::find(16662);

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


        if (count($poi_data) > 0){

            echo "<pre>"; print_r($poi_data); exit;
        }
  
    }*/
}
