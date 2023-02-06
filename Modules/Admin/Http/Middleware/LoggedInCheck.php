<?php

namespace Modules\Admin\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Models\Menu;
use App\Models\Role;

class LoggedInCheck
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

            // checking user has the admin access or not
            $role_data = Role::find($user->role_id);
            if($role_data->admin_access != 1) {
                return redirect()->route('frontend.home'); 
            }

            View::share('menus_sidebar', $role_data->menus);
            return $next($request);
        } else {
            return redirect()->route('admin.login');
        }
        
    }
}
