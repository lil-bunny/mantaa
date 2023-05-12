<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\Download;
use App\Models\Notification;
use App\Models\Area;
use App\Models\User;
use App\Models\City;
use App\Models\State;
use Validator;

class DownloadController extends Controller
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
        $downloads = Download::sortable()->where('downloads.is_deleted', '=', 0);
        
        // checks if search filters are set
        if($filters['user_id'] != '') {
            $downloads->where('downloads.user_id', '=', $filters['user_id']);
        }
        if($filters['area_id'] != '') {
            $downloads->where('downloads.area_id', '=', $filters['area_id']);
        }
        
        $downloads = $downloads->orderBy('id', 'desc')->paginate(10);
        
        // fetching areas
        $areas = Area::where('is_deleted', '=', 0)
                            ->where('status', '=', 1)->get();
        
        $users = User::where('is_deleted', '=', 0)
                            ->where('status', '=', 1)->get();

        return view('admin::download.index', ['downloads'=>$downloads, 'users'=>$users, 'areas' => $areas, 'filters' => $filters]);
    }


    

    

    /**
     * Display Edit city template
     * @return Renderable
     */
    public function view($id)
    {
        // fetching user details
        $download_data = Download::find($id);
        
        // fetching state data
        $state_data = State::find($download_data->area->state_id);

        // fetching city data
        $city_data = City::find($download_data->area->city_id);
                    
        return view('admin::download.view', ['download_data' => $download_data, 'state_data' => $state_data, 'city_data' => $city_data]);
    }


    


    /**
     * Soft delete city record
     * @return Renderable
     */
    public function download_delete(Request $request, $id)
    {
        // fetching the feedback data wrt id
        $model= Download::find($id);

        // creating city data updation object
        $model->is_deleted = 1;
        
        // update city record
        $model->save();

        return redirect()->intended('admin/downloads')->withSuccess('Download deleted successfully');
    }
}
