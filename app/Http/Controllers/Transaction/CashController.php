<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\TypeInterfaces;
use Validator;
use Hash;

class CashController extends Controller
{
    protected $typeIn;
    function __construct(TypeInterfaces $type){

        $this->typeIn = $type;
        $this->middleware('permission:cash', ['only' => ['index','get_ajax_cashs']]);
        $this->middleware('permission:add-cash', ['only' => ['create','store']]);
        $this->middleware('permission:edit-cash', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-cash', ['only' => ['destroy']]);
        
    }

    public function index(){
        $page['title'] = 'Show all Cash';
        $page['name'] = 'Cash';
        return view('backend.modules.transactions.cash.show', compact('page'));
    }

    public function get_ajax_cash_imprest(Request $request){
        $data = $this->typeIn->all($request, 'payment_mode');
        return view('backend.modules.transactions.cash.ajax_files', compact('data'));
    }

    public function edit(Request $request){
        $data = $this->typeIn->find($request->id);
        return view('backend.modules.transactions.cash.edit', compact('data'));
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:350',
            'status' => 'required|integer',
        ]);


        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }
        $data = $this->typeIn->update($request->id, $request->all());

        if($data =='success'){
                return response()->json(['status' => 'success', 'message'=> 'Data update success.']);
        }else{
            return response()->json(['status' => 'error', 'message'=> 'Data update failed.']);
        }
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:350',
        ]);

        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }

        $data = $this->typeIn->store($request->all());
        if($data =='success'){
            return response()->json(['status' => 'success', 'message'=> 'Data insert success.']);
        }else{
            return response()->json(['status' => 'error', 'message'=> 'Data insert failed.']);
        }
    }

    public function destory(Request $request){

        $page = $this->typeIn->destory($request->id);

        if($page){
            return response()->json(['status' => 'success', 'message' => 'Data deleted successully.']);   
        }else{
            return response()->json(['status' => 'warning', 'message' => 'Data Not found.']);
        }
       
    }
    
}
