<?php

use Illuminate\Http\Request;
use App\Models\{Upload, User, BusinessSetting, Translation, Post, Room, RoomHistory, RoomCycle, Cycle, PostsMeta, RoomEmployee, Production, olePermission, MailController, Vendor, Order, Sale};
use Carbon\Carbon;

if(!function_exists('dsld_vendor_today_check')){
    function dsld_vendor_today_check($vendor_id){
        $data = 0;
        $startOfDay = Carbon::today()->startOfDay();
        $endOfDay = Carbon::today()->endOfDay();
        $sales = Sale::where('vendor_id', $vendor_id)->whereBetween('created_at', [$startOfDay, $endOfDay])->sum('qty');
        if($sales > 0){
            $data = $sales;
        }
        return $data;
    }
}

if(!function_exists('dsld_total_production')){
    function dsld_total_production($grade){
        $data = 0;
        $startOfDay = Carbon::today()->startOfDay();
        $endOfDay = Carbon::today()->endOfDay();
        $production = Production::where('grades_id', $grade)->whereBetween('created_at', [$startOfDay, $endOfDay])->sum('qty');
        if($production > 0){
            $data = $production;
        }
        return $data;
    }
}

if(!function_exists('dsld_total_sale')){
    function dsld_total_sale($grade){
        $data = 0;
        $startOfDay = Carbon::today()->startOfDay();
        $endOfDay = Carbon::today()->endOfDay();
        $sales = Sale::where('grades_id', $grade)->whereBetween('created_at', [$startOfDay, $endOfDay])->sum('qty');
        if($sales > 0){
            $data = $sales;
        }
        return $data;
    }
}

if(!function_exists('dsld_total_stock')){
    function dsld_total_stock($grade){
        $data = 0;
        if(dsld_total_production($grade) >= dsld_total_sale($grade)){
            $data = dsld_total_production($grade) - dsld_total_sale($grade);
        }
        return $data;
    }
}
if(!function_exists('dsld_total_stock_without_qty')){
    function dsld_total_stock_without_qty($grade,  $qty =0 ){
        $data = 0;
        if(dsld_total_production($grade) >= dsld_total_sale($grade)){
            $data = dsld_total_production($grade) - dsld_total_sale($grade) + $qty;
        }
        return $data;
    }
}

if(!function_exists('dsld_vendor_details_by_user')){
    function dsld_vendor_details_by_user($vendor_id){
        $user_id = Vendor::where('user_id', $vendor_id)->first();
        return $user_id;
    }
}

if(!function_exists('dsld_order_update')){
    function dsld_order_update($vType, $uVendor = 0){
       
        $data = 0;
        $startOfDay = Carbon::today()->startOfDay();
        $endOfDay = Carbon::today()->endOfDay();
        $order = Order::where('categories_id', $vType)->where('vendor_id', $uVendor)->whereBetween('created_at', [$startOfDay, $endOfDay])->first();

        if(!empty($order)){
            $sale  = Sale::where('rooms_id', $order->id)->where('vendor_id', $uVendor)->whereBetween('created_at', [$startOfDay, $endOfDay])->sum('total');
            $total = $sale;
            $tax = 0 ;
            $grand = $total- $tax;

            $order->update([ 'total' => $total, 'tax' => $tax, 'grand_total' =>  $grand, 'updated_by' => Auth::user()->id ]);
            $data = $order;
        }else{
            $order = new Order;
            $order->categories_id = $vType;
            $order->vendor_id =  $uVendor;
            $order->created_by =  Auth::user()->id;
            $order->updated_by =  Auth::user()->id;
            $order->save();
            $data = $order;
        }
        
        return $data;
    }
}

// if(!function_exists('dsld_stock_sold_out')){
//     function dsld_stock_sold_out($grade, $value = 0 , $minus = '', $mvalue= 0){
       
//         $data = 0;
//         $startOfDay = Carbon::today()->startOfDay();
//         $endOfDay = Carbon::today()->endOfDay();
//         $stock = Stock::where('grades_id', $grade)->whereBetween('created_at', [$startOfDay, $endOfDay])->first();
//         if($value > 0){
//             if(!empty($stock)){
//                 if($minus =='minus'){
//                     $stock->update(['sold_out' => $stock->sold_out - $mvalue]);
//                 }
//                 $stock->update(['sold_out' => $value]);
//                 $data = $stock->total; 
//             }
//         }
//         return $data;

