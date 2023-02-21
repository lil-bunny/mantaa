<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Area;
use Session;
use Validator;
use Hash;

class AreaDetailsController extends Controller
{
    public function index(Request $request, $id)
    {

        $data = Area::where('is_deleted', '=', 0)
                    ->where('status', '=', 1)->find($id);
        
        // $data = Area::find($id);
        return view('area-details.index', compact('data', 'id')); 
    }
}
