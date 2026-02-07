<?php

namespace Modules\ClassRecord\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'date', 'present'];

    protected $casts = [
        'date' => 'date',
        'present' => 'boolean',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
