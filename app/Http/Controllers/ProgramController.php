<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProgramController extends Controller
{
    /**
     * Display a listing of the programs (public).
     */
    public function index(Request $request)
    {
        $query = Program::where('is_active', true)->with('guide.user');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Difficulty filter
        if ($request->filled('difficulty')) {
            $query->where('difficulty', $request->input('difficulty'));
        }

        // Price filter
        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->input('price_max'));
        }

        $programs = $query->latest()->paginate(9);

        return view('programs.index', compact('programs'));
    }

    /**
     * Display the specified program (public).
     */
    public function show($slug, Request $request)
    {
        $program = Program::where('slug', $slug)
            ->where('is_active', true)
            ->with(['guide.user', 'guide'])
            ->firstOrFail();

        // Record visit statistics
        Visit::create([
            'program_id' => $program->id,
            'user_id' => Auth::id(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'visited_at' => now(),
        ]);

        // Get related programs from same guide or same location
        $relatedPrograms = Program::where('is_active', true)
            ->where('id', '!=', $program->id)
            ->where(function($q) use ($program) {
                $q->where('guide_id', $program->guide_id)
                  ->orWhere('location', $program->location);
            })
            ->take(3)
            ->get();

        return view('programs.show', compact('program', 'relatedPrograms'));
    }

    /**
     * Show the form for creating a new program (guide only).
     */
    public function create()
    {
        return view('dashboard.programs.create');
    }

    /**
     * Store a newly created program in storage (guide only).
     */
    public function store(Request $request)
    {
        $guide = Auth::user()->guide;

        if (!$guide) {
            return redirect()->back()->with('error', 'Profil de guide introuvable.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:programs,title',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'max_participants' => 'required|integer|min:1',
            'difficulty' => 'required|in:facile,modéré,difficile',
            'image_url' => 'nullable|url',
        ]);

        $program = new Program($validated);
        $program->guide_id = $guide->id;
        $program->is_active = true; // Active by default
        $program->save();

        return redirect()->route('dashboard')->with('success', 'Le programme a été créé avec succès !');
    }

    /**
     * Show the form for editing the specified program (guide only).
     */
    public function edit(Program $program)
    {
        // Authorize: ensure the program belongs to the logged-in guide
        $guide = Auth::user()->guide;
        if (!$guide || $program->guide_id !== $guide->id) {
            abort(403, 'Action non autorisée.');
        }

        return view('dashboard.programs.edit', compact('program'));
    }

    /**
     * Update the specified program in storage (guide only).
     */
    public function update(Request $request, Program $program)
    {
        // Authorize: ensure the program belongs to the logged-in guide
        $guide = Auth::user()->guide;
        if (!$guide || $program->guide_id !== $guide->id) {
            abort(403, 'Action non autorisée.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:programs,title,' . $program->id,
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'max_participants' => 'required|integer|min:1',
            'difficulty' => 'required|in:facile,modéré,difficile',
            'image_url' => 'nullable|url',
            'is_active' => 'boolean',
        ]);

        // If is_active is missing in request (e.g. checkbox unchecked), set to false
        $validated['is_active'] = $request->has('is_active');

        $program->update($validated);

        return redirect()->route('dashboard')->with('success', 'Le programme a été mis à jour avec succès !');
    }

    /**
     * Remove the specified program from storage (guide only).
     */
    public function destroy(Program $program)
    {
        // Authorize: ensure the program belongs to the logged-in guide
        $guide = Auth::user()->guide;
        if (!$guide || $program->guide_id !== $guide->id) {
            abort(403, 'Action non autorisée.');
        }

        $program->delete();

        return redirect()->route('dashboard')->with('success', 'Le programme a été supprimé avec succès !');
    }
}
