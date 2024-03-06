<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Designation;
use App\Models\Permission;
use Validator;
use Hash;
use Auth;

class DesignationController extends Controller
{
   
    function __construct(){
       
        $this->middleware('permission:designation', ['only' => ['index','get_ajax_designations']]);
        $this->middleware('permission:add-designation', ['only' => ['create','store']]);
        $this->middleware('permission:edit-designation', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-designation', ['only' => ['destroy']]);
        
    }

    public function index(){
        $page['title'] = 'Show all designation';
        $page['name'] = 'designation';
        return view('backend.modules.designation.show', compact('page'));
    }

    public function get_ajax_designations(Request $request){
   
        if($request->page != 1){$start = $request->page * 25;}else{$start = 0;}
        $search = $request->search;
        $sort = $request->sort;

        $data = Designation::where('name','!=','');
        if($search != ''){
            $data->where('name', 'like', '%'.$search.'%');
        }
       
        if($sort != ''){
            switch ($request->sort) {
                case 'newest':
                    $data->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $data->orderBy('created_at', 'asc');
                    break;
                default:
                    $data->orderBy('created_at', 'desc');
                    break;
            }
        }
        $data = $data->skip($start)->paginate(25);
        return view('backend.modules.designation.ajax_files', compact('data'));
    }

    public function edit(Request $request){
        $data = Designation::where('id', $request->id)->first();
        return view('backend.modules.designation.edit', compact('data'));
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:350',
            'status' => 'required|max:350',
            'level' => 'required|max:350'
        ]);


        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }


        $type = Designation::findOrFail($request->id);
        $type->name = $request->name;
        $type->parent =  $request->parent;
        $type->level =  $request->level;
        $type->is_temporary =  $request->is_temporary;
        $type->status = $request->status;
        $type->updated_by = Auth::user()->id;

        if($type->save()){
                return response()->json(['status' => 'success', 'message'=> 'Data update success.']);
        }else{
            return response()->json(['status' => 'error', 'message'=> 'Data update failed.']);
        }
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:350',
            'status' => 'required|max:350',
            'level' => 'required|max:350'
        ]);


        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }
     
        $type = new Designation;
        $type->name = $request->name;
        $type->parent =  $request->parent;
        $type->is_temporary =  $request->is_temporary;
        $type->level =  $request->level;
        $type->status = $request->status;
        $type->created_by = Auth::user()->id;
        $type->updated_by = Auth::user()->id;
        
        if($type->save()){
            return response()->json(['status' => 'success', 'message'=> 'Data insert success.']);
        }else{
            return response()->json(['status' => 'error', 'message'=> 'Data insert failed.']);
        }
    }

    public function destory(Request $request){
        if(Designation::destroy($request->id)){
            return response()->json(['status' => 'success', 'message' => 'Data deleted successully.']);   
        }else{
            return response()->json(['status' => 'warning', 'message' => 'Data Not found.']);
        }
       
    }
    
}
