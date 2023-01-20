<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function __construct() {
        /*User::create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'admin@mantaray.com',
            'mobile' => '9831757876',
            'image' => 'demo.jpeg',
            'password' => Hash::make('admin@123'),
            'role_id' => 1,
            'status' => 1
        ]);*/
    }

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
                            'email', 'User not found'
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
                // redirect to the login page if the users credentials are not valid
                return redirect()->intended('admin/login')
                ->withError('Login details are not valid');
            }
        } else {
            $errors=$validator->errors()->messages();
            Session::flash('error', $errors);
            // redirect to the login page if the users credentials are not valid
            return redirect()->intended('admin/login')
            ->withError('Login details are not valid');
        }
    }
}
