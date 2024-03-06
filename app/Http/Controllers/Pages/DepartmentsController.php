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

class DepartmentsController extends Controller{

    protected $postIn;

    function __construct(PostInterfaces $post){
        $this->postIn = $post;
        $this->middleware('permission:departments|add-departments|edit-departments', ['only' => ['index','get_ajax_data']]);
        $this->middleware('permission:add-departments', ['only' => ['create','store']]);
        $this->middleware('permission:edit-departments', ['only' => ['edit','update']]);
    }

    public function index(){
        $page['title'] = 'Show all departments';
        $page['name'] = 'Department';
        return view('backend.modules.websites.pages.departments.show', compact('page'));
    }

    public function get_ajax_data(Request $request){
        $data = $this->postIn->all($request, 'department_details');
        return view('backend.modules.websites.pages.departments.ajax_files', compact('data'));
    }


    public function edit(Request $request){

        $page['title'] = 'Edit Data';
        $data = $this->postIn->find($request->id);
        $section = $this->postIn->sections(72);
        $lang = env('DEFAULT_LANGUAGE');

        return view('backend.modules.websites.pages.departments.edit', compact('data', 'page', 'section', 'lang'));
    }  

    public function department_edit_extra(Request $request){

        $page['title'] = 'Edit Data';
        $data = $this->postIn->find($request->id);
        $departments = $this->postIn->sections(72);
        $sec = $this->postIn->sections(72, $request->section_id);

        $lang = env('DEFAULT_LANGUAGE');
        return view('backend.modules.websites.pages.departments.extra_edit', compact('sec','data', 'departments','lang'));
    }
}
