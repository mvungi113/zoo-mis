<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetectionLog extends Model
{
    use HasFactory;

    protected $fillable = ['camera', 'animal_name', 'classification', 'confidence'];
}
