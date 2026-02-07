<?php

namespace Modules\ClassRecord\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SchoolClass extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'is_multigrade', 'grades_covered'];

    protected $casts = [
        'is_multigrade' => 'boolean',
        'grades_covered' => 'array',
    ];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
