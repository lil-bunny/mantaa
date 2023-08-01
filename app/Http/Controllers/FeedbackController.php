<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Feedback;
use App\Models\User;
use App\Models\Notification;
use Validator;

class FeedbackController extends Controller
{
    public function feedbackSubmit(Request $request, $id)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'feedback' => 'required'
        ]);
        
        // create feedback record
        if ($validator->passes()) {
        
            $user = Auth::user();

            $feedbackObj = Feedback::create([
                'user_id' => $user->id,
                'area_id' => $id,
                'feedback' => $request->input('feedback'),
                'status' => 0,
            ]);

            // adding notification
            $super_admin_users = User::with('role')
            ->whereRelation('role', 'role_id', '=', 'admin')
            ->get();
            foreach($super_admin_users as $super_admin_user) {
                $notifications = Notification::create([
                    'title' => 'A new feedback has been given',
                    'route' => 'admin.feedback_edit',
                    'object_id' => $feedbackObj->id,
                    'user_id' => $super_admin_user->id,
                    'type' => 'feedback',
                    'is_read' => 0
                ]);
            }
        
            $success = 'We appreciate your feedback. Our team will verify the information and make the necessary changes, if applicable. You can come back later and check the review section with your message once the information is updated.';
            return redirect()->route('area-details', $id)->with('message', $success);
        } else {
            $errors=$validator->errors();
            return redirect()->route('area-details', $id)->with('errors',$errors);
        }
    }
}
