<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVerified extends Model{
	protected $fillable = ['user_id', 'otp', 'expire_at'];
}




