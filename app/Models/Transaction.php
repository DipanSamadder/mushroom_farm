<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public function payment_modes(){
        return $this->belongsTo(Type::class, 'payment_mode');
    }

    public function users(){
        return $this->belongsTo(User::class, 'emp_id');
    }
}
