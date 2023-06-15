<?php

declare(strict_types=1);

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\Roles;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    /** @return BelongsToMany<Role> */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function isAdmin(): bool
    {
        return $this->roles()->whereName(Roles::Admin)->exists();
    }

    public function isEditor(): bool
    {
        return $this->roles()->whereName(Roles::Editor)->exists();
    }

    public function createNewUser(string $email, ?string $password): static
    {
        if (empty($email)) {
            throw new InvalidArgumentException('Email no provided.');
        }
        if (is_null($password)) {
            $password = Str::password(18);
        }

        $this->fill([
            'email' => $email,
            'password' => $password,
        ]);
        $this->save();

        return $this;
    }

    public function addRole(Roles $role): static
    {
        $roleToAssign = Role::firstOrCreate(['name' => $role]);
        $this->roles()->attach($roleToAssign);

        return $this;
    }
}
