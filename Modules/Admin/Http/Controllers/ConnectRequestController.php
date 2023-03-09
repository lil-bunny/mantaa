<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\ConnectRequest;
use App\Models\Notification;
use App\Models\Area;
use App\Models\User;
use Validator;

class ConnectRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $filters = [
            'user_id' => $request->query('user_id'),
            'area_id' => $request->query('area_id')
        ];

        // fetching city lists
        $connect_requests = ConnectRequest::sortable()->where('connect_requests.is_deleted', '=', 0);
        
        // checks if search filters are set
        if($filters['user_id'] != '') {
            $connect_requests->where('connect_requests.user_id', '=', $filters['user_id']);
        }
        if($filters['area_id'] != '') {
            $connect_requests->where('connect_requests.area_id', '=', $filters['area_id']);
        }
        
        $connect_requests = $connect_requests->orderBy('id', 'desc')->paginate(10);
        
        // fetching areas
        $areas = Area::where('is_deleted', '=', 0)
                            ->where('status', '=', 1)->get();
        
        $users = User::where('is_deleted', '=', 0)
                            ->where('status', '=', 1)->get();

        return view('admin::connect_request.index', ['connect_requests'=>$connect_requests, 'users'=>$users, 'areas' => $areas, 'filters' => $filters]);
    }


    

    

    /**
     * Display Edit city template
     * @return Renderable
     */
    public function view($id)
    {
        // updating nottifications
        Notification::where("object_id",$id)->where("is_read",0)->where("type", "connect_request")->update(array('is_read' => 1));
        
        // fetching user details
        $connect_request_data = ConnectRequest::find($id);
                    
        return view('admin::connect_request.view', ['connect_request_data' => $connect_request_data]);
    }


    


    /**
     * Soft delete city record
     * @return Renderable
     */
    public function connect_request_delete(Request $request, $id)
    {
        // fetching the feedback data wrt id
        $model= ConnectRequest::find($id);

        // creating city data updation object
        $model->is_deleted = 1;
        
        // update city record
        $model->save();

        return redirect()->intended('admin/connect_requests')->withSuccess('Connect Request deleted successfully');
    }
}
