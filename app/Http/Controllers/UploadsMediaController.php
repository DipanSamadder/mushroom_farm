<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Upload;
use App\Models\User;
use Validator;
use Auth;


class UploadsMediaController extends Controller
{
    function media_library_admin(){
        if(dsld_have_user_permission('media') == 0){
            return "You have no permission.";
        }

        $page['title'] = 'Show All Media Files';
        return view('backend.modules.media.show', compact('page'));
    }

    function uploads(Request $request){
        if(dsld_have_user_permission('media_add') == 0){
            return response()->json(['status' => 'error', 'content'=> "You have no permission."]);
        }
        if($request->TotalFiles > 0){

            $user = User::find(Auth::user()->id);

            foreach ($request->file('dsld_files') as $key => $mediaFiles) {
              $file =  $user->addMedia($mediaFiles)
                ->withCustomProperties(['purpose' => 'global'])
                ->toMediaCollection('user', 'uploads');

                if(isset($request->page_id)){
                    $file->update(['page_id' => $request->page_id]);
                }
            }
            
            return response()->json(['status' => 'success', 'content' => 'Thank you for update data.']);
        }
    
    }
    function update(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:50'
        ]);

        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }

        $media = Upload::findOrFail($request->id);

        if($media != ''){
            $media->name = $request->title;

            if(isset($request->order)){
                $media->order_column  = $request->order;
            }else{
                $media->order_column  = 0;
            }

            if($media->save()){
                return response()->json(['status' => 'success', 'message'=> 'Data update success.']);
            }else{
                return response()->json(['status' => 'error', 'message'=> 'Data update failed.']);
            }
            
        }else{
            return response()->json(['status' => 'warning', 'message'=> 'Not Found! please try again.']);
        }
    }

    function edit(Request $request){
        $data = Upload::where('model_id', $request->user_id)->where('id', $request->id)->first();
        return view('backend.modules.media.edit', compact('data'));
    }

    function files_gets_admin(Request $request){

        if(dsld_have_user_permission('media') == 0){ 
            return "You have no permission.";
        }

        if($request->page != 1){$start = $request->page * 24;}else{$start = 0;}
        $user_id = $request->user_id;
        $search = $request->search;
        $sort = $request->sort;
        $media_type = $request->media_type;
        
        $data = Upload::where('model_id', '!=', '');
        if($search != ''){
            $data->where('name', 'like', '%'.$search.'%');
        }
        if($media_type != 'all' && $media_type != ''){
            
            $data->where('mime_type', 'like', $media_type.'%' );
        }
       
        if($sort != ''){
            switch ($request->sort) {
                case 'newest':
                    $data->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $data->orderBy('created_at', 'asc');
                    break;
                case 'smallest':
                    $data->orderBy('size', 'asc');
                    break;
                case 'largest':
                    $data->orderBy('size', 'desc');
                    break;
                default:
                    $data->orderBy('created_at', 'desc');
                    break;
            }
        }
        $data = $data->skip($start)->paginate(24);
        return view('backend.modules.media.media_items', compact('data')); 
    }
    function files_gets_page_edit_admin(Request $request){

        if($request->page != 1){$start = $request->page * 4;}else{$start = 0;}
       
        $data = Upload::where('page_id', $request->page_id)->orderBy('created_at', 'desc');
        $data = $data->skip($start)->paginate(4);
        return view('backend.modules.websites.pages.gallery.media_items', compact('data')); 
    }

    function files_destroy_admin(Request $request){
        if(dsld_have_user_permission('media_delete') == 0){
            return response()->json(['status' => false]);
        }
        $media = Upload::find($request->input('id'));
        $model_type = $media->model_type;
        $model = $model_type::find($media->model_id);
        if(!is_null($model) && file_exists($media->getPath())){
            $model->deleteMedia($media->id);
        }
        $media->delete();
        
        return ['status'=> true] ;

    }
      function files_gets_admin_modals(Request $request){

        if(dsld_have_user_permission('media') == 0){ 
            return "You have no permission.";
        }

        if($request->page != 1){$start = $request->page * 16;}else{$start = 0;}
        $user_id = $request->user_id;
        $search = $request->search;
        $sort = $request->sort;
        $class = $request->class;
        $type = $request->type;
        $id = $request->id;
        $media_type = $request->media_type;
        
        $data = Upload::where('model_id', '!=', '');
        if($search != ''){
            $data->where('name', 'like', '%'.$search.'%');
            $data->orWhere('id', 'like', '%'.$search.'%');
        }
        if($media_type != 'all' && $media_type != ''){
            $data->where('mime_type', 'like', $media_type.'%' );
        }
       
        if($sort != ''){
            switch ($request->sort) {
                case 'newest':
                    $data->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $data->orderBy('created_at', 'asc');
                    break;
                case 'smallest':
                    $data->orderBy('size', 'asc');
                    break;
                case 'largest':
                    $data->orderBy('size', 'desc');
                    break;
                default:
                    $data->orderBy('created_at', 'desc');
                    break;
            }
        }
        $data = $data->skip($start)->paginate(16);
        return view('backend.modules.media.models_media_items', compact('data', 'id', 'class')); 
    }
}