//     }
// }
// if(!function_exists('dsld_stock_check')){
//     function dsld_stock_check($grade){
       
//         $data = 0;
//         $startOfDay = Carbon::today()->startOfDay();
//         $endOfDay = Carbon::today()->endOfDay();
//         $stock = Stock::where('grades_id', $grade)->whereBetween('created_at', [$startOfDay, $endOfDay])->first();
     
//         if(!empty($stock)){
//             $data = $stock->stock; 
//         }
        
//         return $data;

//     }
// }

// if(!function_exists('dsld_stock_update_total_minus')){
//     function dsld_stock_update_total_minus($grade, $value = 0){
       
//         $data = 0;
//         $startOfDay = Carbon::today()->startOfDay();
//         $endOfDay = Carbon::today()->endOfDay();
//         $stock = Stock::where('grades_id', $grade)->whereBetween('created_at', [$startOfDay, $endOfDay])->first();
//         if($value > 0){
//             if(!empty($stock)){
//                 $stock->update(['total' => $stock->stock - $value, 'stock' => $stock->stock - $value]);
//                 $data = $stock->total; 
//             }
//         }
//         return $data;

//     }
// }

// if(!function_exists('dsld_stock_update_total_add')){
//     function dsld_stock_update_total_add($grade, $value = 0){
       
//         $data = 0;
//         $startOfDay = Carbon::today()->startOfDay();
//         $endOfDay = Carbon::today()->endOfDay();
//         $stock = Stock::where('grades_id', $grade)->whereBetween('created_at', [$startOfDay, $endOfDay])->first();
//         if($value > 0){
//             if(!empty($stock)){
//                 $stock->update(['total' => $stock->stock + $value, 'stock' => $stock->stock + $value]);
//                 $data = $stock->total; 
//             }else{
//                 Stock::insert(['grades_id' => $grade, 'total' => $value, 'stock' => $value]);
//                 $stock = Stock::where('grades_id', $grade)->whereBetween('created_at', [$startOfDay, $endOfDay])->first();
//                 $data = $stock->total;   
//             }
//         }
//         return $data;

//     }
// }
if(!function_exists('dsld_Production_total_check')){
    function dsld_Production_total_check($room, $grades = array()){
        $count = 0;
        if(is_array($grades) && count($grades)> 0){
            foreach($grades as $key => $grade){
                $count += Production::where('rooms_id', $room)->where('grades_id', $grade)->sum('qty');
            }
        }else{
            $count = Production::where('rooms_id', $room)->sum('qty');

        }
        return $count;
    }
}


