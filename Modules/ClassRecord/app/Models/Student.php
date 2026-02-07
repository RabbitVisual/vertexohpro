<?php

namespace Modules\ClassRecord\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'last_name', 'email'];

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    protected $fillable = ['name', 'school_class_id', 'email', 'guardian_email'];
    protected $fillable = ['school_class_id', 'name', 'number'];

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class);
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
