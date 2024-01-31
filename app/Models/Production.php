<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
  public function grade(){
    return $this->belongsTo(Grade::class, 'grades_id');
  }
  public function room(){
    return $this->belongsTo(Room::class, 'rooms_id');
  }
}
