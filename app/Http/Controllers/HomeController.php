<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Session;

class HomeController extends Controller
{
    /**
     * Display a home page component
     * @return Renderable
     */
    public function index()
    {
        return view('home.index');
    }

    /**
     * Displays login template
     * @return Renderable
     */
    public function login()
    {
        $prev_route = app('router')->getRoutes()->match(app('request')->create(url()->previous()))->getName();
        return view('home.login', ['prev_route' => $errors]);
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
                
                $errors=$validator->errors()->messages();
                return view('home.login', ['errors' => $errors]);
            }
        } else {
            $errors=$validator->errors()->messages();
            return view('home.login', ['errors' => $errors]);
        }
    }

    /**
     * Displays the registartion template
     * @return Renderable
     */
    public function register()
    {
        return view('home.register');
    }
}
