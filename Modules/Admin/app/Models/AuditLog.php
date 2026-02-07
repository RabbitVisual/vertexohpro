<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
<<<<<<< HEAD
=======
use App\Models\User;
>>>>>>> origin/classrecord-module-setup-347080406940848607

class AuditLog extends Model
{
    use HasFactory;

<<<<<<< HEAD
    protected $fillable = [
        'user_id',
        'action',
        'module',
        'description',
        'metadata',
        'ip_address',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
=======
    protected $fillable = ['user_id', 'action', 'description', 'ip_address'];

    public function user()
    {
        return $this->belongsTo(User::class);
>>>>>>> origin/classrecord-module-setup-347080406940848607
    }
}
