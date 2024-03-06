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

class NewsUpdateController extends Controller
{
    protected $postIn;

    function __construct(PostInterfaces $post){
        $this->postIn = $post;
        $this->middleware('permission:updates|add-updates|edit-updates', ['only' => ['index','get_ajax_pages']]);
        $this->middleware('permission:add-updates', ['only' => ['create','store']]);
        $this->middleware('permission:edit-updates', ['only' => ['edit','update']]);
    }

    public function index(){
        $page['title'] = 'Show all updates';
        $page['name'] = 'Update';
        return view('backend.modules.websites.pages.updates.show', compact('page'));
    }

    public function get_ajax_data(Request $request){
        $data = $this->postIn->all($request, 'news_updates');
        return view('backend.modules.websites.pages.updates.ajax_files', compact('data'));
    }


    public function edit(Request $request){
        $data = $this->postIn->find($request->id);
        $page['title'] = 'Edit Data';
        return view('backend.modules.websites.pages.updates.edit', compact('data', 'page'));
    }
    
}
