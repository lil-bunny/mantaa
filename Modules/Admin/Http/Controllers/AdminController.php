<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Hash;
use Session;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if(!Auth::check()){
            return view('admin::login');
        } else {
            return redirect()->intended('admin/dashboard')
                        ->withSuccess('Signed In');
        }
        return view('admin::login');
    }

    /**
     * Display a admin login page.
     * @return Renderable
     */
    public function login()
    {
        if(!Auth::check()){
            return view('admin::login');
        } else {
            return redirect()->intended('admin/dashboard')
                        ->withSuccess('Signed In');
        }
        
    }


    /**
     * Redirect to login page after logout.
     * @return Renderable
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->intended('admin/login')
                        ->withSuccess('Signed Out Successfully');
    }


    /**
     * Logged in the user.
     * @return Renderable
     */
    public function loginSubmit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $validator->after(function ($validator)use($request) {
            if($request->input('email')!="" && $request->input('password')!=""){
                $u= User::where('email', $request->input('email'))->where('status',1)->first();
                if (!empty($u)) {
                    if(Hash::check($request->input('password'), $u->password)==false){
                        $validator->errors()->add(
                            'email', 'Invalid password'
                        );
                    }

                    // checking for admin access
                    $role_data = Role::find($u->role_id);
                    if($role_data->admin_access != 1) {
                        $validator->errors()->add(
                            'email', 'The user is not authorised'
                        );
                    }
                }else{
                    $validator->errors()->add(
                        'email', 'User not found'
                    );
                }
            }
        });
        
        if ($validator->passes()) {
            // checks the authentications
            $credentials = $request->only('email', 'password');
            //Auth::guard('user')->attempt($credentials)
            if(Auth::attempt($credentials)) {
                return redirect()->intended('admin/dashboard')
                            ->withSuccess('Signed In');
            } else {
                $validator->errors()->add(
                    'email', 'Invalid credentials'
                );
                $errors=$validator->errors();
                return redirect()->route('admin.login')->with('errors',$errors);
            }
        } else {
            $errors=$validator->errors();
            return redirect()->route('admin.login')->with('errors',$errors);
        }
    }
}
