<?php



namespace App\Http\Controllers\Production;



use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Grade;
use App\Models\Production;
use App\Models\Room;
use App\Models\RoomEmployee;
use App\Models\RoomHistory;
use App\Models\RoomCycle;
use App\Models\Cycle;
use Validator, Hash, Auth;


class ProductionController extends Controller
{

    function __construct(){

       

        $this->middleware('permission:productions', ['only' => ['index','get_ajax_productions']]);

        $this->middleware('permission:add-productions', ['only' => ['create','store']]);

        $this->middleware('permission:edit-productions', ['only' => ['edit','update']]);

        $this->middleware('permission:delete-productions', ['only' => ['destroy']]);

        

    }



    public function index(){

        $page['title'] = 'Show all Production';

        $page['name'] = 'Production';

        return view('backend.modules.productions.show', compact('page'));

    }



    public function get_ajax_productions(Request $request){

        if($request->page != 1){ $start = $request->page * 25; }else{ $start = 0; }

        $room = $request->room;
        $sort = $request->sort;

        $data = RoomHistory::where('status', 2);

        if($room != ''){
            $data->where('room_id', $room);
        }

        if($sort != ''){
            switch ($request->sort) {
                case 'newest':
                    $data->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $data->orderBy('created_at', 'asc');
                    break;
                case 'dateOldest':
                    $data->orderBy('end_date', 'asc');
                    break;
                case 'dateNewset':
                    $data->orderBy('end_date', 'desc');
                    break;
                default:
                    $data->orderBy('created_at', 'desc');
                    break;
            }

        }

        $data = $data->skip($start)->paginate(25);
        
        return view('backend.modules.productions.ajax_files', compact('data'));

    }





    public function production_edit(Request $request){

        $room_id = $request->id;

        return view('backend.modules.room_histories.edit_productions', compact('room_id'));

    }





    public function edit(Request $request){

        $data = Production::where('id', $request->id)->first();

        return view('backend.modules.productions.edit', compact('data'));

    }



    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'qty' => 'required|array|min:1',
            'room_id' => 'required|integer',
            'gid' => 'required|array|min:1',

        ]);

        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }
 
        foreach($request->gid as $key => $value){
            
            $production = Production::where('rooms_id', $request->room_id)->where('grades_id', $value)->first();

            if(is_null($production)){

                $room = RoomHistory::where('id', $request->room_id)->first();
                $room->status = 2;
                $room->end_date = now();
                $room->save();
                
                Room::where('id', $room->room_id)->update(['status'=> 0]);
                RoomCycle::where('room_histories_id', $request->room_id)->where('room_id', $room->room_id)->update(['status' => 2]);
                RoomEmployee::where('room_history_id', $request->room_id)->update(['status' => 2]);
            
                $production = new Production;
                $production->rooms_id = $request->room_id;
                $production->grades_id =  $value;
                $production->qty =  $request->qty[$key];
                $production->created_by =  Auth::user()->id;
                $production->updated_by =  Auth::user()->id;
                $production->save();

            }else{
            
                $production->rooms_id = $request->room_id;
                $production->grades_id =  $value;
                $production->qty =  $request->qty[$key];
                $production->updated_by =  Auth::user()->id;
                $production->save();

            }

        }
        return response()->json(['status' => 'success', 'message'=> 'Data insert success.']);
    }
}

