<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\File;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable  implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, InteractsWithMedia,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function reads(){
        return $this->morphMany(Read::class, 'readable');
    }
    
    public function langs(){
        return $this->belongsTo(Language::class, 'lang');
    }
    
    public function employe(){
        return $this->hasOne(Employe::class, 'user_id');
    }


    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('user')->registerMediaConversions( function (Upload $upload = null){
            $this->addMediaConversion('full')
              ->format('webp');
            $this->addMediaConversion('thumb')
                ->format('webp')
                ->width(600)
                ->height(300);
            $this->addMediaConversion('cover')
                ->format('webp')
                ->width(175)
                ->height(75);
            $this->addMediaConversion('avatar')
                ->format('webp')
                ->width(80)
                ->height(80);
            $this->addMediaConversion('placeholder')
              ->format('webp')->blur(10);
        });
    }
}
