<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    
    public function loginWithGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callbackFromGoogle()
    {
        try {
            $user = Socialite::driver('google')->user();
            
            $is_user = User::where('email', $user->getEmail())->first();

            // fetching roles for customer
            $roles = Role::where('is_deleted', '=', 0)
                            ->where('status', '=', 1)
                            ->where('role_id', '=', 'customer')
                            ->get();
            foreach($roles as $role) {
                $role_id = $role->id;
            }
            
            if(!$is_user){
                $saveUser = User::updateOrCreate([
                    'google_id' => $user->getId(),
                ],[
                    'full_name' => $user->getName(),
                    'email' => $user->getEmail(),
                    'password' => Hash::make($user->getName().'@'.$user->getId()),
                    'role_id' => $role_id
                ]);
            }else{
                $saveUser = User::where('email',  $user->getEmail())->update([
                    'google_id' => $user->getId(),
                ]);
                $saveUser = User::where('email', $user->getEmail())->first();
            }

            Auth::loginUsingId($saveUser->id);

            return redirect()->route('frontend.home');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