if(!function_exists('dsld_Production_stock_check')){
    function dsld_Production_stock_check($room, $grades = array()){
        $count = 0;
        if(is_array($grades) && count($grades)> 0){
            foreach($grades as $key => $grade){
                $count += Production::where('rooms_id', $room)->where('grades_id', $grade)->sum('stock');
            }
        }else{
            $count = Production::where('rooms_id', $room)->sum('stock');

        }
        return $count;
    }
}
if(!function_exists('dsldCheckTodayUpdateRoomData')){
    function dsldCheckTodayUpdateRoomData($room_histories_id){
        $today = now();
        $RoomHistory = RoomHistory::where('id', $room_histories_id)->where('status', '!=', 2)->first();
        
        if(!is_null($RoomHistory)){

        
            $currentRoomCycle = RoomCycle::where('room_histories_id', $room_histories_id)->whereDate('date',  $today)->first();


            RoomCycle::where('room_histories_id', $room_histories_id)->whereDate('date', '<', $today)->update(['status' => 2]);
            RoomCycle::where('room_histories_id', $room_histories_id)->whereDate('date', '>', $today)->update(['status'=> 0]);
            RoomCycle::where('room_histories_id', $room_histories_id)->whereDate('date',  $today)->update(['status'=> 1]);
            


            //total Cycle
            $cycleCount = Cycle::count();

            //Convert Format
            $target_date = Carbon::parse($RoomHistory->start_date);

            //Add total cycle Date
            $target_date->addDay($cycleCount);

            $daysDifference = $today->diffInDays($target_date);


            if($today > $target_date){
                Room::where('id', $RoomHistory->room_id)->update(['status'=>  0]);
                $RoomHistory->status = 2;
                $RoomHistory->save();
                RoomEmployee::where('room_history_id', $room_histories_id)->update(['status' => 2]);
        
            }else{
                
                RoomEmployee::where('room_history_id', $room_histories_id)->update(['status' => 1]);
                Room::where('id', $RoomHistory->room_id)->update(['status'=>  1]);
                
                if(!is_null($currentRoomCycle)){
                    $RoomHistory->status = 1;
                    $RoomHistory->current_status = @$currentRoomCycle->cycle_id;
                    $RoomHistory->save();
                }else{
                    $latestRoomCycle = RoomCycle::where('room_histories_id', $room_histories_id)->latest()->first();
                    
                    if(!is_null($latestRoomCycle)){
                        $cycle = Cycle::where('id', '>', $latestRoomCycle->cycle_id)->orderBy('id')->first();
                    }else{
                        $cycle = Cycle::orderBy('id')->first();
                    }
                    
                    if(!is_null($cycle)){
                        $startDate  = Carbon::parse($RoomHistory->start_date);
                        $room_emp = RoomEmployee::where('room_history_id', $room_histories_id)->where('labours_type', $cycle->labours_type)->first();
                        
                        if(is_null($room_emp)){
                            return null;
                        }
                        
                        $RoomHistory->status = 1;
                        $RoomHistory->current_status = $cycle->id;
                        $RoomHistory->save();
                        
                        $cRoomHistory = new RoomCycle;
                        $cRoomHistory->cycle_id =  $cycle->id;
                        $cRoomHistory->date =  $startDate->addDay($cycle->day+1);
                        $cRoomHistory->room_histories_id =  $room_histories_id;
                        $cRoomHistory->employe_id =  $room_emp->employee_id;
                        
                        $cRoomHistory->is_delay =  0;
                        $cRoomHistory->room_id =  $RoomHistory->room_id;
                        $cRoomHistory->day =   $cycle->day;
                        $cRoomHistory->cycle_name =  $cycle->name;
                
                        $cRoomHistory->remark =  '';
                        $cRoomHistory->status =  1;
                        $cRoomHistory->created_by =  Auth::user()->id;
                        $cRoomHistory->updated_by =  Auth::user()->id;
                        $cRoomHistory->save();
                    }
                }
            
            }
        }
    }
}


if (!function_exists('dsld_get_base_URL')) {
    function dsld_get_base_URL()
    {
        $root = isset($_SERVER['HTTPS']) && isHttps() ? "https://".$_SERVER['HTTP_HOST'] : "http://".$_SERVER['HTTP_HOST'];
        $root .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

        return $root;
    }
}

if (!function_exists('isHttps')) {
    function isHttps()
    {
        $isHttps =
            $_SERVER['HTTPS']
            ?? $_SERVER['REQUEST_SCHEME']
            ?? $_SERVER['HTTP_X_FORWARDED_PROTO']
            ?? null
        ;

        $isHttps =
            $isHttps && (
                strcasecmp('on', $isHttps) == 0
                || strcasecmp('https', $isHttps) == 0
            )
        ;

        return $isHttps;
    }
}


//Get Post Parent Category Nmae

if(!function_exists('dsld_formatSize')){



     function dsld_formatSize($bytes)

    {

        if ($bytes >= 1073741824)

        {

            $bytes = number_format($bytes / 1073741824, 2) . ' GB';

        }

        elseif ($bytes >= 1048576)

        {

            $bytes = number_format($bytes / 1048576, 2) . ' MB';

        }

        elseif ($bytes >= 1024)

        {

            $bytes = number_format($bytes / 1024, 2) . ' KB';

        }

        elseif ($bytes > 1)

        {

            $bytes = $bytes . ' bytes';

        }

        elseif ($bytes == 1)

        {

            $bytes = $bytes . ' byte';

        }

        else

        {

            $bytes = '0 bytes';

        }



        return $bytes;

    }

}

//Get Post Parent Category Nmae

if(!function_exists('dsld_have_user_permission')){

    function dsld_have_user_permission($key){

         return 1;

    }

}



//Get Post Parent Category Nmae

