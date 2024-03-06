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

class PageOthersController extends Controller
{
    protected $postIn;

    function __construct(PostInterfaces $post){
        $this->postIn = $post;
        $this->middleware('permission:page-others|add-page-others|edit-page-others', ['only' => ['index','get_ajax_pages']]);
        $this->middleware('permission:add-page-others', ['only' => ['create','store']]);
        $this->middleware('permission:edit-page-others', ['only' => ['edit','update']]);
    }

    public function index(){
        $page['title'] = 'Show all Page others';
        $page['name'] = 'Page other';
        return view('backend.modules.websites.pages.page_others.show', compact('page'));
    }

    public function get_ajax_data(Request $request){
        $data = $this->postIn->all($request, 'page_others');
        return view('backend.modules.websites.pages.page_others.ajax_files', compact('data'));
    }


    public function edit(Request $request){
        $data = $this->postIn->find($request->id);
        $page['title'] = 'Edit Data';
        return view('backend.modules.websites.pages.page_others.edit', compact('data', 'page'));
    }
    
}
