<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\City;
use App\Models\State;
use Validator;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $filters = [
            'city_name' => $request->query('city_name'),
            'state_id' => $request->query('state_id'),
            'status' => $request->query('status'),
        ];

        // fetching city lists
        $cities = City::sortable()->where('cities.is_deleted', '=', 0);
        
        // checks if search filters are set
        if($filters['city_name'] != '') {
            $cities->where('cities.name', 'like', '%'.$filters['city_name'].'%');
        }
        if($filters['state_id'] != '') {
            $cities->where('cities.state_id', '=', $filters['state_id']);
        }
        if($filters['status'] != '') {
            $cities->where('cities.status', '=', $filters['status']);
        }
        $cities = $cities->paginate(5);
        
        // fetching states
        $states = State::where('is_deleted', '=', 0)
                            ->where('status', '=', 1)->get();
        
        return view('admin::city.index', ['cities'=>$cities, 'states' => $states, 'filters' => $filters]);
    }


    /**
     * Display Add city template
     * @return Renderable
     */
    public function add()
    {
        // fetching roles
        $states = State::where('is_deleted', '=', 0)
                            ->where('status', '=', 1)->get();
        
        return view('admin::city.add', ['states' => $states]);
    }

    /**
     * Adds city record
     * @return Renderable
     */
    public function create_city(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:cities|max:255',
            'state_id' => 'required',
            'city_pic' => 'required|mimes:png,jpg,jpeg|max:2048'
        ]);
        
        if ($validator->passes()) {
            // picture upload
            $fileName = auth()->id() . '_' . time() . '.'. $request->city_pic->extension();  
            $type = $request->city_pic->getClientMimeType();
            $size = $request->city_pic->getSize();
            $request->city_pic->move(public_path('/images/city'), $fileName);
            
            // create user record
            City::create([
                'name' => $request->input('name'),
                'state_id' => $request->input('state_id'),
                'status' => $request->input('status'),
                'image' => $fileName
            ]);
        } else {
            // fetching roles
            $states = State::where('is_deleted', '=', 0)
                            ->where('status', '=', 1)->get();

            $errors=$validator->errors();
            return redirect()->route('admin.city_add')->with('errors',$errors)->with('states',$states);
        }
        return redirect()->intended('admin/cities')->withSuccess('City created successfully');
    }

    /**
     * Display Edit city template
     * @return Renderable
     */
    public function edit($id)
    {
        // fetching roles
        $states = State::where('is_deleted', '=', 0)
                            ->where('status', '=', 1)->get();
        
        // fetching user details
        $city_data = City::find($id);
                    
        return view('admin::city.edit', ['states' => $states, 'city_data' => $city_data]);
    }


    /**
     * Updates city record
     * @return Renderable
     */
    public function update_city(Request $request, $id)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'state_id' => 'required',
        ]);

        // fetching roles
        $states = State::where('is_deleted', '=', 0)
                            ->where('status', '=', 1)->get();
        
        if ($validator->passes()) {
            // fetching the city data wrt id
            $model= City::find($id);

            // creating city data updation array
            $model->state_id = $request->input('state_id');
            $model->name = $request->input('name');
            $model->status = $request->input('status');

            // checking if profile pic is uploaded or not
            if($request->city_pic) {
                // picture upload
                $fileName = auth()->id() . '_' . time() . '.'. $request->city_pic->extension();  
                $type = $request->city_pic->getClientMimeType();
                $size = $request->city_pic->getSize();
                $request->city_pic->move(public_path('/images/city'), $fileName);
                $model->image = $fileName;
            }

            // update user record
            $model->save();

            return redirect()->intended('admin/cities')->withSuccess('City updated successfully');
        } else {
            // fetching states
            $states = State::where('is_deleted', '=', 0)
                            ->where('status', '=', 1)->get();

            $errors=$validator->errors();
            return redirect()->route('admin.city_edit', ['id' => $id])->with('errors',$errors);
        }
    }


    /**
     * Soft delete city record
     * @return Renderable
     */
    public function city_delete(Request $request, $id)
    {
        // fetching the city data wrt id
        $model= City::find($id);

        // creating city data updation object
        $model->is_deleted = 1;
        
        // update city record
        $model->save();

        return redirect()->intended('admin/cities')->withSuccess('City deleted successfully');
    }
}
