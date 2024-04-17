<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    public function framesType(){
        return $this->belongsTo(ProCategory::class, 'purchase_from');
    }
}
