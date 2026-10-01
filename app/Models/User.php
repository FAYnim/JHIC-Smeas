<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_ADMIN = 'admin';

    public const ROLE_BKK = 'bkk';

    public const ROLE_HUMAS = 'humas';

    public const ROLE_SPMB = 'spmb';

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

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * @param  list<string>  $roles
     */
    public function hasRole(array $roles): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        return $this->role !== null && in_array($this->role, $roles, true);
    }

    /**
     * Label peran untuk ditampilkan di UI.
     */
    public function roleLabel(): string
    {
        return match ($this->role) {
            self::ROLE_ADMIN => 'Super Admin',
            self::ROLE_BKK => 'BKK (Pusat Karir)',
            self::ROLE_HUMAS => 'Humas',
            self::ROLE_SPMB => 'Panitia SPMB',
            default => 'Belum Ditugaskan',
        };
    }
}
