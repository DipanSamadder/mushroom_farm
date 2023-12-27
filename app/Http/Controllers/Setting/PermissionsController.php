<?php

namespace App\Http\Controllers\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Permission;
use Validator;

class PermissionsController extends Controller
{
    function __construct(){
       
        $this->middleware('permission:permissions|add-permissions|edit-permissions|delete-permissions', ['only' => ['index','get_ajax_permissions']]);
        $this->middleware('permission:add-permissions', ['only' => ['create','store']]);
        $this->middleware('permission:edit-permissions', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-permissions', ['only' => ['destroy']]);
        
    }

    public function index(){
        $page['title'] = 'Show all permissions';
        return view('backend.modules.roles.permissions.show', compact('page'));
    }

    public function get_ajax_permissions(Request $request){
   
        if($request->page != 1){$start = $request->page * 25;}else{$start = 0;}
        $search = $request->search;
        $sort = $request->sort;

        $data = Permission::where('name','!=','');
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
                case 'active':
                    $data->where('status', 1);
                    break;
                case 'deactive':
                    $data->where('status', 0);
                    break;
                default:
                    $data->orderBy('created_at', 'desc');
                    break;
            }
        }
        $data = $data->skip($start)->paginate(25);
        return view('backend.modules.roles.permissions.ajax_files', compact('data'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'guard_name' => 'required|string|max:50',
        ]);


        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }

        $slug_name = preg_replace('[^A-Za-z0-9\-]', '', str_replace(' ', '-', $request->name));

        if(Permission::where('name', $slug_name)->first() == null){
            $permission =  new Permission;
            $permission->name = dsld_generate_slug_by_text_with_model('App\Models\Permission', strtolower($request->name), 'name');
            $permission->title = 'Show '.$request->name;
            $permission->guard_name = strtolower($request->guard_name);
            $permission->status = 1;
            if($permission->save()){
                $arr = array('Add', 'Edit', 'Delete');
                foreach($arr as $value){
                    $permissions =  new Permission;
                    $permissions->name = dsld_generate_slug_by_text_with_model('App\Models\Permission', strtolower($value.' '.$request->name), 'name');
                    $permissions->title = $value.' '.$request->name;
                    $permissions->guard_name = strtolower($request->guard_name);
                    $permissions->status = 1;
                    $permissions->save();
                }
                return response()->json(['status' => 'success', 'message'=> 'Data insert success.']);
            }else{
                return response()->json(['status' => 'error', 'message'=> 'Data insert failed.']);
            }
        }else{
            return response()->json(['status' => 'warning', 'message'=> 'Details already exist! please try agin.']);
        }
    }

    public function edit(Request $request){
        $data = Permission::where('id', $request->id)->first();
        return view('backend.modules.roles.permissions.edit', compact('data'));
    }
    
    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
        ]);


        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }

        $permission =  Permission::findOrFail($request->id);
        $permission->title = $request->name;            
        $permission->status = $request->status;            
        if($permission->save()){
            return response()->json(['status' => 'success', 'message'=> 'Data update success.']);
        }
    
        return response()->json(['status' => 'warning', 'message'=> 'Details already exist! please try agin.']);
        

    }
    public function destory(Request $request){

        $permission = Permission::findOrFail($request->id);
        if($permission != ''){
            if($permission->delete()){
                return response()->json(['status' => 'success', 'message' => 'Data deleted successully.']);
            }else{
                return response()->json(['status' => 'error', 'message' => 'Data deleted failed.']);
            }
        }else{
            return response()->json(['status' => 'warning', 'message' => 'Data Not found.']);
        }
       
    }
    
    public function status(Request $request){

        $permission = Permission::findOrFail($request->id);
        if($permission != ''){
            if($permission->status != $request->status){
                $permission->status = $request->status;
                $permission->save();
                return response()->json(['status' => 'success', 'message' => 'Status update successully.']);
            }else{
                return response()->json(['status' => 'error', 'message' => 'Status update failed.']);
            }
        }else{
            return response()->json(['status' => 'warning', 'message' => 'Data Not found.']);
        }
       
    }
}
