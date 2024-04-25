<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  protected $fillable = ['categories_id', 'vendor_id', 'total', 'tax', 'grand_total', 'paid','created_invoices','created_by', 'updated_by'];

  public function vendors(){
    return $this->belongsTo(Vendor::class, 'vendor_id', 'user_id');
  }
  
  public function users(){
    return $this->belongsTo(User::class, 'vendor_id');
  }
}
