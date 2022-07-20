<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
// Implementando el sistema de roles y permisos con Spatie
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'music_genre',
        'age',
        'description',
        'profile_photo',
        'header_photo',
        'telephone',
        'availability_table',
        'experience',
        'band_experience',
        'date_of_birth',
        'gender',
        'member',
        'concert_experience',
        'creation_date',
        'address_rehearsal_room',
        'instrument_id',
        'social_media_id',
        'address',
        "published_ad_id",
        'lat',
        'lng',
        'instrumento',
        //'saved_ad_id'
    ];

    public function socialMedia()
    {
        return $this->hasOne('App\Models\SocialMedia' , 'social_media_id');
    }

//    public function location()
//    {
//        return $this->hasOne('App\Models\Location' , 'location_id');
//    }

    /* public function savedAd()
    {
        return $this->hasMany('App\Models\Ad' , 'saved_ad_id');
    } */

    public function ads(){
        return $this->hasMany(Ad::class, "published_ad_id", 'id');
    }


    public function instrument()
    {
        return $this->hasMany('App\Models\Instrument' , 'instrument_id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'availability_table' => 'array',
        'music_genre' => 'array',
        'member' => 'array',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];
}
