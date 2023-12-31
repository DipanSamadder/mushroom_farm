<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Validator;
use Hash;

class UsersController extends Controller
{
    function __construct(){
       
        $this->middleware('permission:user|add-user|edit-user|delete-user', ['only' => ['index','get_ajax_users']]);
        $this->middleware('permission:add-user', ['only' => ['create','store']]);
        $this->middleware('permission:edit-user', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-user', ['only' => ['destroy']]);
        
    }
    public function index(){

        $page['title'] = 'Show all users';
        return view('backend.modules.users.show', compact('page'));
    }
    public function profiles(){
        $page['title'] = 'Your Profile';
        return view('backend.modules.users.profiles.edit', compact('page'));
    }
    public function get_ajax_users(Request $request){

        if($request->page != 1){$start = $request->page * 24;}else{$start = 0;}
        $search = $request->search;
        $sort = $request->sort;

        $data = User::where('email','!=','')->where('id','!=',1);
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
                    $data->where('banned', 0);
                    break;
                case 'deactive':
                    $data->where('banned', 1);
                    break;
                case 'admin':
                    $data->where('user_type', 'admin');
                    break;
                case 'customer':
                    $data->where('user_type', 'customer');
                    break;
                default:
                    $data->orderBy('created_at', 'desc');
                    break;
            }
        }
        $data = $data->skip($start)->paginate(24);
        return view('backend.modules.users.ajax_users', compact('data'));
    }
    public function show_permissions(Request $request){
        if($request->page != 1){$start = $request->page * 25;}else{$start = 0;}

        $search = $request->search;
        $sort = $request->sort;
        $user_id = $request->user_id;


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
        return view('backend.modules.users.ajax_permissions', compact('data','user_id'));

    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:255',
            'password' => 'required|max:50',
            'phone' => 'required|integer'
        ]);


        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }

     
        if(User::where('email', $request->email)->first() == null){
            $user =  new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password =  Hash::make($request->password);
            $user->phone =  $request->phone;
            $user->user_type = $request->user_type == '' ? 'user' : $request->user_type;
            $user->avatar_original = $request->avatar_original;
            $user->banned = 0;
            
            if($user->save()){
                return response()->json(['status' => 'success', 'message'=> 'Data insert success.']);
            }else{
                return response()->json(['status' => 'error', 'message'=> 'Data insert failed.']);
            }
        }else{
            return response()->json(['status' => 'warning', 'message'=> 'Details already exist! please try agin.']);
        }
    }
    public function edit($id){

        $data = User::where('id', $id)->first();
        $page['title'] = 'Edit Data';
        return view('backend.modules.users.edit', compact('data', 'page'));
    }
    public function profiles_update(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:255',
            'phone' => 'required|integer'
        ]);
        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }
     
        $user =  User::findOrFail($request->user_id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone =  $request->phone;
        $user->avatar_original = $request->avatar_original;
            
        if($user->save()){
            return response()->json(['status' => 'success', 'message'=> 'Data update success.']);
        }else{
            return response()->json(['status' => 'error', 'message'=> 'Data update failed.']);
        }
        
    }
    public function update(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:255',
            'phone' => 'required|integer'
        ]);


        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }
     
        if(User::whereNotIn('id', [$request->id])->where('name', $request->name)->where('email', $request->email)->where('phone', $request->phone)->first() == null){
            $user =  User::findOrFail($request->id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone =  $request->phone;
            $user->avatar_original = $request->avatar_original;
            $user->banned = $request->banned;
            $user->created_at = $request->date;
           
            if($user->save()){
                $role = Role::find($request->role);
                if(!$user->hasRole($role->name)){
                    if($user->getAllPermissions()){
                        foreach($user->getAllPermissions() as $key => $permission){
                            $user->revokePermissionTo($permission->name);
                        }
                    }
                   
                    foreach($role->permissions as $key => $permission){
                        $user->givePermissionTo($permission->name);
                    }
                    $user->syncRoles($role->id);
                }
                
                return response()->json(['status' => 'success', 'message'=> 'Data update success.']);
            }else{
                return response()->json(['status' => 'error', 'message'=> 'Data update failed.']);
            }
        }else{
            return response()->json(['status' => 'warning', 'message'=> 'Details already exist! please try agin.']);
        }

    }
    public function destory(Request $request){

        $user = User::findOrFail($request->id);
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
    public function status(Request $request){

        $user = User::findOrFail($request->id);
        if($user != ''){
            if($user->banned != $request->status){
                $user->banned = $request->status;
                $user->save();
                return response()->json(['status' => 'success', 'message' => 'Status update successully.']);
            }else{
                return response()->json(['status' => 'error', 'message' => 'Status update failed.']);
            }
        }else{
            return response()->json(['status' => 'warning', 'message' => 'Data Not found.']);
        }
       
    }
      public function assign_permissions(Request $request){

        $user = User::find($request->status);
        if($user != ''){
            $permission = Permission::where('id', $request->id)->first();
            if($user->hasDirectPermission($permission->name)){
                $user->revokePermissionTo($permission->name);
                return response()->json(['status' => 'success', 'message' => 'Permission revoke successully.']);
            }else{
                $user->givePermissionTo($permission->name);

                return response()->json(['status' => 'success', 'message' => 'Permission assign successully.']);
            }
            
        }else{
            return response()->json(['status' => 'warning', 'message' => 'Data Not found.']);
        }
       
    }
}
