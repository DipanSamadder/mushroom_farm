<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomEmployee extends Model
{
  protected $fillable = ['status'];
  public function labourRates(){
    return $this->belongsTo(LabourRate::class, 'labours_type');
  }

  public function roomHistory(){
    return $this->belongsTo(RoomHistory::class, 'room_history_id');
  }

}
