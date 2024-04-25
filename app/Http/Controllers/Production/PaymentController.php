<?php

namespace App\Http\Controllers\Production;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User, Grade, Production, Sale, Room, Order, Payment};
use Validator, Hash, Auth, Illuminate\Support\Facades\DB;
use Pdf;
use Carbon\Carbon;


class PaymentController extends Controller
{

    function __construct(){
        $this->middleware('permission:payment', ['only' => ['index','get_ajax_payments']]);
        $this->middleware('permission:add-payment', ['only' => ['create','store']]);
        $this->middleware('permission:edit-payment', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-payment', ['only' => ['destroy']]);
    }
    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'vendor_id' => 'required|integer|min:1',
            'order_id' => 'required|array|min:1',
            'payment_mode' => 'required|min:1',
            'emp_id' => 'required|integer|min:1',
            'grand_total' => 'required|min:1',
            'payable_amount' => 'required|min:1',
            'balance' => 'required|min:1',
        ]);

       
        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
        }
        $pay = Payment::where('type', $request->type)->whereJsonContains('orders_id', $request->order_id)->where('vendor_id', $request->vendor_id)->where('pay_to', $request->emp_id)->where('status', $request->status)->orderBy('created_at', 'desc')->first();

        if(!empty($pay)){
            return response()->json(['status' => 'error', 'message' => 'Already generated.']);
        }
       
        $payment = new Payment;
        $payment->type = $request->type;
        $payment->vendor_id = $request->vendor_id;
        $payment->orders_id = json_encode($request->order_id);
        $payment->payment_mode = $request->payment_mode;
        $payment->pay_to = $request->emp_id;
        $payment->amount = $request->grand_total;
        $payment->tax = 0;
        $payment->grand_total = $payment->amount + $payment->tax;
        $payment->payable_amount = $request->payable_amount;
        $payment->balance = $request->balance;
        $payment->invoices = 1;
        $payment->status = $request->status;
        $payment->save();
        
        foreach($request->order_id as $key => $value){
        
            Order::where('id', $value)->update(['paid' => 1, 'created_invoices' => 1]);
        }
        return response()->json(['status' => 'success', 'message'=> 'Data insert success.']);

    }

}