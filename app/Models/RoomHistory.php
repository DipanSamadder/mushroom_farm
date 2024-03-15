<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomHistory extends Model
{
  protected $fillable = ['status','current_status', 'end_date'];


  public function rooms(){
    return $this->belongsTo(Room::class, 'room_id');
  }
  

  public function cycles(){
    return $this->belongsTo(Cycle::class, 'current_status');
  }

}
