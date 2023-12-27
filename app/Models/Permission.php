<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as SatiePermission;
use Illuminate\Database\Eloquent\Model;

class Permission extends SatiePermission
{
    use HasFactory;
    protected $fillable = ['guard_name', 'name', 'title', 'status'];
}
