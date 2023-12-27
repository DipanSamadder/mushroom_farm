<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Read;
use Validator;
use Auth;

class ReadController extends Controller
{ 
    function __construct(){
       
        $this->middleware('permission:reads|add-reads|edit-reads|delete-reads', ['only' => ['index','get_ajax_reads']]);
        $this->middleware('permission:add-reads', ['only' => ['create','store']]);
        $this->middleware('permission:edit-reads', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-reads', ['only' => ['destroy']]);
        
    }

    public function index(){

        $page['title'] = 'Show all read';
        return view('backend.modules.reads.show', compact('page'));
    }

    public function get_ajax_reads(Request $request){
        if($request->page != 1){$start = $request->page * 25;}else{$start = 0;}
        $search = $request->search;
        $sort = $request->sort;

        $data = Read::where('id','!=','');
        if($search != ''){
            $user = User::where('name', 'like', '%'.$search.'%')->first();
            if(!is_null($user)){
                $data->whereIn('readable_id', [$user->id]);
            }
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
        return view('backend.modules.reads.ajax_reads', compact('data'));
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|string|max:50',
            'count' => 'required|string|max:50',
        ]);


        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }

     
        if(Read::where('name', $request->name)->first() == null){
            $role =  new Read;
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

    public function update(Request $request){

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|string|max:50',
            'count' => 'required|string|max:50',
        ]);


        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }
     
        if(Role::whereNotIn('id', [$request->id])->where('name', $request->name)->first() == null){
            $role =  Read::findOrFail($request->id);
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
   
}
