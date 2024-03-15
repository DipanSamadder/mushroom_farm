<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
  public function grade(){
    return $this->belongsTo(Grade::class, 'grades_id');
  }

  public function roomHistories(){
    return $this->belongsTo(RoomHistory::class, 'rooms_id');
  }

}
