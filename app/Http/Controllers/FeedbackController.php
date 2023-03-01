<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Feedback;
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

            Feedback::create([
                'user_id' => $user->id,
                'area_id' => $id,
                'feedback' => $request->input('feedback'),
                'status' => 0,
            ]);
        
            return redirect()->route('area-details', $id);
        } else {
            $errors=$validator->errors();
            return redirect()->route('area-details', $id)->with('errors',$errors);
        }
    }
}
