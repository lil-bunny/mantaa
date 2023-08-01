<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use DB; 
use Carbon\Carbon; 
use App\Models\User; 
use App\Models\PasswordReset;
use Mail; 
use Hash;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /**
       * Write code on Method
       *
       * @return response()
       */
      public function showForgetPasswordForm()
      {
         return view('home.forgot-password');
      }
  
      /**
       * Write code on Method
       *
       * @return response()
       */
      
    public function submitForgetPasswordForm(Request $request) {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);
  
        $token = Str::random(64);
  
        $password_obj = PasswordReset::create([
            'email' => $request->email, 
            'token' => $token, 
            'created_at' => Carbon::now()
        ]);
  
        if(env('APP_ENV') != 'local') {
            Mail::send('email.forgetPassword', ['token' => $token], function($message) use($request){
                $message->to($request->email);
                $message->subject('Reset Password');
            });
            return back()->with('message', 'We have e-mailed your password reset link!');
        } else {
            return view('email.forgetPassword', ['token' => $token]);
        }
    }

    /**
       * Write code on Method
       *
       * @return response()
       */
    public function showResetPasswordForm($token) { 
        return view('email.forgetPasswordLink', ['token' => $token]);
    }

    /**
       * Write code on Method
       *
       * @return response()
       */
    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        $updatePassword = PasswordReset::where('token', $request->token)
                            ->first();
        
        if(!$updatePassword){
            return back()->withInput()->with('error', 'Invalid token!');
        }

        // finding the user object
        $userObj = User::where('email', $updatePassword->email)->first();
        

        $user = User::where('email', $updatePassword->email)
                    ->update(['password' => Hash::make($request->password)]);

        PasswordReset::where(['email'=> $updatePassword->email])->delete();

        if($userObj->role->role_id == 'admin') {
            return redirect('/admin/login')->with('message', 'Your password has been changed!');
        } else {
            return redirect('/login')->with('message', 'Your password has been changed!');
        }
    }
      
}
