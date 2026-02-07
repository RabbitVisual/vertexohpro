<?php

namespace Modules\ClassRecord\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SchoolClass extends Model
{
    use HasFactory;

<<<<<<< HEAD
    protected $table = 'classes';
    protected $fillable = ['name', 'subject', 'year', 'user_id'];

    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'class_id');
    }

    public function grades()
    {
        return $this->hasMany(Grade::class, 'class_id');
=======
    protected $fillable = ['user_id', 'name', 'year', 'subject'];

    public function students()
    {
        return $this->hasMany(Student::class);
>>>>>>> origin/jules/planning-module-init-11986219447505815665
    }
}
