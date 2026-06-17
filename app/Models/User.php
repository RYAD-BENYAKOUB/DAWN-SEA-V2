<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        'role',
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
     * Check if the user is a guide.
     */
    public function isGuide(): bool
    {
        return $this->role === 'guide';
    }

    /**
     * Check if the user is a regular user.
     */
    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    /**
     * Get the guide profile associated with the user.
     */
    public function guide()
    {
        return $this->hasOne(Guide::class);
    }

    /**
     * Get the user's favorite programs.
     */
    public function favoritePrograms()
    {
        return $this->belongsToMany(Program::class, 'favorites')->withTimestamps();
    }

    /**
     * Check if the user has favorited a program.
     */
    public function hasFavorited(Program $program): bool
    {
        return $this->favoritePrograms()->where('program_id', $program->id)->exists();
    }
}
