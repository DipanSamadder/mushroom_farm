<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomCycle extends Model
{
    protected $fillable = [
        'status'
    ];
    public function cycles(){
        return $this->belongsTo(Cycle::class, 'cycle_id');
    }
}
