<?php

namespace Modules\Admin\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Models\Menu;
use App\Models\Role;
use App\Models\Notification;

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
            echo "<pre>"; print_r($user);
            // checking user has the admin access or not
            $role_data = Role::find($user->role_id);
            if($role_data->admin_access != 1) {
                return redirect()->route('frontend.home'); 
            }

            // fetching user informations
            $notification_count_unread = 0;
            $notifications = Notification::where('user_id', '=', $user->id)
                            ->orderBy('id', 'desc')
                            ->get();
            foreach($notifications as $notification) {
                if($notification->is_read == 0) {
                    $notification_count_unread++;
                }
            }

            View::share('menus_sidebar', $role_data->menus);
            View::share('notifications', $notifications);
            View::share('notification_count_unread', $notification_count_unread);
            View::share('user_name', $user->full_name);
            return $next($request);
        } else {
            return redirect()->route('admin.login');
        }
        
    }
}
