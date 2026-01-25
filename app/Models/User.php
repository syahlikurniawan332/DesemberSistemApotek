<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
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
        ];
    }

    // relasi 
    public function batches()
    {
        return $this->hasMany(Batch::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }


    public function getAvatarUrlAttribute(): string
    {
        // Jika avatar ada
        if (!empty($this->avatar)) {

            // Jika avatar berupa URL (misal dari OAuth / CDN)
            if (filter_var($this->avatar, FILTER_VALIDATE_URL)) {
                return $this->avatar;
            }

            // Jika avatar disimpan di storage lokal
            return asset('storage/' . $this->avatar);
        }

        // Jika tidak ada avatar, gunakan default image lokal
        return asset('images/default-avatar.png');
    }


    public function role($role)
    {
        return $this->role === $role;
    }
}
