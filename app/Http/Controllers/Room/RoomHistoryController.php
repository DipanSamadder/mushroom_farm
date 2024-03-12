<?php
namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Room;
use App\Models\RoomEmployee;
use App\Models\RoomHistory;
use App\Models\Cycle;
use App\Models\RoomCycle;
use App\Models\Permission;
use Validator;
use Hash,Auth;

class RoomHistoryController extends Controller{

    function __construct(){
        $this->middleware('permission:room', ['only' => ['index','get_ajax_rooms_history']]);
        $this->middleware('permission:add-room', ['only' => ['create','store']]);
        $this->middleware('permission:edit-room', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-room', ['only' => ['destroy']]);
    }



    public function index(){
        $page['title'] = 'Show all Room Occupied';
        $page['name'] = 'Room Occupied';
        return view('backend.modules.room_histories.show', compact('page'));
    }



    public function get_ajax_rooms_history(Request $request){

        if($request->page != 1){$start = $request->page * 25;}else{$start = 0;}
        $search = $request->search;
        $sort = $request->sort;
        $data = RoomHistory::where('room_id','!=','');

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
        return view('backend.modules.room_histories.ajax_files', compact('data'));
    }



    public function ajax_room_table_details(Request $request){

        $search = $request->search;
        $sort = $request->sort;
        $roomHistory = RoomHistory::where('id', $request->room_id)->first();
        $data = RoomCycle::where('room_histories_id', $request->room_id);

        if($search != ''){
            $data->where('name', 'like', '%'.$search.'%');
        }

        if($sort != ''){
            switch ($request->sort) {
                case 'newest':
                    $data->orderBy('id', 'asc');
                    break;
                case 'oldest':
                    $data->orderBy('id', 'desc');
                    break;
                default:
                    $data->orderBy('id', 'asc');
                break;
            }
        }

        $data = $data->get();
     
        return view('backend.modules.room_histories.ajax_files_table_details', compact('data','roomHistory'));

    }



    public function edit(Request $request){

        $data = RoomHistory::where('id', $request->id)->first();
        return view('backend.modules.room_histories.edit', compact('data'));

    }



    public function details_edit_ajax(Request $request){

        $rooms =  RoomHistory::find($request->room_histories_id);
        $data = RoomCycle::where('id', $request->id)->where('room_histories_id', $request->room_histories_id)->first();
        $cycle =  Cycle::find($data->cycle_id);

        if(is_null($data)){ $data = ''; }

        return view('backend.modules.room_histories.ajax_room_detail_edit', compact('data', 'rooms', 'cycle'));

    }



    public function details_edit($id){
        $page['title'] = 'Edit Room';
        $page['name'] = 'Room';
        $data = RoomHistory::where('id', $id)->first();
        return view('backend.modules.room_histories.details_edit', compact('page','data'));
    }


    public function get_pending_cycle(Request $request){
        $data = Cycle::where('id', '!=', '');
        $roomCycle = RoomCycle::where('room_histories_id', $request->id)->latest()->first();


        if(!is_null($roomCycle)){
            $data =Cycle::where('id', '>', $roomCycle->cycle_id-1);
        }

        $data = $data->get();

        if($data){
            return response()->json(['status' => 'success', 'message' => 'Data fatching.', 'data' => $data]);   
        }else{
            return response()->json(['status' => 'warning', 'message' => 'Data Not found.']);
        }
       
    }

    public function update(Request $request){

        $validator = Validator::make($request->all(), [
            'start_date' => 'required|max:350',
        ]);


        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }

        $room =  RoomHistory::findOrFail($request->id);
        $room->start_date = $request->start_date;
        $room->updated_by =  Auth::user()->id;
        $room->status =  $request->status;

        if($request->status == 1){
            $this->room_status_update($room->room_id, 1);
        }else{
            $this->room_status_update($room->room_id, 0);
        }

        if($room->save()){

                return response()->json(['status' => 'success', 'message'=> 'Data update success.']);

        }else{

            return response()->json(['status' => 'error', 'message'=> 'Data update failed.']);

        }

    }



