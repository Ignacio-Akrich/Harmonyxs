<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    use HasFactory;

    protected $table = 'availabilities';
    protected $primaryKey = 'id';
    protected $fillable = ['allday', 'morning', 'afternoon', 'night'];

    public function ads()
    {
        return $this->belongsTo(Ad::class, 'availabilities_id');
    }
}
