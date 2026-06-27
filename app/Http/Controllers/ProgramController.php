<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\DTOs\Program\CreateProgramDTO;
use App\DTOs\Program\UpdateProgramDTO;
use App\Actions\Program\CreateProgramAction;
use App\Actions\Program\UpdateProgramAction;
use App\Actions\Program\DeleteProgramAction;
use App\Exceptions\ProgramOwnershipException;

class ProgramController extends Controller
{
    public function __construct(
        private CreateProgramAction $createProgramAction,
        private UpdateProgramAction $updateProgramAction,
        private DeleteProgramAction $deleteProgramAction
    ) {}

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

        // Location filter
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->input('location') . '%');
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

        $dto = CreateProgramDTO::fromRequest($request);
        $this->createProgramAction->execute($dto, $guide);

        return redirect()->route('dashboard')->with('success', 'Le programme a été créé avec succès !');
    }

    /**
     * Show the form for editing the specified program (guide only).
     */
    public function edit(Program $program)
    {
        $this->authorizeGuideOwnership($program);

        return view('dashboard.programs.edit', compact('program'));
    }

    /**
     * Update the specified program in storage (guide only).
     */
    public function update(Request $request, Program $program)
    {
        $this->authorizeGuideOwnership($program);

        $dto = UpdateProgramDTO::fromRequest($request, $program);
        $this->updateProgramAction->execute($dto, $program);

        return redirect()->route('dashboard')->with('success', 'Le programme a été mis à jour avec succès !');
    }

    /**
     * Remove the specified program from storage (guide only).
     */
    public function destroy(Program $program)
    {
        $this->authorizeGuideOwnership($program);

        $this->deleteProgramAction->execute($program);

        return redirect()->route('dashboard')->with('success', 'Le programme a été supprimé.');
    }

    /**
     * Ensure the logged-in user is a guide and owns the program.
     * @throws ProgramOwnershipException
     */
    private function authorizeGuideOwnership(Program $program)
    {
        $guide = Auth::user()->guide;
        if (!$guide || $program->guide_id !== $guide->id) {
            throw new ProgramOwnershipException();
        }
    }
}
