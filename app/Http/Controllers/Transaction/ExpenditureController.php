<?php



namespace App\Http\Controllers\Transaction;



use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Expenditure;

use App\Interfaces\ExpenditureInterfaces;

use App\Models\Transaction;

use Validator;

use Hash;



class ExpenditureController extends Controller

{

    protected $expenditure;

    function __construct(ExpenditureInterfaces $expenditures){

        $this->expenditure = $expenditures;



        $this->middleware('permission:expenditure', ['only' => ['index','get_ajax_expenditure']]);

        $this->middleware('permission:add-expenditure', ['only' => ['create','store']]);

        $this->middleware('permission:edit-expenditure', ['only' => ['edit','update']]);

        $this->middleware('permission:delete-expenditure', ['only' => ['destroy']]);  

    }





    public function index(){

        $page['title'] = 'Show all Expenditure';

        $page['name'] = 'Expenditure';

        return view('backend.modules.transactions.expenditure.show', compact('page'));

    }



    public function get_ajax_expenditure(Request $request){

        $data = $this->expenditure->all($request, 'expenditure');

        return view('backend.modules.transactions.expenditure.ajax_files', compact('data'));

    }



    public function edit(Request $request){

        $data = $this->expenditure->find($request->id);



        $transaction = array();

        if($data->payment_id !=  0){

            $transaction = Transaction::where('id', $data->payment_id)->first();

        }

        

        return view('backend.modules.transactions.expenditure.edit', compact('data','transaction'));

    }



    public function update(Request $request){



        $validator = Validator::make($request->all(), [

            'id' => 'required|integer',

            'delivery_date' => 'required|max:350',

            'purpose' => 'required|max:350',

            'amount' => 'required|numeric',

            'payamount' => 'required|numeric',



            'work_type' => 'required|max:350',

            'vendor_id' => 'required|numeric',

            'payment_mode' => 'required|max:350',

            'date' => 'required|max:350',

            'updated_by' => 'required|max:350',

            'transaction_id' => 'required|max:350',

            'status' => 'required|numeric',

        ]);



        if($validator->fails()) {

            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);

        }



        $edata = $this->expenditure->find($request->id);



        if(!is_null($edata)){



            if(!is_null($edata->payment_id) && $edata->payment_id != 0){    



                $tr = Transaction::where('id', $edata->payment_id)->where('category', 'expenditures')->first();

                if(!is_null($tr)){

                    $tr->emp_id = $request->vendor_id;

                    $tr->type = ($request->work_type == 'purchase') ? 'debit' : 'credit';

                    $tr->payment_mode = $request->payment_mode;

                    $tr->transaction_id = $request->transaction_id;

                    $tr->purpose = $request->purpose;

                    $tr->payee_name = $request->payee_name;

                    $tr->amount = $request->payamount ? $request->payamount : $request->amount ;

                    $tr->date = $request->date;

                    $tr->status = $request->status;

                    $tr->save();

    

                    $this->balance_update($edata->payment_id);

                }else{

                    $tr = new Transaction;

                    $tr->category = 'expenditures';

                    $tr->type = $request->work_type == 'purchase' ? 'debit' : 'credit';

                    $tr->emp_id = $request->vendor_id;

                    $tr->payment_mode = $request->payment_mode;

                    $tr->transaction_id = $request->transaction_id;

                    $tr->purpose = $request->purpose;

                    $tr->payee_name = $request->payee_name;

                    $tr->amount = $request->payamount ? $request->payamount : $request->amount ;

                    $tr->date = $request->date;

                    $tr->status = $request->status;

                    $tr->save();

    

                    $this->balance_update($tr->id);

                    $request->merge(['payment_id' => $tr->id]);

                }

                



            }else{



                $tr = new Transaction;

                $tr->category = 'expenditures';

                $tr->type = $request->work_type == 'purchase' ? 'debit' : 'credit';

                $tr->emp_id = $request->vendor_id;

                $tr->payment_mode = $request->payment_mode;

                $tr->transaction_id = $request->transaction_id;

                $tr->purpose = $request->purpose;

                $tr->payee_name = $request->payee_name;

                $tr->amount = $request->payamount ? $request->payamount : $request->amount ;

                $tr->date = $request->date;

                $tr->status = $request->status;

                $tr->save();



                $this->balance_update($tr->id);



                $request->merge(['payment_id' => $tr->id]);

            }



        }



        

        $data = $this->expenditure->update($request->id, $request->all());



        if($data =='success'){

                return response()->json(['status' => 'success', 'message'=> 'Data update success.']);

        }else{

            return response()->json(['status' => 'error', 'message'=> 'Data update failed.']);

        }



    }





    public function store(Request $request){



        $validator = Validator::make($request->all(), [

            'invoice_date' => 'required|max:350',

            'delivery_date' => 'required|max:350',

            'purpose' => 'required|max:350',

            'amount' => 'required|numeric',

            'work_type' => 'required|max:350',

            'vendor_id' => 'required|max:350',

            'created_by' => 'required|max:350',

        ]);



        if($validator->fails()) {

            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);

        }

     

        $data = $this->expenditure->store($request->all());

        if($data =='success'){

            return response()->json(['status' => 'success', 'message'=> 'Data insert success.']);

        }else{

            return response()->json(['status' => 'error', 'message'=> 'Data insert failed.']);

        }

    }



    public function destory(Request $request){



        $page = $this->expenditure->destory($request->id);



        if($page){

            return response()->json(['status' => 'success', 'message' => 'Data deleted successully.']);   

        }else{

            return response()->json(['status' => 'warning', 'message' => 'Data Not found.']);

        }

       

    }

    



    public function balance_update($id){

        $previousBalance = 0;



        $rowsToUpdate = Transaction::where('id', '>=', $id)->where('category', 'expenditures')->get();

        $previousRow = Transaction::where('id', '<', $id)->where('category', 'expenditures')->latest('id')->first();



        if(!is_null($previousRow)){

            $previousBalance = $previousRow->balance;

        }



        foreach ($rowsToUpdate as $row) {

            

            if($row->type == 'debit'){

               $row->balance = $previousBalance - floatval($row->amount);

            }else{

               $row->balance = $previousBalance + floatval($row->amount);

            }

            $row->save();

            $previousBalance = $row->balance;

            

        }



    }

    

}

