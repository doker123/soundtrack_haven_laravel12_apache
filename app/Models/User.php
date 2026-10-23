<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
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
        'role_id',
        'avatar_id'
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

    /**
     * Роль пользователя.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
    /**
     * Аватар пользователя
     */
    public function avatar(): BelongsTo
    {
        return $this->belongsTo(Avatar::class);
    }
    /**
     * Баны пользователя
     */
    public function bans(): HasMany
    {
        return $this->hasMany(Ban::class);
    }

    /**
     * Баны, выданные этим пользователем (как модератором).
    */
    public function issuedBans(): HasMany
    {
        return $this->hasMany(Ban::class, 'banned_by_id');
    }

    /**
     * Проверка роли по имени, например: $user->hasRole('admin').
     */
    public function hasRole(string $name): bool
    {
        return $this->role?->name === $name;
    }
    /**
     * Избранные треки пользователя.
     */
    public function favoriteTracks(): BelongsToMany
    {
        return $this->belongsToMany(Track::class, 'favorites')
            ->withTimestamps()
            ->orderByPivot('created_at', 'desc');
    }
    /**
    * История прослушивания пользователя.
    */
    public function listeningHistory(): HasMany
    {
        return $this->hasMany(ListeningHistory::class)->latest('played_at');
    }

}
