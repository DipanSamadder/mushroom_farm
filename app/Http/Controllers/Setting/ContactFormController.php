<?php
namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostsSection;
use App\Models\PostsMeta;
use App\Models\PostTranslation;
use App\Models\ContactForm;
use App\Interfaces\PostInterfaces;
use Validator;

class ContactFormController extends Controller
{
    protected $postIn;

    function __construct(PostInterfaces $post){
        $this->postIn = $post;
        $this->middleware('permission:contactfs|add-contactfs|edit-contactfs', ['only' => ['index','get_ajax_pages']]);
        $this->middleware('permission:add-contactfs', ['only' => ['create','store']]);
        $this->middleware('permission:edit-contactfs', ['only' => ['edit','update']]);
    }

    public function index(){
        $page['title'] = 'Show all Contacts';
        $page['name'] = 'Contact';
        return view('backend.modules.websites.contact_forms.show', compact('page'));
    }

    public function get_ajax_contact_forms(Request $request){
        $data = $this->postIn->all($request, 'contact_form');
        return view('backend.modules.websites.contact_forms.ajax_forms', compact('data'));
    }


    public function edit(Request $request){
        $data = $this->postIn->find($request->id);
        $page['title'] = 'Edit Data';
        return view('backend.modules.websites.contact_forms.edit', compact('data', 'page'));
    }
    