if(!function_exists('dsld_check_permission')){

    function dsld_check_permission(Array $keys){

        if(Auth::user()->hasRole('Super-Admin')){

            return Auth::user()->hasRole('Super-Admin') ? true : null;

        }

        return Auth::user()->hasAnyDirectPermission($keys);

    }

}



//Get Post Parent Category Nmae

if(!function_exists('dsld_mail_send')){

    function dsld_mail_send($to, $subject, $template, $mail_body, $both = 0){

        $from = env('MAIL_FROM_ADDRESS');

        if($both == 2){

            

            $content['title'] = $subject;

            $content['body'] = $mail_body;

            $cdata = new MailController;

            $cdata->cf_submite_mail($to, $from, $subject, $content, $template);

            

            $cdata = new MailController;

            $content['title'] = $subject." | Admin Mail";

            $content['body'] = $mail_body;

            $cdata->cf_submite_mail($to, $from, $subject, $content, 'emails.admin_template');

            

        }else if($both == 1){

            

            $cdata = new MailController;

            $content['title'] = $subject." | Admin Mail";

            $content['body'] = $mail_body;

            $cdata->cf_submite_mail($to, $from, $subject, $content, 'emails.admin_template');

            

        }else if($both ==0){



            $content['title'] = $subject;

            $content['body'] = $mail_body;

            $cdata = new MailController;

            $cdata->cf_submite_mail($to, $from, $subject, $content, $template);

            

        }

        



    }

}



//return file uploaded via uploader

if (!function_exists('dsld_uploaded_asset')) {

    function dsld_uploaded_asset($id)

    {

        if (($asset = Upload::find($id)) != null) {

            return my_asset($asset->file_path);

        }

        return null;

    }

}

if (! function_exists('my_asset')) {

    /**

     * Generate an asset path for the application.

     *

     * @param  string  $path

     * @param  bool|null  $secure

     * @return string

     */

    function my_asset($path, $secure = null)

    {

        if(env('FILESYSTEM_DRIVER') == 's3'){

            return Storage::disk('s3')->url($path);

        }

        else {

            return app('url')->asset($path, $secure);

        }

    }

}

//Get Post Parent Category Nmae

if(!function_exists('dsld_generate_slug_by_text')){

    function dsld_generate_slug_by_text($text){

        return str_replace(' ', '_', $text);

    }

}

if(!function_exists('dsld_is_route_active')){

    function dsld_is_route_active(Array $routes, $output = 'active'){

        foreach($routes as $route){

            if(Route::currentRouteName() == $route) return $output;

        }

    }

}





if(!function_exists('dsld_is_slug_active')){

    function dsld_is_slug_active(Array $slugs, $output = 'active'){

        foreach($slugs as $slug){

            if(URL::current() == url('/').'/'.$slug) return $output;

        }

    }

}



if(!function_exists('dsld_translation')){

    function dsld_translation($key, $lang = null){

        if($lang == null){

            $lang = App::getLocale();

        }

        $check_data = Translation::where('lang', env("DEFAULT_LANGUAGE", "en"))->where('lang_key', $key)->first();

        if($check_data == null){

            $data = new Translation;

            $data->lang = env("DEFAULT_LANGUAGE", "en");

            $data->lang_key = $key;

            $data->lang_value = $key;

            $data->save();

        }



        $get_value = Translation::where('lang_key', $key)->where('lang', $lang)->first();

        if($get_value != null){

            return $get_value->lang_value;

        }else{

            return $check_data->lang_value;

        }

    }

}



if(! function_exists('dsld_default_language')){

    function dsld_default_language(){

        return env("DEFAULT_LANGUAGE");

    }

}





//Get Post wise slug Nmae

