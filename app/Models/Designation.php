<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    public function parents(){
        return $this->belongsTo(Designation::class, 'parent');
      }
}
