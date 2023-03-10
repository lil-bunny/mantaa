<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Area;
use App\Models\ConnectRequest;
use Session;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        // fetching the user count
        $active_user_count = User::where('is_deleted', '=', 0)
                            ->where('status', '=', 1)->count();
        $total_user_count = User::where('is_deleted', '=', 0)->count();
        

        // fetching area counts
        $active_area_count = Area::where('is_deleted', '=', 0)
                            ->where('status', '=', 1)->count();
        $total_area_count = Area::where('is_deleted', '=', 0)->count();

        // fetching connect requests count
        $connect_request_count = ConnectRequest::where('is_deleted', '=', 0)->count();

        // fetch area data
        $area_data = Area::where('is_deleted', '=', 0)
                    ->where('status', '=', 1)
                    ->orderBy('id', 'desc')->limit(10)->get();
        
        return view('admin::dashboard.index', ['area_data'=>$area_data, 'active_user_count'=>$active_user_count, 'total_user_count'=>$total_user_count, 'active_area_count' => $active_area_count, 'total_area_count' => $total_area_count, 'connect_request_count' => $connect_request_count]);
    }
}
