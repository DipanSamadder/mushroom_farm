<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomCycle extends Model
{
    public function cycles(){
        return $this->belongsTo(Cycle::class, 'cycle_id');
    }
}
