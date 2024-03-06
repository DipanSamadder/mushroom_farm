<?php



namespace App\Http\Controllers\Production;



use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\User;

use App\Models\ProCategory;

use App\Models\Permission;

use Validator;

use Hash;



class CategoryController extends Controller

{

   

    function __construct(){

       

        $this->middleware('permission:pro_categorie', ['only' => ['index','get_ajax_pro_categories']]);

        $this->middleware('permission:add-pro_categorie', ['only' => ['create','store']]);

        $this->middleware('permission:edit-pro_categorie', ['only' => ['edit','update']]);

        $this->middleware('permission:delete-pro_categorie', ['only' => ['destroy']]);

        

    }



    public function index(){

        $page['title'] = 'Show all Category';

        $page['name'] = 'Category';

        return view('backend.modules.pro_categories.show', compact('page'));

    }



    public function get_ajax_pro_categories(Request $request){

   

        if($request->page != 1){$start = $request->page * 25;}else{$start = 0;}

        $search = $request->search;

        $sort = $request->sort;



        $data = ProCategory::where('name','!=','');

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

        return view('backend.modules.pro_categories.ajax_files', compact('data'));

    }



    public function edit(Request $request){

        $data = ProCategory::where('id', $request->id)->first();

        return view('backend.modules.pro_categories.edit', compact('data'));

    }



    public function update(Request $request){

        $validator = Validator::make($request->all(), [

            'name' => 'required|max:350',

            'status' => 'required|integer',

        ]);





        if($validator->fails()) {

            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);

        }

        $deduct =  ProCategory::findOrFail($request->id);

        $deduct->name = $request->name;

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

        ]);





        if($validator->fails()) {

            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);

        }

     

        $labour = new ProCategory;

        $labour->name = $request->name;

        $labour->status = 1;

        

        if($labour->save()){

            return response()->json(['status' => 'success', 'message'=> 'Data insert success.']);

        }else{

            return response()->json(['status' => 'error', 'message'=> 'Data insert failed.']);

        }

    }



    public function destory(Request $request){

        if(ProCategory::destroy($request->id)){

            return response()->json(['status' => 'success', 'message' => 'Data deleted successully.']);   

        }else{

            return response()->json(['status' => 'warning', 'message' => 'Data Not found.']);

        }

       

    }

    

}

