<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomEmployee extends Model
{
  public function labourRates(){
    return $this->belongsTo(LabourRate::class, 'labours_type');
  }

  public function rooms(){
    return $this->belongsTo(Room::class, 'room_history_id');
  }

}