    public function details_update(Request $request){

        $validator = Validator::make($request->all(), [
            'room_histories_id' => 'required',
            'room_id' => 'required',
            'cycle_id' => 'required',

        ]);



        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }

        $cycle = Cycle::where('id', $request->cycle_id)->first();
        $data = RoomCycle::where('cycle_id', $request->cycle_id)->where('room_id', $request->room_id)->first();

        $get_cycle = Cycle::where('id', $request->cycle_id)->first();
        $get_history = RoomHistory::where('id', $request->room_histories_id)->first();

        $startDate  = \Carbon\Carbon::parse($get_history->start_date);
        $room_emp = RoomEmployee::where('room_history_id', $request->room_histories_id)->where('labours_type', $get_cycle->labours_type)->first();

        if(is_null($room_emp)){
            return response()->json(['status' => 'error', 'message'=> 'Employee assign first.']);
        }
 
        if(!is_null($data)){

            $roomDetails =  RoomCycle::findOrFail($request->id);
            $roomDetails->updated_by =  Auth::user()->id;
            $roomDetails->date =  $startDate->addDay($cycle->day+1);
            $roomDetails->day = $cycle->day;
            $roomDetails->cycle_name =  $cycle->name;

            if($request->has('employe_id')){
                $roomDetails->employe_id =  json_encode($request->employe_id);
            }else{
                $roomDetails->employe_id =  $room_emp->employee_id;
            }
            
            $roomDetails->remark =  $request->remark;
            $roomDetails->is_delay =  $request->is_delay == 'on' ? 1 : 0;
            $roomDetails->status =  $request->status;

            if($roomDetails->save()){
                return response()->json(['status' => 'success', 'message'=> 'Data update success.']);
            }else{
                return response()->json(['status' => 'error', 'message'=> 'Data update failed.']);
            }

        }else{
            

            $roomDetails = new RoomCycle;
            $roomDetails->cycle_id =  $request->cycle_id;
            $roomDetails->date =  $startDate->addDay($cycle->day+1);
            $roomDetails->room_histories_id =  $request->room_histories_id;
            $roomDetails->employe_id =  $room_emp->employee_id;
            
            $roomDetails->is_delay =  $request->is_delay == 'on' ? 1 : 0;
            $roomDetails->room_id =  $request->room_id;
            $roomDetails->day =   $cycle->day;
            $roomDetails->cycle_name =  $cycle->name;

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
            'room_id' => 'required',
            'start_date' => 'required|max:350'
        ]);

        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }
        $roomS = Room::where('id', $request->room_id)->first();

        if($roomS->status == 0){
            $room = new RoomHistory;
            $room->room_id = $request->room_id;
            $room->start_date = $request->start_date;
            $room->created_by =  Auth::user()->id;
            $room->updated_by =  Auth::user()->id;
            $room->status = 1;
            if($room->save()){
                $this->room_status_update($roomS->id, 1);

                return response()->json(['status' => 'success', 'message'=> 'Data insert success.']);
            }else{
                return response()->json(['status' => 'error', 'message'=> 'Data insert failed.']);
            }
        }
        return response()->json(['status' => 'error', 'message'=> 'Room already Occupied.']);

    }

    public function destory(Request $request){
        $roomH = RoomHistory::where('id', $request->id)->first();
        if(!is_null($roomH)){
            $this->room_status_update($roomH->room_id, 0);
        }
        
        
        if(RoomHistory::destroy($request->id)){
            return response()->json(['status' => 'success', 'message' => 'Data deleted successully.']);   
        }else{
            return response()->json(['status' => 'warning', 'message' => 'Data Not found.']);
        }
    }

    public function room_status_update($room_id, $status = 0){
        $roomS = Room::where('id', $room_id)->first();
        if(!is_null($roomS)){
            if($status == 1){
                $roomS->status=1;
                $roomS->save();
            }else if($status == 0){
                $roomS->status=0;
                $roomS->save();
            } 
        }
    }

}

