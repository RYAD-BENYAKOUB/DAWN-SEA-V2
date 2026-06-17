<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'guide_id',
        'title',
        'slug',
        'description',
        'location',
        'duration',
        'price',
        'max_participants',
        'difficulty',
        'image',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'max_participants' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Boot method to auto-generate slug.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($program) {
            if (empty($program->slug)) {
                $program->slug = Str::slug($program->title);
            }
        });
    }

    /**
     * Get the guide that owns this program.
     */
    public function guide()
    {
        return $this->belongsTo(Guide::class);
    }

    /**
     * Get users who favorited this program.
     */
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    /**
     * Get visits for this program.
     */
    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

    /**
     * Get the route key name.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
