<?php

namespace App\Http\Controllers\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Validator;

class TemplateController extends Controller
{
    
    function __construct(){
       
        $this->middleware('permission:templates', ['only' => ['index','get_ajax_templates']]);
        $this->middleware('permission:add-templates', ['only' => ['create','store']]);
        $this->middleware('permission:edit-templates', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-templates', ['only' => ['destroy']]);
        
    }

    public function index(){
        $page['title'] = 'Show all Template';
        $page['name'] = 'Template';
        return view('backend.modules.settings.templates.show', compact('page'));
    }

    public function get_ajax_templates(Request $request){
   
        if($request->page != 1){$start = $request->page * 25;}else{$start = 0;}
        $search = $request->search;
        $sort = $request->sort;

        $data = Post::where('title','!=','')->where('type', 'blade_template');
        if($search != ''){
            $data->where('title', 'like', '%'.$search.'%');
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
        return view('backend.modules.settings.templates.ajax_files', compact('data'));
    }

    public function edit(Request $request){
        $data = Post::where('id', $request->id)->first();
        return view('backend.modules.settings.templates.edit', compact('data'));
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:350',
            'template' => 'required|max:350',
        ]);


        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }
        $page =  Post::findOrFail($request->id);
        $page->title          = $request->title;
        $page->template = $request->template;

        if($page->save()){
                return response()->json(['status' => 'success', 'message'=> 'Data update success.']);
        }else{
            return response()->json(['status' => 'error', 'message'=> 'Data update failed.']);
        }
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:350',
            'template' => 'required|max:350'
        ]);


        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }
        
        $slug = dsld_generate_slug_by_text_with_model('App\Models\Post', 'template-'.$request->title, 'slug');
        $page = new Post;
        $page->title = $request->title;
        $page->key_title = $request->title;
        $page->slug = $slug;
        $page->type = 'blade_template';
        $page->template =  $request->template;
        $page->status = 1;
        
        if($page->save()){
            return response()->json(['status' => 'success', 'message'=> 'Data insert success.']);
        }else{
            return response()->json(['status' => 'error', 'message'=> 'Data insert failed.']);
        }
    }

    public function destory(Request $request){
        if(Post::destroy($request->id)){
            return response()->json(['status' => 'success', 'message' => 'Data deleted successully.']);   
        }else{
            return response()->json(['status' => 'warning', 'message' => 'Data Not found.']);
        }
       
    }
    
}
