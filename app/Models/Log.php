<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = [
        'animal_name',
        'confidence',
        'classification',
    ];

    // Disable auto-incrementing timestamps (if you're manually setting timestamp)
    public $timestamps = true;
}
