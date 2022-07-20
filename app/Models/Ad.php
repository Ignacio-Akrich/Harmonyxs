<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Ad extends Model
{
    use HasFactory;
    protected $table = 'ads';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id','title', 'description', 'image', 'music_genre'];
    // protected $guarded = ['created_at', 'updated_at', 'availabilities_id'];
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function availability()
    {
        return $this->hasOne(Availability::class , 'availabilities_id');
    }
}
