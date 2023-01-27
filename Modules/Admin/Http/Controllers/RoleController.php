<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Role;
use App\Models\Menu;
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
        $roles = $roles->paginate(10);
        
        return view('admin::role.index', ['roles'=>$roles, 'filters' => $filters]);
    }


    /**
     * Display Add role template
     * @return Renderable
     */
    public function add()
    {
        // fetching menu data
        $menus = Menu::where('is_deleted', '=', 0)
                            ->where('status', '=', 1)->get();

        return view('admin::role.add', ['menus'=>$menus]);
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
            $final_name = preg_replace('#[ -]+#', '-', trim($request->input('title')));
            // create user record
            $roles = Role::create([
                'title' => $request->input('title'),
                'role_id' => strtolower($final_name),
                'admin_access' => $request->input('admin_access'),
                'status' => $request->input('status'),
            ]);

            $roles->menus()->attach($request->input('menu'));
        } else {
            $errors=$validator->errors();
            return redirect()->route('admin.role_add')->with('errors',$errors);
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
        $menus_chkd = [];
        foreach($role_data->menus->toArray() as $menu) {
            $menus_chkd[] = $menu['id'];
        }

        // fetching menu data
        $menus = Menu::where('is_deleted', '=', 0)
                            ->where('status', '=', 1)->get();
                    
        return view('admin::role.edit', ['role_data' => $role_data, 'menus_chkd' => $menus_chkd, 'menus' => $menus]);
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
            $final_name = preg_replace('#[ -]+#', '-', trim($request->input('title')));
            $model->title = $request->input('title');
            $model->role_id = strtolower($final_name);
            $model->status = $request->input('status');
            $model->admin_access = $request->input('admin_access')==1?1:0;
            $model->menus()->sync($request->input('menu'));

            // update user record
            $model->save();

            return redirect()->intended('admin/roles')->withSuccess('Role updated successfully');
        } else {
            $errors=$validator->errors()->messages();
            return redirect()->route('admin::role_edit', ['id' => $id])->with('errors',$errors);
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
