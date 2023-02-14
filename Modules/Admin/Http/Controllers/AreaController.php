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
        $areas = $areas->paginate(10);

        //echo "<pre>";print_r($areas->toArray());exit;
        
        return view('admin::area.index', ['areas'=>$areas, 'filters' => $filters]);
    }


    /**
     * Display Add city template
     * @return Renderable
     */
    public function add()
    {
        // fetching states
        $states = State::where('is_deleted', '=', 0)
                            ->where('status', '=', 1)->get();
        
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

        // fetching cities
        $cities = City::where('is_deleted', '=', 0)
                            ->where('status', '=', 1)->get();

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

        return view('admin::area.add', ['states' => $states, 'cities' => $cities, 'city_tags' => $city_tags, 'location_types' => $location_types, 'media_formats' => $media_formats, 'orientations' => $orientations, 'media_tags' => $media_tags, 'illuminations' => $illuminations, 'ad_spot_durations' => $ad_spot_durations]);
    }

    /**
     * Adds city record
     * @return Renderable
     */
    public function create_area(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:cities|max:255',
            'route' => 'required|max:255',
        ]);
        
        if ($validator->passes()) {
            // create user record
            Area::create([
                'title' => $request->input('name'),
                'route' => $request->input('route'),
                'status' => $request->input('status'),
            ]);
        } else {
            $errors=$validator->errors();
            return redirect()->route('admin::area_add')->with('errors',$errors);
        }

        return redirect()->intended('admin/areas')->withSuccess('Area created successfully');
    }

    /**
     * Display Edit city template
     * @return Renderable
     */
    public function edit($id)
    {
        // fetching user details
        $area_data = Area::find($id);
                    
        return view('admin::area.edit', ['area_data' => $area_data]);
    }


    /**
     * Updates city record
     * @return Renderable
     */
    public function update_area(Request $request, $id)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'route' => 'required|max:255',
        ]);

        
        if ($validator->passes()) {
            // fetching the city data wrt id
            $model= Area::find($id);

            // creating city data updation array
            $model->title = $request->input('name');
            $model->route = $request->input('route');
            $model->status = $request->input('status');

            // update user record
            $model->save();

            return redirect()->intended('admin/areas')->withSuccess('Area updated successfully');
        } else {
            $errors=$validator->errors();
            return redirect()->route('admin::area_edit', ['id' => $id])->with('errors',$errors);
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
