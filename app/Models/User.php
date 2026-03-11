<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'company',
        'bio',
        'avatar_path',
        'preferences',
        'last_login_at',
        'role',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'preferences' => 'array',
            'last_login_at' => 'datetime',
        ];
    }

    /**
     * Get the avatar URL for AdminLTE user menu.
     *
     * @return string
     */
    public function adminlte_image()
    {
        return $this->avatar_path 
            ? asset('storage/' . $this->avatar_path) 
            : asset('vendor/adminlte/dist/img/user2-160x160.jpg');
    }

    /**
     * Get the profile description for AdminLTE user menu.
     *
     * @return string
     */
    public function adminlte_desc()
    {
        return $this->email ?? '';
    }

    /**
     * Get the avatar URL with fallback.
     *
     * @return string
     */
    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar_path 
            ? asset('storage/' . $this->avatar_path) 
            : asset('vendor/adminlte/dist/img/user2-160x160.jpg');
    }
}