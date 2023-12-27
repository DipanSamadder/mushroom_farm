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

class PlacementsController extends Controller
{
    protected $postIn;

    function __construct(PostInterfaces $post){
        $this->postIn = $post;
        $this->middleware('permission:placements|add-placements|edit-placements', ['only' => ['index','get_ajax_pages']]);
        $this->middleware('permission:add-placements', ['only' => ['create','store']]);
        $this->middleware('permission:edit-placements', ['only' => ['edit','update']]);
    }

    public function index(){
        $page['title'] = 'Show all Placements';
        $page['name'] = 'Placement';
        return view('backend.modules.websites.pages.placements.show', compact('page'));
    }

    public function get_ajax_data(Request $request){
        $data = $this->postIn->all($request, 'placements');
        return view('backend.modules.websites.pages.placements.ajax_files', compact('data'));
    }


    public function edit(Request $request){
        $data = $this->postIn->find($request->id);
        $page['title'] = 'Edit Data';
        return view('backend.modules.websites.pages.placements.edit', compact('data', 'page'));
    }
    
}
