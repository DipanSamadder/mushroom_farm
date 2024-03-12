<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RoomEmployee;
use App\Models\Permission;
use App\Models\Employe;
use Validator;
use Hash;
use Auth;

class RoomAssignController extends Controller
{
   
    function __construct(){
       
        $this->middleware('permission:room-assign', ['only' => ['index','get_ajax_room-assigns']]);
        $this->middleware('permission:add-room-assign', ['only' => ['create','store']]);
        $this->middleware('permission:edit-room-assign', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-room-assign', ['only' => ['destroy']]);
        
    }

    public function index(){
        $page['title'] = 'Show all Room Assign';
        $page['name'] = 'Room Assign';
        return view('backend.modules.room_assign.show', compact('page'));
    }

    public function get_ajax_room_assign(Request $request){
   
        if($request->page != 1){$start = $request->page * 25;}else{$start = 0;}
        $search = $request->search;
        $sort = $request->sort;

        $data = RoomEmployee::where('room_history_id','!=','');
        if($search != ''){
            $data->where('room_history_id', 'like', '%'.$search.'%');
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
        return view('backend.modules.room_assign.ajax_files', compact('data'));
    }

    public function edit(Request $request){
        $data = RoomEmployee::where('id', $request->id)->first();
        return view('backend.modules.room_assign.edit', compact('data'));
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'room_history_id' => 'required|max:350',
        ]);


        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }


        $type = RoomEmployee::findOrFail($request->id);
        $type->room_history_id = $request->room_history_id;
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
            'room_history_id' => 'required|max:350',
            'employee_id' => 'required|max:350',
            'labours_type' => 'required|max:350',
        ]);


        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }
     
        $type = new RoomEmployee;
        $type->room_history_id = $request->room_history_id;
        $type->labours_type = $request->labours_type;
        $type->employee_id =  json_encode($request->employee_id);
        $type->status = 1;
        $type->created_by = Auth::user()->id;
        $type->updated_by = Auth::user()->id;
        
        if($type->save()){
            return response()->json(['status' => 'success', 'message'=> 'Data insert success.']);
        }else{
            return response()->json(['status' => 'error', 'message'=> 'Data insert failed.']);
        }
    }

    public function destory(Request $request){
        if(RoomEmployee::destroy($request->id)){
            return response()->json(['status' => 'success', 'message' => 'Data deleted successully.']);   
        }else{
            return response()->json(['status' => 'warning', 'message' => 'Data Not found.']);
        }
       
    }

    public function employee_find(Request $request){
        $data = Employe::where('type', $request->id)->with('user')->get();
        if($data){
            return response()->json(['status' => 'success', 'message' => 'Data fatching.', 'data' => $data]);   
        }else{
            return response()->json(['status' => 'warning', 'message' => 'Data Not found.']);
        }
       
    }
    
}
