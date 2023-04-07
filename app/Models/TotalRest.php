<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TotalRest extends Model
{
    protected $fillable = [
        'attendance_id',
        'rest_id',
        'total_rest'
    ];
}