if(!function_exists('dsld_generate_slug_by_text_with_model')){

   

    function dsld_generate_slug_by_text_with_model($model, $title, $field, $separator = null){

        $separator  =  empty($separator) ?  '-' : $separator;

        $id = 0;



        $slug =  preg_replace('/\s+/', $separator, (trim(strtolower($title))));

        $slug =  preg_replace('/\?+/', $separator, (trim(strtolower($slug))));

        $slug =  preg_replace('/\#+/', $separator, (trim(strtolower($slug))));

        $slug =  preg_replace('/\/+/', $separator, (trim(strtolower($slug))));



        // $slug = preg_replace('!['.preg_quote($separator).']+!u', $separator, $title);



        // Remove all characters that are not the separator, letters, numbers, or whitespace.

        // $slug = preg_replace('![^'.preg_quote($separator).'\pL\pN\s]+!u', '', mb_strtolower($slug));



        // Replace all separator characters and whitespace by a single separator

        $slug = preg_replace('![' . preg_quote($separator) . '\s]+!u', $separator, $slug);



        // Get any that could possibly be related.

        // This cuts the queries down by doing it once.

        $allSlugs = dsld_getRelatedSlugs($slug, $id, $model, $field);



        // If we haven't used it before then we are all good.

        if (!$allSlugs->contains("$field", $slug)) {

            return $slug;

        }



        // Just append numbers like a savage until we find not used.



        for ($i = 1; $i <= 100; $i++) {

            $newSlug = $slug . $separator . $i;

            if (!$allSlugs->contains("$field", $newSlug)) {

                return $newSlug;

            }

        }



        throw new \Exception('Can not create a unique slug');

    }

}



if(!function_exists('dsld_getRelatedSlugs')){

    function dsld_getRelatedSlugs($slug, $id, $model, $field){

        if (empty($id)) {

            $id = 0;

        }



        return $model::select("$field")->where("$field", 'like', $slug . '%')

            ->where('id', '<>', $id)

            ->get();

    }

}





if (!function_exists('dsld_find_parent_level')) {

    function dsld_find_parent_level($model = null, $id = null)

    {

        $comment = $model::where('id',  $id)->first();

        if($comment){

            return $comment->level + 1; 

        }

        return 1;

    }

}



if (!function_exists('dsld_get_setting')) {

    function dsld_get_setting($key, $default = null)

    {

        $setting = BusinessSetting::where('type', $key)->first();

        return $setting == null ? $default : $setting->value;

    }

}





if (!function_exists('dsld_id_get_setting')) {

    function dsld_id_get_setting($key, $default = null)

    {

        $setting = BusinessSetting::where('type', $key)->first();

        return $setting == null ? $default : $setting->id;

    }

}





if(!function_exists('dsld_referral_code_create'))

{

    function dsld_referral_code_create($code){

        if (($check = User::where('referral_code', $code)->first()) == null) {

            return $code;

        }else{

            return dsld_referral_code_create($code);

        }



    }

}



if(!function_exists('dsld_random_code_generator'))

{

    function dsld_random_code_generator($limit = 10){

        return Str::random($limit);

    }

}



if(!function_exists('dsld_uploaded_file_path'))

{

    function dsld_uploaded_file_path($id, $thumb = ''){



        if(is_null($id) || $id == 0){

            return null;

        }



        if (($asset = Upload::find($id)) != null) {

            return $asset->getUrl($thumb);

        }

        return null;

    }

}

if (!function_exists('dsld_uploading_file_type')) {

    function dsld_uploading_file_type($file)

    {

        $type = array(

            "jpg"=>"image",

            "jpeg"=>"image",

            "png"=>"image",

            "svg"=>"image",

            "webp"=>"image",

            "gif"=>"image",

            "mp4"=>"video",

            "mpg"=>"video",

            "mpeg"=>"video",

            "webm"=>"video",

            "ogg"=>"video",

            "avi"=>"video",

            "mov"=>"video",

            "flv"=>"video",

            "swf"=>"video",

            "mkv"=>"video",

            "wmv"=>"video",

            "wma"=>"audio",

            "aac"=>"audio",

            "wav"=>"audio",

            "mp3"=>"audio",

            "zip"=>"archive",

            "rar"=>"archive",

            "7z"=>"archive",

            "doc"=>"document",

            "txt"=>"document",

            "docx"=>"document",

            "pdf"=>"document",

            "csv"=>"document",

            "xml"=>"document",

            "ods"=>"document",

            "xlr"=>"document",

            "xls"=>"document",

            "xlsx"=>"document"

        );

        $extension = strtolower($file->getClientOriginalExtension());

        if(isset($type[$extension])){

                return $type[$extension];

        }

        else{

                return "others";

        }

    }

}

//return file uploaded via uploader

if (!function_exists('dsld_upload_file_title')) {

    function dsld_upload_file_title($id)

    {

        if (($asset = Upload::find($id)) != null) {

            return $asset->name;

        }

        return null;

    }

}





