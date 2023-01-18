<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Role;
use Validator;
use Session;

class RoleController extends Controller
{
        /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $filters = [
            'role_title' => $request->query('role_title'),
            'status' => $request->query('status'),
        ];

        // fetching user lists
        $roles = Role::sortable()->where('roles.is_deleted', '=', 0);
        
        // checks if search filters are set
        if($filters['role_title'] != '') {
            $roles->where('roles.title', 'like', '%'.$filters['role_title'].'%');
        }
        if($filters['status'] != '') {
            $roles->where('roles.status', '=', $filters['status']);
        }
        $roles = $roles->paginate(5);
        
        return view('admin::role.index', ['roles'=>$roles, 'filters' => $filters]);
    }


    /**
     * Display Add role template
     * @return Renderable
     */
    public function add()
    {
        return view('admin::role.add');
    }

    /**
     * Adds role record
     * @return Renderable
     */
    public function create_role(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:roles|max:255',
        ]);
        
        if ($validator->passes()) {
            // create user record
            Role::create([
                'title' => $request->input('title'),
                'status' => $request->input('status'),
            ]);
        } else {
            $errors=$validator->errors()->messages();
            return view('admin::role.add');
        }

        return redirect()->intended('admin/roles')->withSuccess('Role created successfully');
    }

    /**
     * Display Edit role template
     * @return Renderable
     */
    public function edit($id)
    {
        // fetching user details
        $role_data = Role::find($id);
                    
        return view('admin::role.edit', ['role_data' => $role_data]);
    }


    /**
     * Updates role record
     * @return Renderable
     */
    public function update_role(Request $request, $id)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'title' => 'required'
        ]);

        if ($validator->passes()) {
            // fetching the user data wrt id
            $model= Role::find($id);

            // creating user data updation array
            $model->title = $request->input('title');
            $model->status = $request->input('status');

            // update user record
            $model->save();

            return redirect()->intended('admin/roles')->withSuccess('Role updated successfully');
        } else {
            $errors=$validator->errors()->messages();
            return view('admin::role.add', ['errors' => $errors]);
        }
    }


    /**
     * Soft delete role record
     * @return Renderable
     */
    public function role_delete(Request $request, $id)
    {
        // fetching the user data wrt id
        $model= Role::find($id);

        // creating user data updation object
        $model->is_deleted = 1;
        
        // update user record
        $model->save();

        return redirect()->intended('admin/roles')->withSuccess('Role deleted successfully');
    }
}
