<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
  public function categories(){
    return $this->belongsTo(ProCategory::class, 'categories_id');
  }

  public function roomsHistory(){
    return $this->belongsTo(RoomHistory::class, 'rooms_id');
  }

  public function users(){
    return $this->belongsTo(User::class, 'vendor_id');
  }

  public function grades(){
    return $this->belongsTo(Grade::class, 'grades_id');
  }
  public function vendors(){
    return $this->belongsTo(Vendor::class, 'vendor_id', 'user_id');
  }

}
