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

class GalleryPageController extends Controller
{
    protected $postIn;

    function __construct(PostInterfaces $post){
        $this->postIn = $post;
        $this->middleware('permission:galleries|add-galleries|edit-galleries', ['only' => ['index','get_ajax_pages']]);
        $this->middleware('permission:add-galleries', ['only' => ['create','store']]);
        $this->middleware('permission:edit-galleries', ['only' => ['edit','update']]);
    }

    public function index(){
        $page['title'] = 'Show all Gallery';
        $page['name'] = 'Gallery';
        return view('backend.modules.websites.pages.gallery.show', compact('page'));
    }

    public function get_ajax_data(Request $request){
        $data = $this->postIn->all($request, 'gallery_page');
        return view('backend.modules.websites.pages.gallery.ajax_files', compact('data'));
    }

    public function edit($id){
        $lang = env('DEFAULT_LANGUAGE');
        $data = $this->postIn->find($id);
        $page['title'] = 'Edit Data';
        return view('backend.modules.websites.pages.gallery.edit', compact('data', 'page','lang'));
    }

}
