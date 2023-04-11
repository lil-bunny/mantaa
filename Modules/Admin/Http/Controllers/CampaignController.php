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

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $filters = [
            'city_id' => $request->query('city_id'),
            'income_group' => $request->query('income_group'),
        ];

        // fetching city lists
        if($filters['city_id'] != '' || $filters['income_group'] != '') {
            $areas = Area::sortable()->where('areas.is_deleted', '=', 0)->where('areas.status', '=', 1);    
        } else {
            $areas = false;
        }
        
        
        // checks if search filters are set
        if($filters['city_id'] != '') {
            $areas->where('areas.city_id', '=', $filters['city_id']);
        }
        if($filters['income_group'] != '') {
            $areas->where('areas.income_group', '=', $filters['income_group']);
        }
        if($filters['city_id'] != '' || $filters['income_group'] != '') {
            $areas = $areas->orderBy('id', 'DESC')->get();
        }

        // fetching city lists
        $cities = City::where('is_deleted', '=', 0)
                            ->where('status', '=', 1)->get();

        // assigning income group array
        $income_groups = ['LIG', 'MIG', 'HIG'];
        
        return view('admin::campaign.index', ['areas'=>$areas, 'filters' => $filters, 'cities' => $cities, 'income_groups' => $income_groups]);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function review_campaign(Request $request)
    {
        // assigning the input value to the variables
        $area_ids = $request->input('area_selected');
        
        // checking if area ids selected or not
        if(count($area_ids) > 0) {
            $areas = Area::where('areas.is_deleted', '=', 0)->where('areas.status', '=', 1)->whereIn('areas.id', $area_ids)->get();
            return view('admin::campaign.review_campaign', ['areas'=>$areas, 'area_ids'=>json_encode($area_ids)]);
        } else {
            return redirect()->route('admin.campaign_search');
        }
    }
}
