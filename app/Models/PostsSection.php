<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class PostsSection extends Model
{

    protected $fillable = ['title','key_title', 'order', 'status', 'meta_fields', 'pageable_id'];
    
    public function pages(){
        return $this->belongsTo(Post::class, 'pageable_id');
    }
    public function subject(){
    	return $this->morph('pageable');
    }
}
