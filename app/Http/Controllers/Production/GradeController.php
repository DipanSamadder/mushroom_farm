<?php

namespace App\Http\Controllers\Production;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Grade;
use App\Models\Permission;
use Validator;
use Hash;

class GradeController extends Controller
{
   
    function __construct(){
       
        $this->middleware('permission:grade', ['only' => ['index','get_ajax_grades']]);
        $this->middleware('permission:add-grade', ['only' => ['create','store']]);
        $this->middleware('permission:edit-grade', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-grade', ['only' => ['destroy']]);
        
    }

    public function index(){
        $page['title'] = 'Show all Grade';
        $page['name'] = 'Grade';
        return view('backend.modules.grade.show', compact('page'));
    }

    public function get_ajax_grades(Request $request){
   
        if($request->page != 1){$start = $request->page * 25;}else{$start = 0;}
        $search = $request->search;
        $sort = $request->sort;

        $data = Grade::where('name','!=','');
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
        return view('backend.modules.grade.ajax_files', compact('data'));
    }

    public function edit(Request $request){
        $data = Grade::where('id', $request->id)->first();
        return view('backend.modules.grade.edit', compact('data'));
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:350',
            'rate' => 'required|numeric',
            'status' => 'required|integer',
        ]);


        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }
        $deduct =  Grade::findOrFail($request->id);
        $deduct->name = $request->name;
        $deduct->rate =  $request->rate;
        $deduct->status =  $request->status;

        if($deduct->save()){
                return response()->json(['status' => 'success', 'message'=> 'Data update success.']);
        }else{
            return response()->json(['status' => 'error', 'message'=> 'Data update failed.']);
        }
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:350',
            'rate' => 'required|integer',
        ]);


        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }
     
        $labour = new Grade;
        $labour->name = $request->name;
        $labour->rate =  $request->rate;
        $labour->status = 1;
        
        if($labour->save()){
            return response()->json(['status' => 'success', 'message'=> 'Data insert success.']);
        }else{
            return response()->json(['status' => 'error', 'message'=> 'Data insert failed.']);
        }
    }

    public function destory(Request $request){
        if(Grade::destroy($request->id)){
            return response()->json(['status' => 'success', 'message' => 'Data deleted successully.']);   
        }else{
            return response()->json(['status' => 'warning', 'message' => 'Data Not found.']);
        }
       
    }
    
}
