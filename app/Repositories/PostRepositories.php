<?php

namespace App\Repositories;



use App\Interfaces\PostInterfaces;

use App\Models\Post;

use App\Models\PostsMeta;



class PostRepositories implements PostInterfaces{



    public function all($request, $post_type){



        if($request['page'] != 1){$start = $request['page'] * 15;}else{$start = 0;}

        $search = $request['search'];

        $sort = $request['sort'];



        $data = Post::where('type', $post_type);

        if($search != ''){

            $data->where('title', 'like', '%'.$search.'%');

        }



        if($sort != ''){

            switch ($request['sort']) {

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

        return $data->skip($start)->paginate(15);  



    }

    

    public function store($request){



        $slug = dsld_generate_slug_by_text_with_model('App\Models\Post', $request['title'], 'slug');



        if(isset($request['parent'])){

            $parent_slug = $this->parent_slug($request['parent']);

            $slug = $parent_slug.'/'.$slug;

        }

        

        $page = new Post;

        $page->title = $request['title'];

        $page->key_title = $request['title'];

        $page->meta_title = $request['title'];

        $page->meta_description =  $request['title'];

        $page->keywords =  $request['title'];



        if(isset($request['parent'])){

            $page->parent =  $request['parent'];

            $page->level =  $this->parent_level($request['parent']);

        }else{

            $page->parent =  0;

            $page->level =  1;

        }



        if(isset($request['short_content'])){

            $page->short_content =  $request['short_content'] ? $request['short_content'] : '';

        }



        $content = isset($request['content']) ? $request['content'] : '';

        $page->slug = $slug;

        $page->type = isset($request['type']) ? $request['type']: 'custom_page';

        $page->template = isset($request['templete']) ? $request['templete'] : 'default';

        $page->cat_type = isset($request['cat_type']) ? $request['cat_type'] : 0;

        $page->is_meta = 0;

        $page->banner = isset($request['banner']) ? $request['banner'] : 0;

        $page->status = isset($request['status']) ? $request['status'] : 0;

        $page->content = $content;

        

        if($page->save()){



            $page->translations()->create(['lang' => env('DEFAULT_LANGUAGE'), 'short_content' => $content, 'title' => $request['title'], 'content' => $content]);



            return 'success';

        }

    }



    public function find($id){

        return Post::find($id);

    }



    public function sections($id, $section_id = null){

        $data = $this->find($id);

        $data = $data->sections();



        if($section_id != null){

            return $data->where('id', $section_id)->orderBy('order', 'asc')->where('status', 1)->first();

        }



        return $data->orderBy('order', 'asc')->where('status', 1)->get();

    }



    public function destory($id){

        return $this->find($id)->delete();

    }



    public function update($id, $request){



        if(isset($request['setting']) && is_array($request['setting']) && count($request['setting']) > 0){

            foreach($request['setting'] as $key => $value){

                $setting = PostsMeta::where('meta_key', $value)->where('pageable_id', $request['id'])->first();

                if($setting != ''){

                    if($request[$value] !='' || $request[$value] !='null'){

                        $setting->meta_value = $request[$value];

                        $setting->lang = 'en';

                        $setting->pageable_type = 'App\Models\Post';

                        $setting->save();

                    }

                }else{

                    if($request[$value] !='' || $request[$value] !='null'){

                        $setting = new PostsMeta;

                        $setting->meta_key = $value;

                        $setting->meta_value = $request[$value];

                        $setting->lang = 'en';

                        $setting->pageable_id = $request['id'];

                        $setting->pageable_type = 'App\Models\Post';

                        $setting->save();

                    }

                } 

            }

        }

        

        if(isset($request['setting_slider']) && is_array($request['setting_slider']) && count($request['setting_slider']) > 0){



            foreach($request['setting_slider'] as $key => $value){

                if($value !=''){

                    $setting2 = PostsMeta::where('meta_key', $value)->where('pageable_id', $request['id'])->first();

                    if($setting2 != ''){

                        if(isset($request[$value])){

                            $setting2->meta_value = json_encode($request[$value]);

                            $setting2->lang = 'en';

                            $setting2->pageable_type = 'App\Models\Post';

                            $setting2->save();

                        }                        

                    }else{

                        if(isset($request[$value])){

                            $setting2 = new PostsMeta;

                            $setting2->meta_key = $value;

                            $setting2->meta_value = json_encode($request[$value]);

                            $setting2->lang = 'en';

                            $setting2->pageable_id = $request['id'];

                            $setting2->pageable_type = 'App\Models\Post';

                            $setting2->save();

                        } 

                    }

                }

            }

        }



        $content = isset($request['content']) ? $request['content'] : '';

        $page =  $this->find($id);





        if(isset($request['type']) && $request['type'] == 'custom_page'){

            if(isset($request['lang']) && $request['lang'] == env("DEFAULT_LANGUAGE")){

                if(isset($request['title'])){

                    $page->title = $request['title'];

                }

                if(isset($request['content'])){

                    $page->content = $request['content'];

                }

                if(isset($request['short_content'])){

                    $page->short_content = $request['short_content'];

                }

            }

        }else{

            if(isset($request['title'])){

                $page->title = $request['title'];

            }

            if(isset($request['content'])){

                $page->content = $request['content'];

            }

            if(isset($request['short_content'])){

                $page->short_content = $request['short_content'];

            }

        }



        if(isset($request['meta_title'])){

            $page->meta_title = $request['meta_title'];

        }



        if(isset($request['meta_description'])){

            $page->meta_description = $request['meta_description'];

        }



        if(isset($request['keywords'])){

            $page->keywords = $request['keywords'];

        }
        if(isset($request['indexing'])){

            $page->indexing = $request['indexing'];

        }



        if(isset($request['parent'])){

            $page->parent = $request['parent'];

        }



        if(isset($request['cat_type'])){

            $page->cat_type = $request['cat_type'];

        }



        if(isset($request['type'])){

            $page->type = $request['type'];

        }



        if(isset($request['template'])){

            $page->template = $request['template'];

        }



        if(isset($request['order'])){

            $page->order = $request['order'];

        }



        if(isset($request['banner'])){

            $page->banner = $request['banner'];

        }



        if(isset($request['status'])){

            $page->status = $request['status'];

        }



        if(isset($request['thumbnail'])){

            $page->thumbnail = $request['thumbnail'];

        }



        if(isset($request['parent'])){

            $page->level =  $this->parent_level($request['parent']);

        }



        $page->is_meta = 0;

        

        if(isset($request['slug'])){

            if($page->slug != $request['slug']){

                // $slug = dsld_generate_slug_by_text_with_model('App\Models\Post', $request['slug'], 'slug');

                // if(isset($request['parent']) != 0 && $page->parent != $request['parent']){

                //     $parent_slug = $this->parent_slug($request['parent']);

                //         $slug = $parent_slug.'/'.$slug;

                // }

                $page->slug = $request['slug'];

            }

        }

        

        if($page->save()){

            if(isset($request['type']) && ($request['type'] == 'custom_page' || $request['type'] == 'department_details' || $request['type'] == 'programs_details')){

                $trans = $page->translations()->where('lang', $request['lang'])->first();

                if(!is_null($trans)){

                    $trans->update(['title' => $request['title'], 'content' => $content,

                    'short_content' => $request['short_content']]);

                }else{

                    $page->translations()->create([

                        'title' => $request['title'],

                        'content' => $content,

                        'short_content' => $request['short_content'],

                        'lang' => $request['lang']

                    ]);

                }

            }

            return 'success';

        }

    }



    public function status($data){

        $page = $this->find($data['id']);



        if($page != ''){

            if($page->status != $data['status']){

                $page->status = $data['status'];

                $page->save();

                return 'success';

            }

        }



        return 'nfound';

    }



    public function parent_level($parent_id){

        if($parent_id > 0){

            return $this->find($parent_id)->level + 1;

        }else{

            return 1;

        } 

    }



    public function parent_slug($parent_id){

        if($parent_id > 0){

            return $this->find($parent_id)->slug;

        }

    }



}

