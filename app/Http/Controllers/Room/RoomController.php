<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Room;
use App\Models\Cycle;
use App\Models\RoomCycle;
use App\Models\Permission;
use Validator;
use Hash,Auth;

class RoomController extends Controller
{
   
    function __construct(){
       
        $this->middleware('permission:rooms', ['only' => ['index','get_ajax_rooms']]);
        $this->middleware('permission:add-room', ['only' => ['create','store']]);
        $this->middleware('permission:edit-room', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-room', ['only' => ['destroy']]);
        
    }

    public function index(){
        $page['title'] = 'Show all Room';
        $page['name'] = 'Room';
        return view('backend.modules.room.show', compact('page'));
    }

    public function get_ajax_rooms(Request $request){
   
        if($request->page != 1){$start = $request->page * 25;}else{$start = 0;}
        $search = $request->search;
        $sort = $request->sort;

        $data = Room::where('name','!=','');
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
        return view('backend.modules.room.ajax_files', compact('data'));
    }

    public function ajax_room_table_details(Request $request){
   
        $search = $request->search;
        $sort = $request->sort;
        
        $room = Room::where('id', $request->room_id)->first();
        $data = Cycle::where('name','!=','');
        if($search != ''){
            $data->where('name', 'like', '%'.$search.'%');
        }
        $data = $data->get();
        return view('backend.modules.room.ajax_files_table_details', compact('data','room'));
    }

    public function edit(Request $request){
        $data = Room::where('id', $request->id)->first();
        return view('backend.modules.room.edit', compact('data'));
    }

    public function details_edit_ajax(Request $request){
        $cycle =  Cycle::find($request->id);
        $rooms =  Room::find($request->room_id);

        $data = RoomCycle::where('cycle_id', $cycle->id)->where('room_id', $request->room_id)->first();

        if(is_null($data)){
            $data = ''; 
        }
        return view('backend.modules.room.ajax_room_detail_edit', compact('data', 'rooms', 'cycle'));
    }

    public function details_edit($id){
        $page['title'] = 'Edit Room';
        $page['name'] = 'Room';
        $data = Room::where('id', $id)->first();
        return view('backend.modules.room.details_edit', compact('page','data'));
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:350',
            'remark' => 'required|max:350'
        ]);


        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }
        $room =  Room::findOrFail($request->id);
        $room->name = $request->name;
        $room->updated_by =  Auth::user()->id;
        $room->remark =  $request->remark;
        $room->banner =  $request->banner;

        if($room->save()){
                return response()->json(['status' => 'success', 'message'=> 'Data update success.']);
        }else{
            return response()->json(['status' => 'error', 'message'=> 'Data update failed.']);
        }
    }

    public function details_update(Request $request){
        $validator = Validator::make($request->all(), [
            'room_id' => 'required',
            'cycle_id' => 'required',
            'employe_id' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }
        $data = RoomCycle::where('cycle_id', $request->cycle_id)->where('room_id', $request->room_id)->first();
        if(!is_null($data)){
            $roomDetails =  RoomCycle::findOrFail($request->id);
            $roomDetails->updated_by =  Auth::user()->id;
            $roomDetails->date =  $request->date;
            $roomDetails->employe_id =  json_encode($request->employe_id);
            $roomDetails->remark =  $request->remark;
            $roomDetails->status =  $request->status;
            if($roomDetails->save()){
                return response()->json(['status' => 'success', 'message'=> 'Data update success.']);
            }else{
                return response()->json(['status' => 'error', 'message'=> 'Data update failed.']);
            }
        }else{
            $roomDetails = new RoomCycle;
            $roomDetails->cycle_id =  $request->cycle_id;
            $roomDetails->date =  $request->date;
            $roomDetails->room_id =  $request->room_id;
            $roomDetails->employe_id =  json_encode($request->employe_id);
            $roomDetails->remark =  $request->remark;
            $roomDetails->status =  0;
            $roomDetails->created_by =  Auth::user()->id;
            $roomDetails->updated_by =  Auth::user()->id;
            if($roomDetails->save()){
                return response()->json(['status' => 'success', 'message'=> 'Data Insert success.']);
            }else{
                return response()->json(['status' => 'error', 'message'=> 'Data Insert failed.']);
            }
        }

    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:350',
            'remark' => 'required|max:350'
        ]);


        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }
     
        $room = new Room;
        $room->name = $request->name;
        $room->created_by =  Auth::user()->id;
        $room->updated_by =  Auth::user()->id;
        $room->remark =  $request->remark;
        $room->status = 1;
        
        if($room->save()){
            return response()->json(['status' => 'success', 'message'=> 'Data insert success.']);
        }else{
            return response()->json(['status' => 'error', 'message'=> 'Data insert failed.']);
        }
    }

    public function destory(Request $request){
        if(Room::destroy($request->id)){
            return response()->json(['status' => 'success', 'message' => 'Data deleted successully.']);   
        }else{
            return response()->json(['status' => 'warning', 'message' => 'Data Not found.']);
        }
       
    }
    
}
