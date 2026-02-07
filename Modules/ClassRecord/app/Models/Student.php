<?php

namespace Modules\ClassRecord\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Core\Traits\Auditable;

class Student extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'class_id',
        'name',
        'first_name',
        'last_name',
        'email',
        'guardian_email',
        'registration_number',
        'number'
    ];

    public function getFullNameAttribute()
    {
        if ($this->first_name && $this->last_name) {
            return "{$this->first_name} {$this->last_name}";
        }
        return $this->name;
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
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
