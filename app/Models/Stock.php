<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = ['grades_id', 'total', 'sold_out', 'stock', 'demarge'];


    public function grades(){
        return $this->belongsTo(Grade::class, 'grades_id');
    }
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($stocks) {
            if ($stocks->isDirty('sold_out')) {
                if (!$stocks->sold_out) {
                    $stocks->stock = $stocks->total;
                } else {
                    $stocks->stock = $stocks->total - $stocks->sold_out;
                }
            }
            if ($stocks->isDirty('total')) {
                if ($stocks->total) {
                    $stocks->stock = $stocks->total;
                }
            }
        });
    }
}
