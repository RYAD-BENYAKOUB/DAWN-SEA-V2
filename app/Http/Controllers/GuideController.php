<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use Illuminate\Http\Request;

class GuideController extends Controller
{
    public function index()
    {
        // Fetch all guides with their users
        $allGuides = Guide::with('user')->get();
        
        // Sort so that Yasmine Fellahi is first
        $guides = $allGuides->sortByDesc(function ($guide) {
            return $guide->user->name === 'Yasmine Fellahi' ? 1 : 0;
        })->values();

        return view('guides.index', compact('guides'));
    }
}
