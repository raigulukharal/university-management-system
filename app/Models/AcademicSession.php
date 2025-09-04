<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AcademicSession extends Model
{
    use HasFactory;

    protected $table = 'academic_sessions'; 
    
    protected $fillable = ['year'];

    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'session_id');
    }
}