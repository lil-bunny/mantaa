<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\State;
use Validator;
use Session;

class StateController extends Controller
{
        /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $filters = [
            'state_title' => $request->query('state_title'),
            'status' => $request->query('status'),
        ];

        // fetching user lists
        $states = State::sortable()->where('states.is_deleted', '=', 0);
        
        // checks if search filters are set
        if($filters['state_title'] != '') {
            $states->where('states.title', 'like', '%'.$filters['state_title'].'%');
        }
        if($filters['status'] != '') {
            $states->where('states.status', '=', $filters['status']);
        }
        $states = $states->paginate(20);
        
        return view('admin::state.index', ['states'=>$states, 'filters' => $filters]);
    }


    /**
     * Display Add state template
     * @return Renderable
     */
    public function add()
    {
        return view('admin::state.add');
    }

    /**
     * Adds state record
     * @return Renderable
     */
    public function create_state(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:states|max:255',
        ]);
        
        if ($validator->passes()) {
            // create user record
            State::create([
                'name' => $request->input('name'),
                'status' => $request->input('status'),
            ]);
        } else {
            $errors=$validator->errors();
            return redirect()->route('admin::state_add')->with('errors',$errors);
        }

        return redirect()->intended('admin/states')->withSuccess('State created successfully');
    }

    /**
     * Display Edit state template
     * @return Renderable
     */
    public function edit($id)
    {
        // fetching user details
        $state_data = State::find($id);
                    
        return view('admin::state.edit', ['state_data' => $state_data]);
    }


    /**
     * Updates state record
     * @return Renderable
     */
    public function update_state(Request $request, $id)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validator->passes()) {
            // fetching the user data wrt id
            $model= State::find($id);

            // creating user data updation array
            $model->name = $request->input('name');
            $model->status = $request->input('status');

            // update user record
            $model->save();

            return redirect()->intended('admin/states')->withSuccess('State updated successfully');
        } else {
            $errors=$validator->errors();
            return redirect()->route('admin::state_edit', ['id' => $id])->with('errors',$errors);
        }
    }


    /**
     * Soft delete state record
     * @return Renderable
     */
    public function state_delete(Request $request, $id)
    {
        // fetching the user data wrt id
        $model= State::find($id);

        // creating user data updation object
        $model->is_deleted = 1;
        
        // update user record
        $model->save();

        return redirect()->intended('admin/states')->withSuccess('State deleted successfully');
    }
}
