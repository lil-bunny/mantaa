<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\Setting;
use Validator;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        // fetching the settings data
        $settings_data = Setting::latest()->first();
        
        
        // assigning the dump options
        $send_dump_options = [
            'yes' => 'yes',
            'no' => 'no'
        ];
        
        return view('admin::setting.add', ['send_dump_options' => $send_dump_options, 'settings_data' => $settings_data]);
    }


    

    /**
     * Adds city record
     * @return Renderable
     */
    public function update_setting(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'send_site_dump' => 'required|max:255',
        ]);
        
        if ($validator->passes()) {
            // fetching the user data wrt id
            $model= Setting::latest()->first();

            // creating user data updation array
            $model->send_site_dump = $request->input('send_site_dump');
            $model->user_id = auth()->user()->id;

            // update user record
            $model->save();
        } else {
            $errors=$validator->errors();
            return redirect()->route('admin.setting')->with('errors',$errors);
        }

        return redirect()->intended('admin/settings')->withSuccess('Settings updated successfully');
    }

    


    
}
