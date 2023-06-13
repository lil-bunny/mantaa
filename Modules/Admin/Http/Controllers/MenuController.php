<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\Menu;
use Validator;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $filters = [
            'menu_name' => $request->query('menu_name'),
            'status' => $request->query('status'),
        ];

        // fetching city lists
        $menus = Menu::sortable()->where('menus.is_deleted', '=', 0);
        
        // checks if search filters are set
        if($filters['menu_name'] != '') {
            $menus->where('menus.title', 'like', '%'.$filters['menu_name'].'%');
        }
        if($filters['status'] != '') {
            $menus->where('menus.status', '=', $filters['status']);
        }
        $menus = $menus->paginate(10);
        
        return view('admin::menu.index', ['menus'=>$menus, 'filters' => $filters]);
    }


    /**
     * Display Add city template
     * @return Renderable
     */
    public function add()
    {
        return view('admin::menu.add');
    }

    /**
     * Adds city record
     * @return Renderable
     */
    public function create_menu(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:cities|max:255',
            'route' => 'required|max:255',
        ]);
        
        if ($validator->passes()) {
            // create user record
            Menu::create([
                'title' => $request->input('name'),
                'route' => $request->input('route'),
                'status' => $request->input('status'),
            ]);
        } else {
            $errors=$validator->errors();
            return redirect()->route('admin::menu_add')->with('errors',$errors);
        }

        return redirect()->intended('admin/menus')->withSuccess('Menu created successfully');
    }

    /**
     * Display Edit city template
     * @return Renderable
     */
    public function edit($id)
    {
        // fetching user details
        $menu_data = Menu::find($id);
                    
        return view('admin::menu.edit', ['menu_data' => $menu_data]);
    }


    /**
     * Updates city record
     * @return Renderable
     */
    public function update_menu(Request $request, $id)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'route' => 'required|max:255',
        ]);

        
        if ($validator->passes()) {
            // fetching the city data wrt id
            $model= Menu::find($id);

            // creating city data updation array
            $model->title = $request->input('name');
            $model->route = $request->input('route');
            $model->status = $request->input('status');

            // update user record
            $model->save();

            return redirect()->intended('admin/menus')->withSuccess('Menu updated successfully');
        } else {
            $errors=$validator->errors();
            return redirect()->route('admin::menu_edit', ['id' => $id])->with('errors',$errors);
        }
    }


    /**
     * Soft delete city record
     * @return Renderable
     */
    public function menu_delete(Request $request, $id)
    {
        // fetching the city data wrt id
        $model= Menu::find($id);

        // creating city data updation object
        $model->is_deleted = 1;
        
        // update city record
        $model->save();

        return redirect()->intended('admin/menus')->withSuccess('Menu deleted successfully');
    }
}
