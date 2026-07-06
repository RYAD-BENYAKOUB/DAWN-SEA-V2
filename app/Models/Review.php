<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'program_id',
        'rating',
        'comment',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
        ];
    }

    /**
     * Get the user who wrote this review.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the program this review belongs to.
     */
    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
