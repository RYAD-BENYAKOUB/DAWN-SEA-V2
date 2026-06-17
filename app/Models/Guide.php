<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bio',
        'phone',
        'location',
        'speciality',
        'avatar',
        'rating',
        'is_verified',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'decimal:2',
            'is_verified' => 'boolean',
        ];
    }

    /**
     * Get the user that owns this guide profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the programs created by this guide.
     */
    public function programs()
    {
        return $this->hasMany(Program::class);
    }
}
