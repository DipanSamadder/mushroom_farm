<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostsSection;
use App\Models\PostsMeta;
use App\Models\PostTranslation;
use App\Interfaces\PostInterfaces;
use Validator;

class ProgramController extends Controller
{
    protected $postIn;

    function __construct(PostInterfaces $post){
        $this->postIn = $post;
        $this->middleware('permission:programs|add-programs|edit-programs', ['only' => ['index','get_ajax_data']]);
        $this->middleware('permission:add-programs', ['only' => ['create','store']]);
        $this->middleware('permission:edit-programs', ['only' => ['edit','update']]);
    }

    public function index(){
        $page['title'] = 'Show all programs';
        $page['name'] = 'Program';
        return view('backend.modules.websites.pages.programs.show', compact('page'));
    }

    public function get_ajax_data(Request $request){
        $data = $this->postIn->all($request, 'programs_details');
        return view('backend.modules.websites.pages.programs.ajax_files', compact('data'));
    }


    public function edit(Request $request){

        $page['title'] = 'Edit Data';
        $data = $this->postIn->find($request->id);
        $section = $this->postIn->sections($request->id);
        $lang = env('DEFAULT_LANGUAGE');

        return view('backend.modules.websites.pages.programs.edit', compact('data', 'page', 'section', 'lang'));
    }   

}
