<?php



namespace App\Models;


use App;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;



class Post extends Model

{

    public function getTranslation($field = '', $lang = false){

        $lang = $lang == false ? App::getLocale() : $lang;

        $page_translation = $this->hasMany(PostTranslation::class, 'pageable_id')->where('lang', $lang)->first();

        return $page_translation != null ? $page_translation->$field : $this->$field;

    }

  

    public function translations(){

      return $this->morphMany(PostTranslation::class, 'pageable');

    }



    public function sections(){

        return $this->morphMany(PostsSection::class, 'pageable');

    }

    

    public function page_metas(){

        return $this->morphMany(PostsMeta::class, 'pageable');

    }



    public function parents(){

        return $this->belongsTo(Post::class, 'parent', 'id');

    }



    protected static function booted () {

        static::deleting(function(Post $post) { 

                $post->sections()->delete();

                // do the rest of the cleanup...

        });

        static::deleting(function(Post $post) { 

            $post->translations()->delete();

            // do the rest of the cleanup...

        });

        static::deleting(function(Post $post) { 

            $post->page_metas()->delete();

            // do the rest of the cleanup...

        });

    }



}

