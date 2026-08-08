<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'phone',
        'country_of_birth',
        'birth_date',
        'avatar',
        'password',
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
     * Check if the user is a guide/organisateur.
     */
    public function isGuide(): bool
    {
        return $this->hasRole('Organisateur') || $this->role === 'guide';
    }

    /**
     * Check if the user is a regular user.
     */
    public function isUser(): bool
    {
        return $this->hasRole('Participant') || $this->role === 'user';
    }

    /**
     * Check if the user is a superadmin.
     */
    public function isSuperadmin(): bool
    {
        return $this->hasRole('SuperAdmin') || $this->role === 'superadmin';
    }

    /**
     * Check if the user is an admin or superadmin.
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('SuperAdmin') || in_array($this->role, ['admin', 'superadmin']);
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

    /**
     * Get all reviews written by this user.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Check if the user has already reviewed a program.
     */
    public function hasReviewed(Program $program): bool
    {
        return $this->reviews()->where('program_id', $program->id)->exists();
    }
}
