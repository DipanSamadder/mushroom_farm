<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomHistory extends Model
{
  public function rooms(){
    return $this->belongsTo(Room::class, 'room_id');
  }
  

}
