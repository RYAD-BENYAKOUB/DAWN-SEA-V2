<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store or update a review for a program.
     */
    public function store(Request $request, Program $program)
    {
        $validated = $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
        ], [
            'rating.required'  => 'Veuillez attribuer une note.',
            'rating.min'       => 'La note minimale est 1 étoile.',
            'rating.max'       => 'La note maximale est 5 étoiles.',
            'comment.required' => 'Le commentaire est obligatoire.',
            'comment.min'      => 'Le commentaire doit contenir au moins 10 caractères.',
            'comment.max'      => 'Le commentaire ne peut pas dépasser 1000 caractères.',
        ]);

        // Upsert: create or update the user's review for this program
        Review::updateOrCreate(
            [
                'user_id'    => Auth::id(),
                'program_id' => $program->id,
            ],
            [
                'rating'  => $validated['rating'],
                'comment' => $validated['comment'],
            ]
        );

        return redirect()
            ->route('programs.show', $program->slug)
            ->with('success', 'Votre avis a été publié avec succès !');
    }

    /**
     * Delete the user's own review.
     */
    public function destroy(Review $review)
    {
        if ($review->user_id !== Auth::id()) {
            abort(403, 'Action non autorisée.');
        }

        $program = $review->program;
        $review->delete();

        return redirect()
            ->route('programs.show', $program->slug)
            ->with('success', 'Votre avis a été supprimé.');
    }
}
