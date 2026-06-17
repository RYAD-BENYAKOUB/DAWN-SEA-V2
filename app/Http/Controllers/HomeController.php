<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the homepage.
     */
    public function index()
    {
        $programs = Program::where('is_active', true)
            ->with('guide.user')
            ->latest()
            ->take(6)
            ->get();

        $stats = [
            'programs' => Program::where('is_active', true)->count() ?: 50,
            'guides' => \App\Models\Guide::where('is_verified', true)->count() ?: 20,
            'destinations' => Program::where('is_active', true)->distinct('location')->count('location') ?: 15,
            'travelers' => \App\Models\User::where('role', 'user')->count() ?: 500,
        ];

        return view('home', compact('programs', 'stats'));
    }
}
