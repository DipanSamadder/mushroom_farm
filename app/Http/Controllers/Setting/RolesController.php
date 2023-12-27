<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Validator;
use Auth;

class RolesController extends Controller
{ 
    function __construct(){
       
        $this->middleware('permission:roles|add-roles|edit-roles|delete-roles', ['only' => ['index','get_ajax_roles']]);
        $this->middleware('permission:add-roles', ['only' => ['create','store']]);
        $this->middleware('permission:edit-roles', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-roles', ['only' => ['destroy']]);
        
    }
    public function index(){

        $page['title'] = 'Show all role';
        return view('backend.modules.roles.show', compact('page'));
    }

    public function get_ajax_roles(Request $request){
        if($request->page != 1){$start = $request->page * 25;}else{$start = 0;}
        $search = $request->search;
        $sort = $request->sort;

        $data = Role::where('name','!=','');
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
        $data = $data->whereNotIn('name', ['super-admin', Auth::user()->roles->pluck('name')->first()])->skip($start)->paginate(25);
        return view('backend.modules.roles.ajax_roles', compact('data'));
    }

    public function show_permissions(Request $request){
        if($request->page != 1){$start = $request->page * 25;}else{$start = 0;}
        $search = $request->search;
        $sort = $request->sort;
        $role_id = $request->role_id;

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
                default:
                    $data->orderBy('created_at', 'desc');
                    break;
            }
        }
        $data = $data->skip($start)->paginate(25);
        return view('backend.modules.roles.ajax_permissions', compact('data','role_id'));
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
        ]);


        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }

     
        if(Role::where('name', $request->name)->first() == null){
            $role =  new Role;
            $role->name = $request->name;
            
            if($role->save()){
                return response()->json(['status' => 'success', 'message'=> 'Data insert success.']);
            }else{
                return response()->json(['status' => 'error', 'message'=> 'Data insert failed.']);
            }
        }else{
            return response()->json(['status' => 'warning', 'message'=> 'Details already exist! please try agin.']);
        }
    }

    public function edit($id){

        $data = Role::where('id', $id)->first();
        $page['title'] = 'Edit Data';
        return view('backend.modules.roles.edit', compact('data', 'page'));
    }
    
    public function update(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
        ]);


        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }
     
        if(Role::whereNotIn('id', [$request->id])->where('name', $request->name)->first() == null){
            $role =  Role::findOrFail($request->id);
            $role->name = $request->name;
            $role->created_at = $request->date;
            
            if($role->save()){
                return back()->with('success', 'Data update success.');
            }else{
                return back()->with('error', 'Data update failed.');
            }
        }else{
            return back()->with('warning', 'Details already exist! please try agin.');
        }

    }
    
    public function destory(Request $request){
        $user = Role::findOrFail($request->id);
        if($user != ''){
            if($user->delete()){
                return response()->json(['status' => 'success', 'message' => 'Data deleted successully.']);
            }else{
                return response()->json(['status' => 'error', 'message' => 'Data deleted failed.']);
            }
        }else{
            return response()->json(['status' => 'warning', 'message' => 'Data Not found.']);
        }
       
    }
    public function assign_permissions(Request $request){


        $role = Role::findOrFail($request->status);
        if($role != ''){
            if($role->hasPermissionTo($request->id)){
                $role->revokePermissionTo($request->id);
            }else{
                $role->givePermissionTo($request->id);
            }
            return response()->json(['status' => 'success', 'message' => 'Permission assign successully.']);
            
        }else{
            return response()->json(['status' => 'warning', 'message' => 'Data Not found.']);
        }
       
    }
}
