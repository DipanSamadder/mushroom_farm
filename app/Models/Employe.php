<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employe extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
