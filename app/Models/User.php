<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'cpf',
        'birth_date',
        'phone',
        'photo',
        'membership',
        'status',
        'password',
        'last_login_at',
        'last_login_ip',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date',
            'last_login_at' => 'datetime',
        ];
    }

    /**
     * Get the user's full name.
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Get the user's photo URL.
     */
    public function getPhotoUrlAttribute(): string
    {
        return $this->photo ? asset('storage/' . $this->photo) : asset('assets/images/default-avatar.png');
    }

    public function purchasedMaterials()
    {
        return $this->hasManyThrough(
            \Modules\Library\Models\LibraryResource::class,
            \Modules\Billing\Models\MaterialPurchase::class,
            'user_id', // Foreign key on material_purchases table...
            'id', // Foreign key on library_resources table...
            'id', // Local key on users table...
            'library_resource_id' // Local key on material_purchases table...
        );
    }

    // Direct relationship for checking existence
    public function purchases()
    {
        return $this->hasMany(\Modules\Billing\Models\MaterialPurchase::class);
    }
}
