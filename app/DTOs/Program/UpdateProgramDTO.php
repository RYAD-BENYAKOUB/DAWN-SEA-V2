<?php

namespace App\DTOs\Program;

use Illuminate\Http\Request;
use App\Models\Program;

class UpdateProgramDTO
{
    public function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly string $location,
        public readonly string $duration,
        public readonly float $price,
        public readonly int $maxParticipants,
        public readonly string $difficulty,
        public readonly bool $isActive,
        public readonly ?string $imageUrl = null,
    ) {}

    /**
     * Crée le DTO à partir des données validées de la requête.
     */
    public static function fromRequest(Request $request, Program $program): self
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:programs,title,' . $program->id,
            'description' => 'required|string|max:10000',
            'location' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'max_participants' => 'required|integer|min:1',
            'difficulty' => 'required|in:facile,modéré,difficile',
            'image_url' => 'nullable|url',
            'is_active' => 'boolean',
        ]);

        return new self(
            title: $validated['title'],
            description: $validated['description'],
            location: $validated['location'],
            duration: $validated['duration'],
            price: (float)$validated['price'],
            maxParticipants: (int)$validated['max_participants'],
            difficulty: $validated['difficulty'],
            isActive: $request->has('is_active'),
            imageUrl: $validated['image_url'] ?? null
        );
    }
}
