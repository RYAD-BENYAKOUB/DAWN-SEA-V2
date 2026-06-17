<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $fillable = [
        'program_id',
        'user_id',
        'ip_address',
        'user_agent',
        'visited_at',
    ];

    protected function casts(): array
    {
        return [
            'visited_at' => 'datetime',
        ];
    }

    /**
     * Get the program that was visited.
     */
    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * Get the user who visited (nullable).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
