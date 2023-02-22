<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;

class CustomerLoggedInCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check()) {
            $user = Auth::user();

            View::share('user_name', $user->full_name);
            return $next($request);
        } else {
            //echo url()->full();;exit;
            //View::share('prev_route', url()->full());
            //view()->share('prev_route', url()->full());
            //return redirect()->route('frontend.login')->with('test', 'test');
            //return redirect()->route('frontend.login');
            return response(view('home.login', ['prev_route' => url()->full()]));
            //return view('home.login');
        }
        
    }
}
