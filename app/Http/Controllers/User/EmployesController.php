<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Employe;
use Validator;
use Hash;

class EmployesController extends Controller
{
    function __construct(){
       
        $this->middleware('permission:employe|add-employe|edit-employe|delete-employe', ['only' => ['index','get_ajax_employes']]);
        $this->middleware('permission:add-employe', ['only' => ['create','store']]);
        $this->middleware('permission:edit-employe', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-employe', ['only' => ['destroy']]);
        
    }
    public function index(){

        $page['title'] = 'Show all employe';
        return view('backend.modules.employes.show', compact('page'));
    }
    
    public function get_ajax_employes(Request $request){

        if($request->page != 1){$start = $request->page * 24;}else{$start = 0;}
        $search = $request->search;
        $sort = $request->sort;

        $data = User::where('user_type','employer')->where('id','!=',1);
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
        return view('backend.modules.employes.ajax_employes', compact('data'));
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
        return view('backend.modules.employes.edit', compact('data', 'page'));
    }

    
    public function update(Request $request){
       
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:255',
            'aadhar' => 'required|integer',
            'paid_days' => 'required',
            'designation' => 'required',
            'start_year' => 'required',
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

            $is_employ = Employe::where('user_id', $request->id)->first();
            if(is_null($is_employ)){
                $employ = new Employe;
                $employ->aadhar = $request->aadhar;
                $employ->user_id = $request->id;
                $employ->paid_days = $request->paid_days;
                $employ->designation = $request->designation;
                $employ->start_year = $request->start_year;
                $employ->remark = $request->remark;
                $employ->status = ($request->banned == 0 ) ? 1 : 0;
                $employ->save();
            }else{
                $is_employ->aadhar = $request->aadhar;
                $is_employ->paid_days = $request->paid_days;
                $is_employ->designation = $request->designation;
                $is_employ->start_year = $request->start_year;
                $is_employ->remark = $request->remark;
                $is_employ->status = ($request->banned == 0 ) ? 1 : 0;
                $is_employ->save();
            }
            if($user->save()){                
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
   
}
