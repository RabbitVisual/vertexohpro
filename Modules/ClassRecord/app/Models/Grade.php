<?php

namespace Modules\ClassRecord\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'subject', 'score', 'bncc_skill_code'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
