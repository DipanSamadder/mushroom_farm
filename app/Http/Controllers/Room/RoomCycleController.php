<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cycle;
use App\Models\Permission;
use Validator;
use Hash;

class RoomCycleController extends Controller
{
       
    function __construct(){
               
        $this->middleware('permission:cycle', ['only' => ['index','get_ajax_room_cycles']]);
        $this->middleware('permission:add-cycle', ['only' => ['create','store']]);
        $this->middleware('permission:edit-cycle', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-cycle', ['only' => ['destroy']]);
        
    }
    
    public function index(){
        $page['title'] = 'Show all Cycle';
        $page['name'] = 'Cycle';
        return view('backend.modules.room_cycles.show', compact('page'));
    }
    
    public function get_ajax_room_cycles(Request $request){
        
        if($request->page != 1){$start = ($request->page-1) * 25;}else{$start = 0;}
        $search = $request->search;
        $sort = $request->sort;
        
        $data = Cycle::where('name','!=','');
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
        return view('backend.modules.room_cycles.ajax_files', compact('data','start'));
    }
    
    public function edit(Request $request){
        $data = Cycle::where('id', $request->id)->first();
        return view('backend.modules.room_cycles.edit', compact('data'));
    }
    
    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:350',
            'labours_type' => 'required|integer',
            'day' => 'required|integer',
        ]);
        
        
        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }
        $cycle =  Cycle::findOrFail($request->id);
        $cycle->name = $request->name;
        $cycle->labours_type = $request->labours_type;
        $cycle->day =  $request->day;
        
        if($cycle->save()){
            return response()->json(['status' => 'success', 'message'=> 'Data update success.']);
        }else{
            return response()->json(['status' => 'error', 'message'=> 'Data update failed.']);
        }
    }
    
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:350',
            'labours_type' => 'required|integer',
            'day' => 'required|integer',
        ]);
        
        
        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }
        
        $labour = new Cycle;
        $labour->name = $request->name;
        $labour->labours_type = $request->labours_type;
        $labour->day =  $request->day;

        
        if($labour->save()){
            return response()->json(['status' => 'success', 'message'=> 'Data insert success.']);
        }else{
            return response()->json(['status' => 'error', 'message'=> 'Data insert failed.']);
        }
    }
    
    public function destory(Request $request){
        if(Cycle::destroy($request->id)){
            return response()->json(['status' => 'success', 'message' => 'Data deleted successully.']);   
        }else{
            return response()->json(['status' => 'warning', 'message' => 'Data Not found.']);
        }
        
    }
    
}
