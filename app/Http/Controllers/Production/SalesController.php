<?php

namespace App\Http\Controllers\Production;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Grade;
use App\Models\Production;
use App\Models\Sale;
use App\Models\Room;
use Validator, Hash, Auth;

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
        return view('backend.modules.sales.show', compact('page'));
    }

    public function get_ajax_sales(Request $request){
   
        if($request->page != 1){$start = $request->page * 25;}else{$start = 0;}
        $search = $request->search;
        $sort = $request->sort;

        $data = Production::where('rooms_id','!=','');
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
        return view('backend.modules.sales.ajax_files', compact('data'));
    }


    public function production_edit(Request $request){
        $room_id = $request->id;
        return view('backend.modules.room.edit_productions', compact('room_id'));
    }


    public function edit(Request $request){
        $rid = $request->rid;
        $gid = $request->gid;
        $data = Sale::where('rooms_id', $request->rid)->where('grades_id', $request->gid)->first();
        return view('backend.modules.sales.edit', compact('data', 'rid', 'gid'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'qty' => 'required|integer',
            'rooms_id' => 'required|integer',
            'grades_id' => 'required|integer',
        ]);


        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }
       
        $grade = Grade::where('id', $request->grades_id)->first();
        $sale = Sale::where('rooms_id', $request->rooms_id)->where('grades_id',  $request->grades_id)->first();
        $production = Production::where('rooms_id', $request->rooms_id)->where('grades_id',  $request->grades_id)->first();
        if($production->qty < $request->qty){
            return response()->json(['status' => 'error', 'message' => 'Plase check stocks']);
        }
        $rate = $request->qty * $grade->rate;
        $expense = 0 ;
        $total = $rate - $expense;
        if(is_null( $sale)){
            $sale = new Sale;
            $sale->rooms_id = $request->rooms_id;
            $sale->grades_id =  $request->grades_id;
            $sale->categories_id =  $request->categories_id;
            $sale->vendor_id =  $request->vendor_id;
            $sale->rate =  $rate;
            $sale->qty =  $request->qty;
            $sale->expense =  0;
            $sale->total =  $total;
            $sale->created_by =  Auth::user()->id;
            $sale->updated_by =  Auth::user()->id;
            $sale->save();
        }else{
            $sale->categories_id =  $request->categories_id;
            $sale->vendor_id =  $request->vendor_id;
            $sale->rate =  $rate;
            $sale->qty =  $request->qty;
            $sale->expense =  0;
            $sale->total =  $total;
            $sale->updated_by =  Auth::user()->id;
            $sale->save();
        }
       
        return response()->json(['status' => 'success', 'message'=> 'Data insert success.']);

    }
  
}