if (!function_exists('dsld_api_asset')) {

    function dsld_api_asset($id)

    {

        if (($asset = Upload::find($id)) != null) {

            return $asset->file_name;

        }

        return "";

    }

}





//Get Post Parent Category Nmae

if(!function_exists('dsld_generate_slug_by_text_with_model')){

   

    function dsld_generate_slug_by_text_with_model($model, $title, $field, $separator = null){

        $separator  =  empty($separator) ?  '-' : $separator;

        $id = 0;



        $slug =  preg_replace('/\s+/', $separator, (trim(strtolower($title))));

        $slug =  preg_replace('/\?+/', $separator, (trim(strtolower($slug))));

        $slug =  preg_replace('/\#+/', $separator, (trim(strtolower($slug))));

        $slug =  preg_replace('/\/+/', $separator, (trim(strtolower($slug))));



        // $slug = preg_replace('!['.preg_quote($separator).']+!u', $separator, $title);



        // Remove all characters that are not the separator, letters, numbers, or whitespace.

        // $slug = preg_replace('![^'.preg_quote($separator).'\pL\pN\s]+!u', '', mb_strtolower($slug));



        // Replace all separator characters and whitespace by a single separator

        $slug = preg_replace('![' . preg_quote($separator) . '\s]+!u', $separator, $slug);



        // Get any that could possibly be related.

        // This cuts the queries down by doing it once.

        $allSlugs = dsld_getRelatedSlugs($slug, $id, $model, $field);



        // If we haven't used it before then we are all good.

        if (!$allSlugs->contains("$field", $slug)) {

            return $slug;

        }



        // Just append numbers like a savage until we find not used.



        for ($i = 1; $i <= 100; $i++) {

            $newSlug = $slug . $separator . $i;

            if (!$allSlugs->contains("$field", $newSlug)) {

                return $newSlug;

            }

        }



        throw new \Exception('Can not create a unique slug');

    }

}





//Get Post Parent Category Nmae

if(!function_exists('dsld_page_meta_value_by_meta_key')){

    function dsld_page_meta_value_by_meta_key($meta_key = '', $page_id=''){

        $data = PostsMeta::where('meta_key', $meta_key)->where('pageable_id', $page_id)->first();



        if( $data != ''){

            return $data->meta_value;

        }else{

            return '';

        }

        

    }

}

if(!function_exists('include_form_by_id')){
    function include_form_by_id($form_id){

        if(dsld_page_meta_value_by_meta_key('layout', $form_id) !=''){
            
            echo view('frontend.forms.'.dsld_page_meta_value_by_meta_key('layout', $form_id), compact('form_id'));
        }else{
            echo '';
        } 
    }
}



if (!function_exists('dsld_static_asset')) {

    function dsld_static_asset($path, $secure = null){

        return app('url')->asset($path, $secure);

    }

}

//Get Post Parent Category Nmae
if(!function_exists('dsld_form_field_by_form_id')){
    function dsld_form_field_by_form_id($id = ''){
        $data = Post::where('id', $id)->where('type', 'contact_form')->first();
        if( $data != ''){
            $meta_fields = json_decode($data->meta_fields);     

            usort($meta_fields, function($a, $b) { //Sort the array using a user defined function
                return $a->order > $b->order ? 1 : -1; //Compare the scores
            }); 
            return $meta_fields;
        }else{
            return array();
        }

    }
}

if (!function_exists('dsld_lazy_image_by_id')) {

    function dsld_lazy_image_by_id($id, $class = ''){
    
        if(!is_null($id) || $id !='['){
            $image = '<img class="lazy '.$class.' id-'.$id.'" alt="'.dsld_upload_file_title($id).'" 
                        src="'.dsld_static_asset('public/backend/assets/images/circle-loading.gif').'"
                        data-src="'.dsld_static_asset('public/backend/assets/images/circle-loading.gif').'"
                        data-srcset="'.dsld_uploaded_file_path($id, 'full').'"
                        srcset="'.dsld_uploaded_file_path($id, 'placeholder').'"
                    >';
            return $image;
        }else{
            $image = '<img class="'.$class.'" src="'.dsld_static_asset('public/backend/assets/images/circle-loading.gif').'"
                    >';
        }
        return $image;
    }

}