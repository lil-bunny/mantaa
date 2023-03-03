<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\Feedback;
use App\Models\Area;
use App\Models\User;
use Validator;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $filters = [
            'user_id' => $request->query('user_id'),
            'area_id' => $request->query('area_id'),
            'status' => $request->query('status'),
        ];

        // fetching city lists
        $feedbacks = Feedback::sortable()->where('feedbacks.is_deleted', '=', 0);
        
        // checks if search filters are set
        if($filters['user_id'] != '') {
            $feedbacks->where('feedbacks.name', 'like', '%'.$filters['user_id'].'%');
        }
        if($filters['area_id'] != '') {
            $feedbacks->where('feedbacks.area_id', '=', $filters['area_id']);
        }
        if($filters['status'] != '') {
            $feedbacks->where('feedbacks.status', '=', $filters['status']);
        }
        $feedbacks = $feedbacks->orderBy('id', 'desc')->paginate(10);
        
        // fetching areas
        $areas = Area::where('is_deleted', '=', 0)
                            ->where('status', '=', 1)->get();
        
        $users = User::where('is_deleted', '=', 0)
                            ->where('status', '=', 1)->get();

        return view('admin::feedback.index', ['feedbacks'=>$feedbacks, 'users'=>$users, 'areas' => $areas, 'filters' => $filters]);
    }


    

    

    /**
     * Display Edit city template
     * @return Renderable
     */
    public function edit($id)
    {
        // updating nottifications
        Notification::where("object_id",$id)->where("is_read",0)->where("type", "feedback")->update(array('is_read' => 1));
        
        // fetching user details
        $feedback_data = Feedback::find($id);
                    
        return view('admin::feedback.edit', ['feedback_data' => $feedback_data]);
    }


    /**
     * Updates city record
     * @return Renderable
     */
    public function update_feedback(Request $request, $id)
    {        
            // fetching the city data wrt id
            $model= Feedback::find($id);

            // updating status
            $model->status = $request->input('status');

            // update user record
            $model->save();
            return redirect()->intended('admin/feedbacks')->withSuccess('Feedback approved successfully');
    }


    /**
     * Soft delete city record
     * @return Renderable
     */
    public function feedback_delete(Request $request, $id)
    {
        // fetching the feedback data wrt id
        $model= Feedback::find($id);

        // creating city data updation object
        $model->is_deleted = 1;
        
        // update city record
        $model->save();

        return redirect()->intended('admin/feedbacks')->withSuccess('Feedback deleted successfully');
    }
}
