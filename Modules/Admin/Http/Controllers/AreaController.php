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
use Validator;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $filters = [
            'area_name' => $request->query('area_name'),
            'status' => $request->query('status'),
        ];

        // fetching city lists
        $areas = Area::sortable()->where('areas.is_deleted', '=', 0);
        
        // checks if search filters are set
        if($filters['area_name'] != '') {
            $areas->where('areas.title', 'like', '%'.$filters['area_name'].'%');
        }
        if($filters['status'] != '') {
            $areas->where('areas.status', '=', $filters['status']);
        }
        $areas = $areas->orderBy('id', 'DESC')->paginate(10);
        
        return view('admin::area.index', ['areas'=>$areas, 'filters' => $filters]);
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

        // ad spot duration
        $ad_spot_durations = ['NA', '5', '10', '15', '20', '25', '30', '35', '40', '45', '50', '55', '60'];

        $site_merits = SiteMerit::where('is_deleted', '=', 0)
                            ->where('status', '=', 1)->get();

        
        return view('admin::area.add', ['city_tags' => $city_tags, 'location_types' => $location_types, 'media_formats' => $media_formats, 'orientations' => $orientations, 'media_tags' => $media_tags, 'illuminations' => $illuminations, 'ad_spot_durations' => $ad_spot_durations, 'site_merits' => $site_merits]);
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
            'area_pic1' => 'required|mimes:png,jpg,jpeg|max:2048',
            //'nearby_places' => 'required|array|max:6',
        ]);

        
        if ($validator->passes()) {
            $area_pic1 = '';

            // finding city name and if not found then create city
            $states = State::where('is_deleted', '=', 0)
                            ->where('name', 'like', '%'.$request->input('state_name').'%')
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
                            ->where('name', 'like', '%'.$request->input('city_name').'%')
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
                $fileName2 = auth()->id() . '_' . time() . '.'. $request->area_pic2->extension();  
                $type2 = $request->area_pic2->getClientMimeType();
                $size2 = $request->area_pic2->getSize();
                $request->area_pic2->move(public_path('application_files/area_images'), $fileName2);
                $area_pic2 = $fileName2;
            }

            //checking for area videos
            $area_video = '';
            if($request->area_video) {
                // picture upload
                $fileName3 = auth()->id() . '_' . time() . '.'. $request->area_video->extension();  
                $type3 = $request->area_video->getClientMimeType();
                $size3 = $request->area_video->getSize();
                $request->area_video->move(public_path('application_files/area_videos'), $fileName3);
                $area_video = $fileName3;
            }

            // create area record
            $areas = Area::create([
                'title' => $request->input('area_name'),
                'site_location' => $request->input('site_location'),
                'road_name' => $request->input('road_name'),
                'pin_code' => $request->input('pin_code'),
                'lat' => $request->input('lat'),
                'lng' => $request->input('lng'),
                'state_id' => $state_id,
                'city_id' => $city_id,
                'city_tag' => $request->input('city_tag'),
                'face_traffic_from' => $request->input('face_traffic_from'),
                'place_type' => $request->input('place_type'),
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
            $super_admin_users = User::with(['role' => function($q) {
                $q->select('id');
                $q->where('role_id', '=', 'admin');
            }])                    
            ->get();
            foreach($super_admin_users as $super_admin_user) {
                $notifications = Notification::create([
                    'title' => 'A new area has been added',
                    'route' => 'admin.area_edit',
                    'object_id' => $areas->id,
                    'user_id' => $super_admin_user->id,
                    'is_read' => 0
                ]);
            }
        } else {
            $errors=$validator->errors();
            return redirect()->route('admin.area_add')->with('errors',$errors);
        }

        return redirect()->intended('admin/areas')->withSuccess('Area created successfully');
    }

    /**
     * Display Edit city template
     * @return Renderable
     */
    public function edit($id)
    {

        // updating nottifications
        Notification::where("object_id",$id)->where("is_read",0)->update(array('is_read' => 1));


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
            'Ambience' => 'Ambience',
        ];

        // Illumination assignment
        $illuminations = [
            'Frontlit' => 'Frontlit',
            'Backlit' => 'Backlit',
            'Digital' => 'Digital',
            'Nonlit' => 'Nonlit',
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
        
        return view('admin::area.edit', ['area_data' => $area_data, 'city_tags' => $city_tags, 'location_types' => $location_types, 'media_formats' => $media_formats, 'orientations' => $orientations, 'media_tags' => $media_tags, 'illuminations' => $illuminations, 'ad_spot_durations' => $ad_spot_durations, 'site_merits' => $site_merits, 'site_merits_values_assigned' => $site_merits_values_assigned]);
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
            'city_tag' => 'required'
        ]);

        
        if ($validator->passes()) {
            // finding city name and if not found then create city
            $states = State::where('is_deleted', '=', 0)
                            ->where('name', 'like', '%'.$request->input('state_name').'%')
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
                            ->where('name', 'like', '%'.$request->input('city_name').'%')
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
                $fileName2 = auth()->id() . '_' . time() . '.'. $request->area_pic2->extension();  
                $type2 = $request->area_pic2->getClientMimeType();
                $size2 = $request->area_pic2->getSize();
                $request->area_pic2->move(public_path('application_files/area_images'), $fileName2);
                $area_pic2 = $fileName2;
            }

            //checking for area videos
            $area_video = '';
            if($request->area_video) {
                // picture upload
                $fileName3 = auth()->id() . '_' . time() . '.'. $request->area_video->extension();  
                $type3 = $request->area_video->getClientMimeType();
                $size3 = $request->area_video->getSize();
                $request->area_video->move(public_path('application_files/area_videos'), $fileName3);
                $area_video = $fileName3;
            }

            $model->title = $request->input('area_name');
            $model->site_location = $request->input('site_location');
            $model->road_name = $request->input('road_name');
            $model->pin_code = $request->input('pin_code');
            $model->lat = $request->input('lat');
            $model->lng = $request->input('lng');
            $model->state_id = $state_id;
            $model->city_id = $city_id;
            $model->city_tag = $request->input('city_tag');
            $model->face_traffic_from = $request->input('face_traffic_from');
            $model->place_type = $request->input('place_type');
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
            if($area_pic1 != '') {
                $model->area_pic1 = $area_pic1;
            }
            if($area_pic2 != '') {
                $model->area_pic2 = $area_pic2;
            }
            if($area_video != '') {
                $model->area_video = $area_video;
            }
            $model->status = $request->input('status');

            // update user record
            $model->save();

            // fetching site merit values and assigning to area object
            $site_merits = SiteMerit::where('is_deleted', '=', 0)
                    ->where('status', '=', 1)->get();
            $site_merit_values = [];
            foreach($site_merits as $site_merit) {
                $site_merit_values[] = $request->input('site_merit_'.$site_merit->id);
            }
            $model->site_marit_values()->attach($site_merit_values);

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
}
