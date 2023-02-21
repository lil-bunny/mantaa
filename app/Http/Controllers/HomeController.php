<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;
use App\Models\City;
use App\Models\Area;
use App\Models\Notification;
use Session;
use Validator;
use Hash;


class HomeController extends Controller
{
    /**
     * Display a home page component
     * 
     * @return Renderable
     */
    public function index(Request $request)
    {
        // fetching city lists
        $cities = City::where('is_deleted', '=', 0)
                    ->where('status', '=', 1)->orderBy('id', 'desc')->get();
        $areas = Area::where('is_deleted', '=', 0)
                    ->where('status', '=', 1)->orderBy('id', 'desc')->limit(8)->get();
        
        return view('home.index', ['cities'=>$cities, 'areas'=>$areas]);
    }

    /**
     * Displays login template
     * @return Renderable
     */
    public function login()
    {
        $prev_route = app('router')->getRoutes()->match(app('request')->create(url()->previous()))->getName();
        return view('home.login', ['prev_route' => $prev_route]);
    }

    /**
     * Logged in the user
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
                $u= User::where('email', $request->input('email'))->where('status',1)->where('is_deleted',0)->first();
                if (!empty($u)) {
                    if(Hash::check($request->input('password'), $u->password)==false){
                        $validator->errors()->add(
                            'email', 'User not found'
                        );
                    }
                } else { 
                    $validator->errors()->add(
                        'email', 'User not found'
                    );
                }
            }
        });
        
        if ($validator->passes()) {
            // checks the authentications
            $credentials = $request->only('email', 'password');
            
            // checking auth attempts and redirects to previous route if getting success
            if(Auth::attempt($credentials)) {
                return redirect()->route($request->input('prev_route'));
            } else {
                $validator->errors()->add(
                    'email', 'Invalid Credentials'
                );
                
                $errors=$validator->errors();
                return redirect()->route('home.login')->with('errors',$errors);
            }
        } else {
            $errors=$validator->errors();
            return redirect()->route('home.login')->with('errors',$errors);
        }
    }

    /**
     * Displays the registration template
     * @return Renderable
     */
    public function register()
    {
        return view('home.register');
    }

    /**
     * Create user
     * @return Renderable
     */
    public function registerSubmit(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users|max:255',
            'name' => 'required',
            'mobile' => 'required',
            'password' => 'required',
        ]);

        if ($validator->passes()) {
            // fetching roles for customer
            $roles = Role::where('is_deleted', '=', 0)
                            ->where('status', '=', 1)
                            ->where('role_id', '=', 'customer')
                            ->get();
            foreach($roles as $role) {
                $role_id = $role->id;
            }
            
            // create user record
            $user_obj = User::create([
                'full_name' => $request->input('name'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile'),
                'password' => bcrypt($request->input('password')),
                'role_id' => $role_id,
                'status' => 1,
            ]);

            $super_admin_users = User::with(['role' => function($q) {
                $q->select('id');
                $q->where('role_id', '=', 'admin');
            }])                    
            ->get();
            foreach($super_admin_users as $super_admin_user) {
                $notifications = Notification::create([
                    'title' => 'A new user has been registered',
                    'route' => 'admin.user_edit',
                    'object_id' => $user_obj->id,
                    'user_id' => $super_admin_user->id,
                    'is_read' => 0
                ]);
            }

            return redirect('/register');
        } else {
            $errors=$validator->errors();
            return redirect()->route('frontend.register')->with('errors',$errors);
        }
    }

    /**
     * Redirect to home page after logout.
     * @return Renderable
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('frontend.home');
    }
}
