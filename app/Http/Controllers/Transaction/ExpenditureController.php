<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Interfaces\TransactionInterfaces;
use Validator;
use Hash;

class ExpenditureController extends Controller
{
    protected $transection;
    function __construct(TransactionInterfaces $transections){
        $this->transection = $transections;
        $this->middleware('permission:exprenditure', ['only' => ['index','get_ajax_exprenditures']]);
        $this->middleware('permission:add-exprenditure', ['only' => ['create','store']]);
        $this->middleware('permission:edit-exprenditure', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-exprenditure', ['only' => ['destroy']]);  
    }


    public function index(){
        $page['title'] = 'Show all Expenditure';
        $page['name'] = 'Expenditure';
        return view('backend.modules.transactions.expenditure.show', compact('page'));
    }

    public function get_ajax_cash_imprest(Request $request){
        $data = $this->transection->all($request, 'expenditure');
        return view('backend.modules.transactions.expenditure.ajax_files', compact('data'));
    }

    public function edit(Request $request){
        $data = $this->transection->find($request->id);
        return view('backend.modules.transactions.expenditure.edit', compact('data'));
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'purpose' => 'required|max:350',
            'payment_mode' => 'required|max:350',
            'emp_id' => 'required|integer',
            'amount' => 'required|numeric',
            'date' => 'required|max:350',
            'updated_by' => 'required|max:350',
        ]);

        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }
        $data = $this->transection->update($request->id, $request->all());

        if($data =='success'){
                return response()->json(['status' => 'success', 'message'=> 'Data update success.']);
        }else{
            return response()->json(['status' => 'error', 'message'=> 'Data update failed.']);
        }
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'purpose' => 'required|max:350',
            'created_by' => 'required|max:350',
            'payment_mode' => 'required|max:350',
            'emp_id' => 'required|integer',
            'amount' => 'required|numeric',
            'date' => 'required|max:350',
        ]);

        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }
     
        $data = $this->transection->store($request->all());
        if($data =='success'){
            return response()->json(['status' => 'success', 'message'=> 'Data insert success.']);
        }else{
            return response()->json(['status' => 'error', 'message'=> 'Data insert failed.']);
        }
    }

    public function destory(Request $request){
        $page = $this->transection->destory($request->id);

        if($page){
            return response()->json(['status' => 'success', 'message' => 'Data deleted successully.']);   
        }else{
            return response()->json(['status' => 'warning', 'message' => 'Data Not found.']);
        }
       
    }
    
    
}
