<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostTranslation extends Model
{
  protected $fillable = [ 'title', 'short_content', 'content', 'lang', 'pageable_id'];

  public function post(){
    return $this->belongsTo(Post::class);
  }

  public function subject(){
    return $this->morph('pageable');
  }

}
