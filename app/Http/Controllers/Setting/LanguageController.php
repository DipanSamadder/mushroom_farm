<?php

namespace App\Http\Controllers\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Language;
use App\Models\Translation;
use Validator;

class LanguageController extends Controller
{
    
    function __construct(){
       
        $this->middleware('permission:languages|add-languages|edit-languages|delete-languages', ['only' => ['index','get_ajax_permissions']]);
        $this->middleware('permission:add-languages', ['only' => ['create','store']]);
        $this->middleware('permission:edit-languages', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-languages', ['only' => ['destroy']]);
        
    }

    public function index(){
        $page['title'] = 'Show all Language';
        $page['name'] = 'Language';
        return view('backend.modules.settings.language.show', compact('page'));
    }

    public function get_ajax_languages(Request $request){
   
        if($request->page != 1){$start = $request->page * 25;}else{$start = 0;}
        $search = $request->search;
        $sort = $request->sort;

        $data = Language::where('name','!=','');
        if($search != ''){
            $data->where('name', 'like', '%'.$search.'%');
        }
       
        if($sort != ''){
            switch ($request->sort) {
                case 'newest':
                    $data->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $data->orderBy('created_at', 'asc');
                    break;
                case 'active':
                    $data->where('status', 1);
                    break;
                case 'deactive':
                    $data->where('status', 0);
                    break;
                default:
                    $data->orderBy('created_at', 'desc');
                    break;
            }
        }
        $data = $data->skip($start)->paginate(25);
        return view('backend.modules.settings.language.ajax_files', compact('data'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'code' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }
        if(Language::where('name', $request->name)->first() == null){
            $language =  new Language;
            $language->name = $request->name;
            $language->code = $request->code;
            if($language->save()){
                return response()->json(['status' => 'success', 'message'=> 'Data insert success.']);
            }
            return response()->json(['status' => 'error', 'message'=> 'Data insert failed.']);
            
        }else{
            return response()->json(['status' => 'warning', 'message'=> 'Details already exist! please try agin.']);
        }
    }

    public function edit(Request $request){
        $data = Language::where('id', $request->id)->first();
        return view('backend.modules.settings.language.edit', compact('data'));
    }
    
    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'code' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }
        $language =  Language::findOrFail($request->id);
        $language->name = $request->name;
        $language->code = $request->code; 

        if($language->save()){
            return response()->json(['status' => 'success', 'message'=> 'Data update success.']);
        }
    
        return response()->json(['status' => 'warning', 'message'=> 'Details already exist! please try agin.']);
        
    }


    public function translate(){
        $page['title'] = 'Show all Translate';
        $page['name'] = 'Translate';
        return view('backend.modules.settings.translate.show', compact('page'));
    }

    public function get_ajax_translates(Request $request){
   
        if($request->page != 1){$start = $request->page * 25;}else{$start = 0;}
        $search = $request->search;
        $sort = $request->sort;

        $data = Translation::where('lang_key','!=','');
        if($search != ''){
            $data->where('lang_key', 'like', '%'.$search.'%');
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
        return view('backend.modules.settings.translate.ajax_files', compact('data'));
    }


    public function translate_edit(Request $request){
        $data = Translation::where('id', $request->id)->first();
        return view('backend.modules.settings.translate.edit', compact('data'));
    }


    public function translate_update(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'lang' => 'required',
            'lang_key' => 'required',
            'lang_value' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }
        $lang_key = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->lang_key));

        $translate  = Translation::where('id', $request->id)->first();
        if($translate != ''){
            $translate->lang = $request->lang;
            $translate->lang_key = strtolower($lang_key);
            $translate->lang_value = $request->lang_value;
            if($translate->save()){
                return response()->json(['status' => 'success', 'message'=> 'Translate has been updated successfully']);
            } 
            return response()->json(['status' => 'error', 'message'=> 'Data updated failed.']);
        }else{
            return response()->json(['status' => 'error', 'message'=> 'Already updated.']);
        }
    }



    public function translate_store(Request $request){
        $validator = Validator::make($request->all(), [
            'lang' => 'required',
            'lang_key' => 'required',
            'lang_value' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }
        $lang_key = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->lang_key));
        
        $translate = new Translation;
        $translate->lang = $request->lang;
        $translate->lang_key = strtolower($lang_key);
        $translate->lang_value = $request->lang_value;
        $data = Translation::where('lang', $translate->lang)->where('lang_key', $translate->lang_key)->first();
        if($data == ''){
            if($translate->save()){
                return response()->json(['status' => 'success', 'message'=> 'Translate has been inserted successfully']);
            } 
            return response()->json(['status' => 'error', 'message'=> 'Data insert failed.']);
        }else{
            return response()->json(['status' => 'error', 'message'=> 'Already Inserted.']);
        }
    }



    public function show(Request $request, $id)
    {
        $sort_search = null;
        $language = Language::findOrFail(decrypt($id));
        $lang_keys = Translation::where('lang', env('DEFAULT_LANGUAGE', 'en'));
        if ($request->has('search')){
            $sort_search = $request->search;
            $lang_keys = $lang_keys->where('lang_key', 'like', '%'.$sort_search.'%');
        }
        $lang_keys = $lang_keys->paginate(50);
        return view('backend.settings.languages.language_view', compact('language','lang_keys','sort_search'));
    }


    public function key_value_store(Request $request)
    {
        $language = Language::findOrFail($request->id);
        foreach ($request->values as $key => $value) {
            $translation_def = Translation::where('lang_key', $key)->where('lang', $language->code)->first();
            if($translation_def == null){
                $translation_def = new Translation;
                $translation_def->lang = $language->code;
                $translation_def->lang_key = $key;
                $translation_def->lang_value = $value;
                $translation_def->save();
            }
            else {
                $translation_def->lang_value = $value;
                $translation_def->save();
            }
        }
        flash(translate('Translations updated for ').$language->name)->success();
        return back();
    }

    public function update_rtl_status(Request $request)
    {
        $language = Language::findOrFail($request->id);
        $language->rtl = $request->status;
        if($language->save()){
            flash(translate('RTL status updated successfully'))->success();
            return 1;
        }
        return 0;
    }

    public function changeLanguage(Request $request)
    {
    	$request->session()->put('locale', $request->locale);
        $language = Language::where('code', $request->locale)->first();
    	flash(translate('Language changed to ').$language->name)->success();
    }


    public function destory(Request $request){
        if(Language::destroy($request->id)){
            return response()->json(['status' => 'success', 'message' => 'Data deleted successully.']);   
        }else{
            return response()->json(['status' => 'warning', 'message' => 'Data Not found.']);
        }
       
    }

    public function translate_destory(Request $request){
        if(Translation::destroy($request->id)){
            return response()->json(['status' => 'success', 'message' => 'Data deleted successully.']);   
        }else{
            return response()->json(['status' => 'warning', 'message' => 'Data Not found.']);
        }
       
    }
}
