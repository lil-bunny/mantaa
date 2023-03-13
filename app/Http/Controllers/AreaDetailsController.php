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

        //feedback
        $feedbacks = Feedback::where('is_deleted', '=', 0)
                    ->where('status', '=', 1)
                    ->where('area_id', '=', $id)
                    ->orderBy('id', 'desc')->limit(3)->get();
        
        return view('area-details.index', compact('data', 'id'), ['feedbacks' => $feedbacks, 'site_merits_arr' => $site_merits_arr]); 
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
        $min_price = [1000000, 2000000, 3000000, 4000000, 5000000];
        $max_price = [6000000, 7000000, 8000000, 9000000, 10000000];
        
        if ($request->ajax()) {
            $view = view('area-details.area_search_ajax', ['area_lists_ajax' => $data])->render();
            return response()->json(['html'=>$view]);
        }
        
        return view('area-details.area_search', ['area_lists' => $data, 'filters' => $filters, 'media_formats' => $media_formats, 'min_price' => $min_price, 'max_price' => $max_price]);
    }

    public function connect_request(Request $request)
    {
         
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
                'title' => 'A new connect request has been raised',
                'route' => 'admin.connect_request_view',
                'object_id' => $save->id,
                'user_id' => $super_admin_user->id,
                'type' => 'connect_request',
                'is_read' => 0
            ]);
        }
 
        return response()->json(['status'=>'200']);
    }
}
