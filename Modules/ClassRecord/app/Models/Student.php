<?php

namespace Modules\ClassRecord\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
<<<<<<< HEAD
use Modules\Core\Traits\Auditable;

class Student extends Model
{
    use HasFactory, Auditable;

    protected $fillable = ['class_id', 'name', 'registration_number'];

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
=======

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'school_class_id', 'email', 'guardian_email'];

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class);
>>>>>>> origin/feature/teacher-panel-widgets-12290637904403310292
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
