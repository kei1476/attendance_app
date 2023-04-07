<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rest extends Model
{
    protected $fillable = [
        'user_id',
        'attendance_id',
        'work_date',
        'start_time',
        'end_time',
    ];
}
