<?php

namespace Modules\ClassRecord\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

<<<<<<< HEAD
    protected $fillable = ['name', 'class_id'];

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
=======
    protected $fillable = ['school_class_id', 'name', 'registration_number'];

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class);
>>>>>>> origin/jules/planning-module-init-11986219447505815665
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}