    public function update(Request $request){

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:50',
            'send_mail' => 'required|email',
            'success_msg' => 'required',
            'admin_template' => 'required',
            'user_template' => 'required',
            'section_name' => 'required',
            'status' => 'required|integer'
        ]);

        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }

        $page = Post::findOrFail($request->page_id);


        if($page != ''){
            $page->title = $request->title;
            $page->order = $request->order;
            $page->status = $request->status;
            $page->save();

            $sectionMeta = $page->sections()->where('title', $request->section_name)->first(); 
            
            if(!is_null($sectionMeta)){
                $sectionMeta = $sectionMeta->sections()->create(['title' => $request->section_name, 'order' => $request->order, 'status' => $request->status]);
            }

            foreach($request->types as $key => $type){
                $page_meta = $page->page_metas()->where('meta_key', $type)->first();

                if(!is_null($page_meta)){
                    $page->page_metas()->update(['meta_value' => $request[$type]]);
                }else{
                    $page->page_metas()->create(['meta_key' => $type, 'meta_value' => $request[$type]]);
                }
                
            }
            return response()->json(['status' => 'success', 'message'=> 'Data update success.']);

        }else{
            return response()->json(['status' => 'warning', 'message'=> 'Not Found! please try again.']);
        }

    }

    public function edit_fields($id){
        $page['title'] = 'Update fields elements';
        $data = Post::where('id', $id)->first();
        return view('backend.modules.websites.contact_forms.edit_forms', compact('data', 'page'));
    }


    public function edit_field_update(Request $request){

        $page = Post::findOrFail($request->id);
        $form = array();
        $select_types = ['select', 'multi_select', 'radio', 'checkbox'];
        $j = 0;
        for ($i=0; $i < count($request->type); $i++) {
            $item['type'] = $request->type[$i];
            $item['label'] = $request->label[$i];
            $item['order'] = $request->order[$i];

            if(in_array($request->type[$i], $select_types)){
                $item['options'] = json_encode($request['options_'.$request->option[$j]]);
                $j++;
            }

            $set = array(
                'class_name' => $request->class_name[$i],
                'width' => $request->width[$i],
                'label_setting' => $request->label_setting[$i],
                'is_required' => $request->is_required[$i],
            );

            $item['setting'] =json_encode($set);

            array_push($form, $item);
        }

        $page->meta_fields = json_encode($form);
        if($page->save()){
            return back();
        }
    }

    public function get_ajax_contact_forms_leads(Request $request){

        if($request->page != 1){$start = $request->page * 15;}else{$start = 0;}
        $forms_ids = $request->forms_ids;
        $search = $request->search;
        $sort = $request->sort;

        $data = ContactForm::where('meta_key', 'details');
  
        if($search != ''){
            $data->where('meta_value', 'like', '%'.$search.'%');
        }

        if($forms_ids != 'all'){
            $data->where('form_id', $forms_ids);
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
        $data = $data->skip($start)->paginate(15);

        return view('backend.modules.websites.contact_forms.ajax_leads', compact('data'));
    }
    
    public function leads_destory(Request $request){

        $ContactForm = ContactForm::findOrFail($request->id);
        if($ContactForm != ''){
            if($ContactForm->delete()){
                return response()->json(['status' => 'success', 'message' => 'Data deleted successully.']);
            }else{
                return response()->json(['status' => 'error', 'message' => 'Data deleted failed.']);
            }
        }else{
            return response()->json(['status' => 'warning', 'message' => 'Data Not found.']);
        }

    }

    public function exportCfLeads($id){
        $data = Post::where('id', $id)->first();
        $form_id =  $data->id;
        $file_name =  $data->title.'.xlsx';
        if($data != ''){
            return Excel::download(new ExportCfLeads($form_id), $file_name);
        }
        
    }

    public function contact_form_leads(){
        $page['title'] = 'Show all Leads';
        $page['name'] = 'Lead';
        return view('backend.modules.websites.contact_forms.leads', compact('page'));
    }

    public function show(){
        $page['title'] = 'Show all Leads';
        $page['name'] = 'Lead';
        return view('backend.modules.websites.contact_forms.leads', compact('page'));
    }

    public function npf_form($form_id){
        
        if(dsld_page_meta_value_by_meta_key('layout', $form_id) !=''){
            
            echo view('frontend.forms.'.dsld_page_meta_value_by_meta_key('layout', $form_id), compact('form_id'));
        }else{
            echo '';
        } 
    }

    public function ajax_submit_data(Request $request){

        $data = array();
        $i = 0;
        $if_valid = array();
        $email_user = '';

        foreach (dsld_form_field_by_form_id($request->form_id) as $key => $element){

            $is_required = @json_decode($element->setting)->is_required;
            $label = strtolower(dsld_generate_slug_by_text($element->label));
            $is_empty = 0 ;
            if($element->type !='button'){
                
                $meta_value = $request->input($label);
                if($meta_value != ''){

                    if($element->type =='text' || $element->type =='textarea'|| $element->type =='file'){
                        $is_empty = 1;
                    }elseif($element->type =='email'){
                        if(dsld_is_valid_email($meta_value) == 1){
                            $is_empty = 1;
                            $email_user = $meta_value;
                        }else{
                            return response()->json(['status' => 'error', 'message' => 'Enter your valid email.']);
                        }

                    }elseif($element->type =='phone'){
                        if(dsld_is_valid_phone($meta_value) == 1){
                            $is_empty = 1;
                        }else{
                            return response()->json(['status' => 'error', 'message' => 'Enter your valid phone number.']);
                        }
                    }      

                }
            }

            if($is_required == 'required' && $is_empty == 0){
                $if_valid[$label] = 'required';
            }
            
        }

        $validator = Validator::make($request->all(), $if_valid);



        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }


        $push = array();
        foreach(dsld_form_field_by_form_id($request->form_id) as $key => $element){
            if($element->type !='button'){
                $label = strtolower(dsld_generate_slug_by_text($element->label));
                $input = $request->input($label);
                if($element->type !=  'file'){
                    array_push($push, array($label => $input));
                }else{
                    if($request->hasFile($label)){
                        $path = $request->file($label)->store('uploads/forms');
                        array_push($push, array($label =>  url('/'.$path)));
                    }
                }
            }
               
        }


        $form_data = ContactForm::orderBy('id', 'desc')->first();
        $form = new ContactForm;
        $form->meta_key = 'details';
        $form->meta_value = json_encode($push);
        $form->form_id = $request->form_id;
        $form->unit_id = empty($form_data->unit_id) ? 1 : $form_data->unit_id + 1;

        if($form->save()){

           dsld_mail_send_for_cf($request->form_id, $email_user, json_encode($push));

            return response()->json(['status' => 'success', 'message' => dsld_form_meta_value_get_by_form_id('success_msg', $request->form_id) ]);
        }else{
            return response()->json(['status' => 'error', 'message' => 'Data is not inserted']);
        }

    }

  
}


    
