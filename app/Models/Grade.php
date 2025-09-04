<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $table = 'grades';

    protected $fillable = [
        'student_id',
        'semester',
        'marks',
        'CH',
        'status',
        'course_id',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}