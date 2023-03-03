<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use App\Models\Role;
use App\Models\Notification;
use Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $filters = [
            'user_name' => $request->query('user_name'),
            'role_id' => $request->query('role_id'),
            'status' => $request->query('status'),
        ];

        // fetching user lists
        $users = User::sortable()->where('users.is_deleted', '=', 0);
        
        // checks if search filters are set
        if($filters['user_name'] != '') {
            $users->where('users.name', 'like', '%'.$filters['user_name'].'%');
        }
        if($filters['role_id'] != '') {
            $users->where('users.role_id', '=', $filters['role_id']);
        }
        if($filters['status'] != '') {
            $users->where('users.status', '=', $filters['status']);
        }
        $users = $users->paginate(5);
        

        // fetching roles
        $roles = Role::where('is_deleted', '=', 0)
                            ->where('status', '=', 1)->get();
        
        return view('admin::user.index', ['users'=>$users, 'roles' => $roles, 'filters' => $filters]);
    }


    /**
     * Display Add user template
     * @return Renderable
     */
    public function add()
    {
        // fetching roles
        $roles = Role::where('is_deleted', '=', 0)
                            ->where('status', '=', 1)->get();
        
        return view('admin::user.add', ['roles' => $roles]);
    }

    /**
     * Adds user record
     * @return Renderable
     */
    public function create_user(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users|max:255',
            'name' => 'required',
            'mobile' => 'required',
            'password' => 'required',
            'profile_pic' => 'required|mimes:png,jpg,jpeg|max:2048',
        ]);
        
        if ($validator->passes()) {
            // picture upload
            $fileName = auth()->id() . '_' . time() . '.'. $request->profile_pic->extension();  
            $type = $request->profile_pic->getClientMimeType();
            $size = $request->profile_pic->getSize();
            $request->profile_pic->move(public_path('application_files/user_images'), $fileName);
            
            // create user record
            User::create([
                'full_name' => $request->input('name'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile'),
                'image' => $fileName,
                'password' => bcrypt($request->input('password')),
                'role_id' => $request->input('role_id'),
                'status' => $request->input('status'),
            ]);

            return redirect()->route('admin.user');
        } else {
            // fetching roles
            $roles = Role::where('is_deleted', '=', 0)
                            ->where('status', '=', 1)->get();

            $errors=$validator->errors();
            // return redirect()->route('admin::user_add')->with('errors',$errors)->with('roles',$roles);
            return redirect()->route('admin.user_add')->with('errors',$errors)->with('roles',$roles);
        }

        return redirect()->intended('admin/users')->withSuccess('User created successfully');
    }

    /**
     * Display Edit user template
     * @return Renderable
     */
    public function edit($id)
    {
        // updating nottifications
        Notification::where("object_id",$id)->where("is_read",0)->where("type","user")->update(array('is_read' => 1));

        // fetching roles
        $roles = Role::where('is_deleted', '=', 0)
                            ->where('status', '=', 1)->get();
        
        // fetching user details
        $user_data = User::find($id);
                    
        return view('admin::user.edit', ['roles' => $roles, 'user_data' => $user_data]);
    }


    /**
     * Updates user record
     * @return Renderable
     */
    public function update_user(Request $request, $id)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'email' => 'required|max:255',
            'name' => 'required',
            'mobile' => 'required',
        ]);

        // fetching roles
        $roles = Role::where('is_deleted', '=', 0)
                            ->where('status', '=', 1)->get();
        
        if ($validator->passes()) {
            // fetching the user data wrt id
            $model= User::find($id);

            // creating user data updation array
            $model->full_name = $request->input('name');
            $model->email = $request->input('email');
            $model->mobile = $request->input('mobile');
            $model->role_id = $request->input('role_id');
            $model->status = $request->input('status');

            
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

            // update user record
            $model->save();

            return redirect()->intended('admin/users')->withSuccess('User updated successfully');
        } else {
            // fetching roles
            $roles = Role::where('is_deleted', '=', 0)
                            ->where('status', '=', 1)->get();

            $errors=$validator->errors();
            return redirect()->route('admin.user_edit', ['id' => $id])->with('errors',$errors)->with('roles',$roles);
        }
    }


    /**
     * Soft delete user record
     * @return Renderable
     */
    public function user_delete(Request $request, $id)
    {
        // fetching the user data wrt id
        $model= User::find($id);

        // creating user data updation object
        $model->is_deleted = 1;
        
        // update user record
        $model->save();

        return redirect()->intended('admin/users')->withSuccess('User deleted successfully');
    }
}
