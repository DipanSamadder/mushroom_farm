<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cycle extends Model
{
    public function laboursRates(){
    return $this->belongsTo(LabourRate::class, 'labours_type');
    }
}
