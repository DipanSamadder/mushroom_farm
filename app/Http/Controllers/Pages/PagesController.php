<?php



namespace App\Http\Controllers\Pages;



use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Post;

use App\Models\Menu;

use App\Models\PostsSection;

use App\Models\PostsMeta;

use App\Models\PostTranslation;

use App\Interfaces\PostInterfaces;

use Validator;



class PagesController extends Controller

{

    protected $postIn;



    function __construct(PostInterfaces $post){

        $this->postIn = $post;

        $this->middleware('permission:pages|add-pages|edit-pages|delete-pages', ['only' => ['index','get_ajax_pages']]);

        $this->middleware('permission:add-pages', ['only' => ['create','store']]);

        $this->middleware('permission:edit-pages', ['only' => ['edit','update']]);

        $this->middleware('permission:delete-pages', ['only' => ['destroy']]);

    }



    public function index(){

        $page['title'] = 'Show all pages';

        return view('backend.modules.websites.pages.show', compact('page'));

    }



    public function get_ajax_pages(Request $request){

        $data = $this->postIn->all($request, 'custom_page');

        return view('backend.modules.websites.pages.ajax_pages', compact('data'));

    }





    public function store(Request $request){





        $validator = Validator::make($request->all(), [

            'title' => 'required|max:350',

            'status' => 'required|integer'

        ]);





        if($validator->fails()) {

            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);

        }

        

        $data = $this->postIn->store($request->all());

        if($data =='success'){

            return response()->json(['status' => 'success', 'message' => 'Data insert successully.']);

        }else{

            return response()->json(['status' => 'error', 'message'=> 'Data insert failed.']);

        }

       

    }



    public function edit(Request $request, $id){

        $data = $this->postIn->find($id);

        $section = $this->postIn->sections($id);

        $lang = isset($request->lang) ? $request->lang : env('DEFAULT_LANGUAGE', 'en');

        $page['title'] = 'Edit Data';
        return view('backend.modules.websites.pages.edit', compact('data', 'page', 'section', 'lang'));

    }





    public function edit_extra(Request $request){

        $lang = $request->lang;

        $data = $this->postIn->find($request->id);

        $sec = $this->postIn->sections($request->id, $request->section_id);

        return view('backend.modules.websites.pages.extra_edit', compact('sec','data', 'lang'));

    }



    

    

    public function show_custom_page($page, $slug1 = null, $slug2 = null, $slug3 = null){



        if($slug1 == '' && $slug2 == '' && $slug3 == ''){

            $page = Post::where('slug', $page)->where('status', 1)->first();

        }else if($slug2 == '' && $slug3 == ''){

            $page = Post::where('slug', $page.'/'.$slug1)->where('status', 1)->first();

        }else if($slug3 == ''){

            $page = Post::where('slug', $page.'/'.$slug1.'/'.$slug2)->where('status', 1)->first();

        }else{

            $page = Post::where('slug', $page.'/'.$slug1.'/'.$slug2.'/'.$slug3)->where('status', 1)->first();

        }



        $header_menu = Menu::where('type', 'header_menu')->where('status', 0)->orderBy('order', 'asc')->get();

        if($page != null){

             if($page->template == 'blogs_template'){

                $posts = Post::where('type', 'posts')->paginate(6);

                return view('frontend.pages.'.$page->template, compact('page', 'header_menu', 'posts'));



            }else if($page->template == 'single-leadership'){

                return view('frontend.pages.'.$page->template, compact('page', 'header_menu'));



            }else if($page->template != null){

                return view('frontend.pages.'.$page->template, compact('page', 'header_menu'));

            } else{

                 return view('frontend.pages.default', compact('page', 'header_menu'));

            }

        }else{

            return abort(404);

        }

    }



    public function update(Request $request){

        $validator = Validator::make($request->all(), [

            'title' => 'required|max:350',

            'status' => 'required|integer'

        ]);



        if($validator->fails()) {

            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);

        }



        $data = $this->postIn->update($request->id, $request->all());

        if($data =='success'){

            return response()->json(['status' => 'success', 'message' => 'Data update success.']);

        }else{

            return response()->json(['status' => 'error', 'message'=> 'Data update failed.']);

        }

       



    }



    public function update_extra_content(Request $request){

         foreach($request->type as $key => $type){

            

            $post = $this->postIn->find($request->page_id);

             $meta_data = $post->page_metas()->where('meta_key', $type)->first();

             if($meta_data == ''){

                 if(gettype($request[$type]) == 'array'){

                    

                    

                    $post->page_metas()->create([

                        'meta_key' => $type,

                        'meta_value' => json_encode($request[$type]),

                        'lang' => env('DEFAULT_LANGUAGE'),

                        'section_id' => $request->section_id,

                    ]);



                 }else{

                    $post->page_metas()->create([

                        'meta_key' => $type,

                        'meta_value' => $request[$type],

                        'lang' => env('DEFAULT_LANGUAGE'),

                        'section_id' => $request->section_id,

                    ]);

                 }

             }else{

                 

                 if(gettype($request[$type]) == 'array'){

                    $post->page_metas()->where('meta_key', $type)->update([

                        'meta_value' => json_encode($request[$type]),

                    ]);

                 }else{

                    $post->page_metas()->where('meta_key', $type)->update([

                        'meta_value' => $request[$type]

                    ]);

                 }

                 

             }

         }

 

         return back();



 

     }



    

     public function destory(Request $request){



        $page = $this->postIn->destory($request->id);

        if($page){

            return response()->json(['status' => 'success', 'message' => 'Data deleted successully.']);

           

        }

        return response()->json(['status' => 'warning', 'message' => 'Data Not found.']);

    }



    public function status(Request $request){

        $page = $this->postIn->status($request->all());

        if($page == 'success'){

            return response()->json(['status' => 'success', 'message' => 'Status update successully.']);

        }

        return response()->json(['status' => 'warning', 'message' => 'Sorry!! Update failed']);

    }

    

}

