<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Area;
use App\Models\Feedback;
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
        //feedback
        $feedbacks = Feedback::where('is_deleted', '=', 0)
                    ->where('status', '=', 1)->orderBy('id', 'desc')->limit(3)->get();
        
        return view('area-details.index', compact('data', 'id'), ['feedbacks'=>$feedbacks]); 
    }

    public function autocompleteSearch(Request $request)
    {
        $query = $request->get('search');
        $res = [];
        
        // running the query for generating the result
        $filterResults = Area::select("title", "id", "site_location", "city_id")
                                ->where('site_location', 'LIKE', '%'. $query. '%')
                                ->orWhere('title', 'LIKE', '%'. $query. '%')
                                ->limit(5)->get();
        
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
        $area_id = 16309;
        $city_id = $request->get('city_id');
        $res = [];
        
        // // running the query for generating the result
        // $filterResults = Area::select("title", "id", "site_location", "city_id")
        //                         ->where('site_location', 'LIKE', '%'. $query. '%')
        //                         ->orWhere('title', 'LIKE', '%'. $query. '%')
        //                         ->limit(5)->get();
        
        // // preparing the results
        // foreach($filterResults as $filterResult) {
        //     $res[] = [
        //         'value' => $filterResult->title.','.$filterResult->site_location,
        //         'id' => $filterResult->id,
        //         'city_id' => $filterResult->city_id,
        //     ];
        // }

        $data = Area::where('is_deleted', '=', 0)
                    ->where('status', '=', 1)
                    ->where('id', '=', $area_id)
                    ->orWhere('title', 'LIKE', '%Andheri%')
                    ->orderByRaw("CASE WHEN id = ".$area_id." THEN 0 ELSE 1 END, id")
                    ->limit(8)->get();
        
        return view('area-details.area_search', ['area_lists' => $data]);
    }
}
