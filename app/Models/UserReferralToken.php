<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserReferralToken extends Model
{
     protected $fillable = ['user_id', 'referrals_code', 'referrals_token', 'expire_at'];
}
