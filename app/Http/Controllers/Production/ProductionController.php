<?php



namespace App\Http\Controllers\Production;



use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\User;

use App\Models\Grade;

use App\Models\Production;

use App\Models\Room;

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

   

        if($request->page != 1){$start = $request->page * 25;}else{$start = 0;}

        $search = $request->search;

        $sort = $request->sort;



        $data = Room::where('status', 2);

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

        return view('backend.modules.productions.ajax_files', compact('data'));

    }





    public function production_edit(Request $request){

        $room_id = $request->id;

        return view('backend.modules.room.edit_productions', compact('room_id'));

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

            $room = Room::where('id', $request->room_id)->first();

            $room->status = 2;

            $room->save();

            if(is_null( $production)){

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

