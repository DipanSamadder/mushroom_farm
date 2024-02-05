<?php



namespace App\Models;


use App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Type extends Model

{


    public function parents(){

        return $this->belongsTo(Type::class, 'parent', 'id');

    }



}

