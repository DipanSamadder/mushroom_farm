<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class PostsMeta extends Model
{
    
    protected $fillable = ['meta_key','meta_value', 'section_id', 'lang', 'pageable_id', 'pageable_type'];
    public function subject(){
    	return $this->morph('pageable');
    }
}
