<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{
    use HasFactory;
    protected $table = 'social_media';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'youtube', 'instagram', 'pagweb', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'social_media_id');
    }
}
