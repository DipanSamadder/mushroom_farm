<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Allowance;
use App\Models\Permission;
use Validator;
use Hash;

class AllowanceController extends Controller
{
   
    function __construct(){
       
        $this->middleware('permission:allowances', ['only' => ['index','get_ajax_allowances']]);
        $this->middleware('permission:add-allowance', ['only' => ['create','store']]);
        $this->middleware('permission:edit-allowance', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-allowance', ['only' => ['destroy']]);
        
    }

    public function index(){
        $page['title'] = 'Show all Allowance';
        $page['name'] = 'Allowance';
        return view('backend.modules.allowance.show', compact('page'));
    }

    public function get_ajax_allowances(Request $request){
   
        if($request->page != 1){$start = $request->page * 25;}else{$start = 0;}
        $search = $request->search;
        $sort = $request->sort;

        $data = Allowance::where('name','!=','');
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
        return view('backend.modules.allowance.ajax_files', compact('data'));
    }

    public function edit(Request $request){
        $data = Allowance::where('id', $request->id)->first();
        return view('backend.modules.allowance.edit', compact('data'));
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:350',
            'amount' => 'required|integer',
            'status' => 'required|integer',
        ]);


        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }
        $deduct =  Allowance::findOrFail($request->id);
        $deduct->name = $request->name;
        $deduct->amount =  $request->amount;
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
            'amount' => 'required|integer',
        ]);


        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }
     
        $labour = new Allowance;
        $labour->name = $request->name;
        $labour->amount =  $request->amount;
        $labour->status = 1;
        
        if($labour->save()){
            return response()->json(['status' => 'success', 'message'=> 'Data insert success.']);
        }else{
            return response()->json(['status' => 'error', 'message'=> 'Data insert failed.']);
        }
    }

    public function destory(Request $request){
        if(Allowance::destroy($request->id)){
            return response()->json(['status' => 'success', 'message' => 'Data deleted successully.']);   
        }else{
            return response()->json(['status' => 'warning', 'message' => 'Data Not found.']);
        }
       
    }
    
}
