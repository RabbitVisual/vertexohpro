<?php

namespace Modules\ClassRecord\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Core\Traits\Auditable;

class SchoolClass extends Model
{
    use HasFactory, Auditable;

    protected $fillable = ['user_id', 'name', 'year', 'subject'];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
