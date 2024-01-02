<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LabourRate;
use App\Models\Permission;
use Validator;
use Hash;

class LabourController extends Controller
{
   
    function __construct(){
       
        $this->middleware('permission:labours', ['only' => ['index','get_ajax_labours']]);
        $this->middleware('permission:add-labour', ['only' => ['create','store']]);
        $this->middleware('permission:edit-labour', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-labour', ['only' => ['destroy']]);
        
    }

    public function index(){
        $page['title'] = 'Show all Labours';
        $page['name'] = 'Labours';
        return view('backend.modules.labour.show', compact('page'));
    }

    public function get_ajax_labour(Request $request){
   
        if($request->page != 1){$start = $request->page * 25;}else{$start = 0;}
        $search = $request->search;
        $sort = $request->sort;

        $data = LabourRate::where('name','!=','');
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
        return view('backend.modules.labour.ajax_files', compact('data'));
    }

    public function edit(Request $request){
        $data = LabourRate::where('id', $request->id)->first();
        return view('backend.modules.labour.edit', compact('data'));
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:350',
            'type' => 'required|max:350',
            'prices' => 'required|max:350'
        ]);


        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }
        $labour =  LabourRate::findOrFail($request->id);
        $labour->name = $request->name;
        $labour->type =  $request->type;
        $labour->prices =  $request->prices;
        $labour->status =  $request->status;

        if($labour->save()){
                return response()->json(['status' => 'success', 'message'=> 'Data update success.']);
        }else{
            return response()->json(['status' => 'error', 'message'=> 'Data update failed.']);
        }
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:350',
            'type' => 'required|max:350',
            'prices' => 'required|max:350'
        ]);


        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }
     
        $labour = new LabourRate;
        $labour->name = $request->name;
        $labour->type =  $request->type;
        $labour->prices =  $request->prices;
        $labour->status = 1;
        
        if($labour->save()){
            return response()->json(['status' => 'success', 'message'=> 'Data insert success.']);
        }else{
            return response()->json(['status' => 'error', 'message'=> 'Data insert failed.']);
        }
    }

    public function destory(Request $request){
        if(LabourRate::destroy($request->id)){
            return response()->json(['status' => 'success', 'message' => 'Data deleted successully.']);   
        }else{
            return response()->json(['status' => 'warning', 'message' => 'Data Not found.']);
        }
       
    }
    
}
