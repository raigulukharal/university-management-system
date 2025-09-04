<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'roll_no',
        'student_name',
        'course_name',
        'obtained_mark',
        'credit_hour',
        'gp',
        'gpa',
        'session_id',
    ];
}
