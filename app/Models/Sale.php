<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
  public function categories(){
    return $this->belongsTo(ProCategory::class, 'categories_id');
  }
}
