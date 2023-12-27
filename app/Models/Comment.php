<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [ 'dogs_id','parents_id','level','content'];

    public function subject(){
    	return $this->morphTo('commentable');
    }

    
    public function dog(){
    	return $this->belongsTo(Dog::class, 'dogs_id');
    }

    public function replyComment()
    {
        return $this->hasMany(Comment::class,'parents_id');
    }

    public function allReplyComment()
    {
        return $this->replyComment()->with('allReplyComment');
    }
}
