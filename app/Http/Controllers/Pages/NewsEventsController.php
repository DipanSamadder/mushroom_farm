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

class NewsEventsController extends Controller
{
    protected $postIn;

    function __construct(PostInterfaces $post){
        $this->postIn = $post;
        $this->middleware('permission:news-events|add-news-events|edit-news-events', ['only' => ['index','get_ajax_pages']]);
        $this->middleware('permission:add-news-events', ['only' => ['create','store']]);
        $this->middleware('permission:edit-news-events', ['only' => ['edit','update']]);
    }

    public function index(){
        $page['title'] = 'Show all news & events';
        $page['name'] = 'News & event';
        return view('backend.modules.websites.pages.news_events.show', compact('page'));
    }

    public function get_ajax_data(Request $request){
        $data = $this->postIn->all($request, 'news_events');
        return view('backend.modules.websites.pages.news_events.ajax_files', compact('data'));
    }


    public function edit(Request $request){
        $data = $this->postIn->find($request->id);
        $page['title'] = 'Edit Data';
        return view('backend.modules.websites.pages.news_events.edit', compact('data', 'page'));
    }
    
}
