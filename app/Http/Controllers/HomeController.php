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
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Redirect;


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
        return view('home.login');
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
                            'email', 'Invalid Password'
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
            // assigning previous route if exists
            if($request->input('prev_route')) {
                $prev_route = $request->input('prev_route');
            } else {
                $prev_route = '';
            }

            // checks the authentications
            $credentials = $request->only('email', 'password');
            
            // checking auth attempts and redirects to previous route if getting success
            if(Auth::attempt($credentials)) {
                if($request->input('prev_route')) {
                    return redirect()->to($prev_route);
                } else {
                    return redirect()->route('frontend.home');
                }
            } else {
                $validator->errors()->add(
                    'email', 'Invalid Credentials'
                );
                
                $errors=$validator->errors();
                return redirect()->route('frontend.login')->with('errors',$errors)->with('prev_route',$prev_route);
            }
        } else {
            // assigning previous route if exists
            if($request->input('prev_route')) {
                $prev_route = $request->input('prev_route');
            } else {
                $prev_route = '';
            }

            $errors=$validator->errors();
            return redirect()->route('frontend.login')->with('errors',$errors)->with('prev_route',$prev_route);
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
                    'type' => 'user',
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

    /**
     * Display Edit user template
     * @return Renderable
     */
    public function edit()
    {
        // fetching roles
        $id = auth()->user()->id;
        
        
        $roles = Role::where('is_deleted', '=', 0)
                            ->where('status', '=', 1)->get();
        
        $user_data = User::find($id);
                    
        return view('user.edit-user', ['roles' => $roles, 'user_data' => $user_data]);
    }

    public function update_user(Request $request)
    {
        $password = $request->input('password');
        $password_confirm = $request->input('cnf_password');
        
        // Validation
        if($password || $password_confirm){
            $validator = Validator::make($request->all(), [
                'email' => 'required|max:255',
                'name' => 'required',
                'mobile' => 'required',
                'password' => 'required|string|min:6|confirmed',
                'confirm password' => 'required'
            ]);
        }else{
            $validator = Validator::make($request->all(), [
                'email' => 'required|max:255',
                'name' => 'required',
                'mobile' => 'required'
            ]);
        }

        // fetching roles
        $roles = Role::where('is_deleted', '=', 0)
                            ->where('status', '=', 1)->get();

        $id = auth()->user()->id;

        if($validator->passes()) {        
            $model= User::find($id);
            
            // creating user data updation array
            $model->full_name = $request->input('name');
            $model->email = $request->input('email');
            $model->mobile = $request->input('mobile');

            // checking if profile pic is uploaded or not
            if($request->profile_pic) {
                // picture upload
                $fileName = auth()->id() . '_' . time() . '.'. $request->profile_pic->extension();  
                $type = $request->profile_pic->getClientMimeType();
                $size = $request->profile_pic->getSize();
                $request->profile_pic->move(public_path('application_files/user_images'), $fileName);
                $model->image = $fileName;
            }

            // checking if password is set or not
            if($request->input('password')) {
                $model->password = bcrypt($request->input('password'));
            }
            
            $model->save();
            return redirect()->intended('/')->withSuccess('User updated successfully');
        }
        else{
            // fetching roles
            $roles = Role::where('is_deleted', '=', 0)
                            ->where('status', '=', 1)->get();

            $errors=$validator->errors();
            return redirect()->route('frontend.user_edit')->with('errors',$errors)->with('roles',$roles);
        }
    }
}
