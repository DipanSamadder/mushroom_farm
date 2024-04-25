<?php

namespace App\Http\Controllers\Production;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User, Grade, Production, Sale, Room, Order};
use Validator, Hash, Auth, Illuminate\Support\Facades\DB;
use Pdf;
use Carbon\Carbon;


class SalesController extends Controller
{

    function __construct(){
        $this->middleware('permission:sale', ['only' => ['index','get_ajax_sales']]);
        $this->middleware('permission:add-sale', ['only' => ['create','store']]);
        $this->middleware('permission:edit-sale', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-sale', ['only' => ['destroy']]);
    }

    public function index(){
        $page['title'] = 'Show all sale';
        $page['name'] = 'sale';
        $startOfDay = Carbon::today()->startOfDay();
        $endOfDay = Carbon::today()->endOfDay();
        $grades = Grade::get();
        return view('backend.modules.sales.show', compact('page','grades'));
    }

    public function get_ajax_sales(Request $request){
   
        if($request->page != 1){$start = $request->page * 25;}else{$start = 0;}
  
        $sort = $request->sort;
      
        $data = Order::where('vendor_id','!=','');

     
        if($sort != 'all'){
            switch ($request->sort) {
                case 'today':
                    $startOfDay = Carbon::today()->startOfDay();
                    $endOfDay = Carbon::today()->endOfDay();
                    $data = $data->whereBetween('created_at', [$startOfDay, $endOfDay]);
                    break;
                case 'yesterday':
                    $startOfDay = Carbon::yesterday()->startOfDay();
                    $endOfDay = Carbon::yesterday()->endOfDay();
                    $data = $data->whereBetween('created_at', [$startOfDay, $endOfDay]);
                    break;
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

        $data = $data->paginate(25);

        return view('backend.modules.sales.ajax_files', compact('data'));
    }


    public function production_edit(Request $request){
        $room_id = $request->id;
        return view('backend.modules.room.edit_productions', compact('room_id'));
    }

    public function edit(Request $request){
        $vendor = $request->rid;
        $startOfDay = Carbon::today()->startOfDay();
        $endOfDay = Carbon::today()->endOfDay();
        $grades = Grade::get();
        $orders = Order::where('vendor_id', $vendor)->whereBetween('created_at', [$startOfDay, $endOfDay])->first();
        $data = Sale::where('rooms_id', $orders->id)->where('vendor_id', $vendor)->whereBetween('created_at', [$startOfDay, $endOfDay])->first();
        return view('backend.modules.sales.edit', compact('data', 'orders', 'grades', 'vendor'));
    }

    public function edit_bluk(Request $request){
        $rid = $request->rid;
        $gid = $request->gid;
        $data = Sale::where('rooms_id', $request->rid)->where('grades_id', $request->gid)->first();
        return view('backend.modules.sales.edit_bluk', compact('data', 'rid', 'gid'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'vendor_id' => 'required|integer|min:1',
            'qty' => 'required|integer|min:1',
            'grades_rate' => 'required|min:1',
            'grades_id' => 'required|integer|min:1',
        ]);

       
        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
        }
        $sum =  0;
        $vType =  0;

        if(!is_null($request->categories_id)){
            $vType =  $request->categories_id;
        }else{
            $vendor = dsld_vendor_details_by_user($request->vendor_id);
            $vType = $vendor->purchase_from;
        }
        
        $uVendor =  $request->vendor_id;

        $startOfDay = Carbon::today()->startOfDay();
        $endOfDay = Carbon::today()->endOfDay();
        $grade = Grade::where('id', $request->grades_id)->first();
       
        
        
        $sale = Sale::where('grades_id',  $request->grades_id)->where('vendor_id', $uVendor)->whereBetween('created_at', [$startOfDay, $endOfDay])->first();

        $production = Production::where('rooms_id', $request->rooms_id)->where('grades_id',  $request->grades_id)->first();
        $checkStock = dsld_total_stock($request->grades_id);
       
        if(is_null($sale)){
            if($checkStock < $request->qty ){
                return response()->json(['status' => 'error', 'message' => 'Plase check stocks']);
            }
        }
        
        $updated_grade_rate = $grade->rate;
        
        if($request->grades_rate == $grade->rate){
            $updated_grade_rate =  $grade->rate;
        }else{
            $updated_grade_rate =  $request->grades_rate;
        }

      
        $rate = $request->qty * $updated_grade_rate;
        $expense = 0 ;
        $total = $rate - $expense;

        if(is_null($sale)){
           
            $orderDetails = dsld_order_update($vType, $uVendor);
            $sale = new Sale;
            $sale->rooms_id =  $orderDetails->id;
            $sale->grades_id =  $request->grades_id;
            $sale->categories_id =  $vType;
            $sale->vendor_id =  $uVendor;
            $sale->grades_rate =  $updated_grade_rate;
            $sale->rate =  $rate;
            $sale->qty =  $request->qty;
            $sale->expense =  0;
            $sale->total =  $total;
            $sale->created_by =  Auth::user()->id;
            $sale->updated_by =  Auth::user()->id;
            $sale->save();
          
        }else{

            $sale->categories_id =  $vType;
            $sale->vendor_id =  $uVendor;
            $sale->grades_rate =  $updated_grade_rate;
            $sale->rate =  $rate;
            $sale->qty =  $request->qty;
            $sale->expense =  0;
            $sale->total =  $total;
            $sale->updated_by =  Auth::user()->id;
            $sale->save();
    
            dsld_order_update($vType, $uVendor);
        }

        return response()->json(['status' => 'success', 'message'=> 'Data insert success.']);

    }
   
    public function store_bk(Request $request){
        $validator = Validator::make($request->all(), [
            'qty' => 'required|array|min:1',
            'rooms_id' => 'required|integer',
            'grades_id' => 'required|integer',
            'category' => 'required|array|min:1',
        ]);


        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }
        $sum =  0;
        foreach($request->category as $key => $value){

            $grade = Grade::where('id', $request->grades_id)->first();
            $sale = Sale::where('rooms_id', $request->rooms_id)->where('grades_id',  $request->grades_id)->where('categories_id',  $value)->first();

            $production = Production::where('rooms_id', $request->rooms_id)->where('grades_id',  $request->grades_id)->first();
            if (is_array($request->qty[$key]) && count($request->qty[$key]) > 0) {
                $sum = array_sum($request->qty[$key]);
                if($production->qty[$key] < $sum){
                    return response()->json(['status' => 'error', 'message' => 'Plase check stocks']);
                }
            }

            $uVendor  = 0 ;

            $updated_grade_rate = $grade->rate;
            
            if($request->grades_rate[$key] == $grade->rate){
                $updated_grade_rate =  $grade->rate;
            }else{
                $updated_grade_rate =  $request->grades_rate[$key];
            }

            if(!is_null($request->vendor_id[$key])){
                $uVendor =  $request->vendor_id[$key];
            }

            $rate = $request->qty[$key] * $updated_grade_rate;
            $expense = 0 ;
            $total = $rate - $expense;

            if(is_null( $sale)){
                $sale = new Sale;
                $sale->rooms_id = $request->rooms_id;
                $sale->grades_id =  $request->grades_id;
                $sale->categories_id =  $value;
                $sale->vendor_id =  $uVendor;
                $sale->grades_rate =  $updated_grade_rate;
                $sale->rate =  $rate;
                $sale->qty =  $request->qty[$key];
                $sale->expense =  0;
                $sale->total =  $total;
                $sale->created_by =  Auth::user()->id;
                $sale->updated_by =  Auth::user()->id;
                $sale->save();
            }else{
                $sale->categories_id =  $value;
                $sale->vendor_id =  $uVendor;
                $sale->grades_rate =  $updated_grade_rate;
                $sale->rate =  $rate;
                $sale->qty =  $request->qty[$key];
                $sale->expense =  0;
                $sale->total =  $total;
                $sale->updated_by =  Auth::user()->id;
                $sale->save();
            }
        }
        return response()->json(['status' => 'success', 'message'=> 'Data insert success.']);

    }
    
    public function bluk_store(Request $request){
        $validator = Validator::make($request->all(), [
            'grades_id' => 'required|integer',
            'room_id' => 'required|integer',
        ]);


        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }
        $sum =  0;

        $cate_array = $request->input('cate_' . $request->grades_id);
        foreach($cate_array as $key => $value){

            $grade = Grade::where('id', $request->grades_id)->first();
            $sale = Sale::where('rooms_id', $request->room_id)->where('grades_id',  $request->grades_id)->where('categories_id',  $value)->first();
            $production = Production::where('rooms_id', $request->room_id)->where('grades_id',  $request->grades_id)->first();

            $qty = $request->input('qty_' . $request->grades_id);
            $grades_rate = $request->input('grades_rate_' . $request->grades_id);
            $vendor_id = $request->input('vendor_id_' . $request->grades_id);

            if (is_array($qty[$key]) && count($qty[$key]) > 0) {
                $sum = array_sum($qty[$key]);
                if($production->qty < $sum){
                    return response()->json(['status' => 'error', 'message' => 'Plase check stocks']);
                }
            }
            $uVendor  = 0 ;

            $updated_grade_rate = $grade->rate;
            if($grades_rate[$key] == $grade->rate){
                $updated_grade_rate =  $grade->rate;
            }else{
                $updated_grade_rate =  $grades_rate[$key];
            }

            if(!is_null($vendor_id[$key])){
                $uVendor =  $vendor_id[$key];
            }

            $rate = $qty[$key] * $updated_grade_rate;
            $expense = 0 ;
            $total = $rate - $expense;

            if(is_null( $sale)){
                $sale = new Sale;
                $sale->rooms_id = $request->room_id;
                $sale->grades_id =  $request->grades_id;
                $sale->categories_id =  $value;
                $sale->vendor_id =  $uVendor;
                $sale->grades_rate =  $updated_grade_rate;
                $sale->rate =  $rate;
                $sale->qty =  $qty[$key];
                $sale->expense =  0;
                $sale->total =  $total;
                $sale->created_by =  Auth::user()->id;
                $sale->updated_by =  Auth::user()->id;
                $sale->save();
            }else{
                $sale->categories_id =  $value;
                $sale->vendor_id =  $uVendor;
                $sale->grades_rate =  $updated_grade_rate;
                $sale->rate =  $rate;
                $sale->qty =  $qty[$key];
                $sale->expense =  0;
                $sale->total =  $total;
                $sale->updated_by =  Auth::user()->id;
                $sale->save();
            }
        }

       
        // foreach($request->category as $key => $value){

        //     $grade = Grade::where('id', $request->grades_id)->first();
            
        //     $production = Production::where('rooms_id', $request->rooms_id)->where('grades_id',  $request->grades_id)->first();
        //     if (is_array($request->qty) && count($request->qty) > 0) {
        //         $sum = array_sum($request->qty);
        //         if($production->qty < $sum){
        //             return response()->json(['status' => 'error', 'message' => 'Plase check stocks']);
        //         }
        //     }
        //     $rate = $request->qty[$key] * $grade->rate;
        //     $expense = 0 ;
        //     $total = $rate - $expense;
        //     if(is_null( $sale)){
        //         $sale = new Sale;
        //         $sale->rooms_id = $request->rooms_id;
        //         $sale->grades_id =  $request->grades_id;
        //         $sale->categories_id =  $value;
        //         $sale->vendor_id =  $request->vendor_id;
        //         $sale->grades_rate =  $grade->rate;
        //         $sale->rate =  $rate;
        //         $sale->qty =  $request->qty[$key];
        //         $sale->expense =  0;
        //         $sale->total =  $total;
        //         $sale->created_by =  Auth::user()->id;
        //         $sale->updated_by =  Auth::user()->id;
        //         $sale->save();
        //     }else{
        //         $sale->categories_id =  $value;
        //         $sale->vendor_id =  $request->vendor_id;
        //         $sale->rate =  $rate;
        //         $sale->qty =  $request->qty[$key];
        //         $sale->expense =  0;
        //         $sale->total =  $total;
        //         $sale->updated_by =  Auth::user()->id;
        //         $sale->save();
        //     }
        // }
        return response()->json(['status' => 'success', 'message'=> 'Data insert success.']);

    }
    public function stock_view(){
        $startOfDay = Carbon::today()->startOfDay();
        $endOfDay = Carbon::today()->endOfDay();
        $grades = Grade::get();
        return view('backend.modules.sales.stock_tables', compact('grades'));
    }
    public function add(Request $request){
        dd($request->all());
    }
    
    public function generateInvoicePdf($invoiceData) {
        $invoice = $invoiceData;
        $pdf = PDF::loadView('backend.invoices.sale-invoice', compact('invoice'));
        return $pdf->stream('invoice.pdf', array('Attachment' => false));
    }


}
