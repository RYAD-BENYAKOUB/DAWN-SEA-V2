<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the guide dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        $guide = $user->guide;

        // Fallback for guides without a guide profile yet
        $guideId = $guide?->id;

        // KPI Stats
        $stats = [
            'total_visits' => $guideId ? Visit::whereHas('program', fn($q) => $q->where('guide_id', $guideId))->count() : 0,
            'active_programs' => $guideId ? Program::where('guide_id', $guideId)->where('is_active', true)->count() : 0,
            'favorites_received' => $guideId ? DB::table('favorites')
                ->join('programs', 'favorites.program_id', '=', 'programs.id')
                ->where('programs.guide_id', $guideId)
                ->count() : 0,
            'rating' => $guide?->rating ?? 0,
        ];

        // Programs list
        $programs = $guideId ? Program::where('guide_id', $guideId)->latest()->get() : collect();

        // Recent favorites
        $recentFavorites = $guideId ? DB::table('favorites')
            ->join('programs', 'favorites.program_id', '=', 'programs.id')
            ->join('users', 'favorites.user_id', '=', 'users.id')
            ->where('programs.guide_id', $guideId)
            ->orderBy('favorites.created_at', 'desc')
            ->take(5)
            ->select('users.name as user_name', 'programs.title as program_title')
            ->get() : collect();

        $chartData = $this->getMonthlyVisitChart($guideId);

        return view('dashboard.index', compact('stats', 'programs', 'recentFavorites', 'chartData'));
    }

    /**
     * Return stats data as JSON (for AJAX chart updates).
     */
    public function stats(Request $request)
    {
        $user = Auth::user();
        $guide = $user->guide;
        $guideId = $guide?->id;

        return response()->json($this->getMonthlyVisitChart($guideId));
    }

    /**
     * Get chart data for monthly visits.
     */
    private function getMonthlyVisitChart($guideId)
    {
        $chartData = [['Mois', 'Visites']];
        if (!$guideId) {
            return $chartData;
        }

        $monthlyVisits = Visit::whereHas('program', fn($q) => $q->where('guide_id', $guideId))
            ->where('visited_at', '>=', now()->subMonths(12))
            ->selectRaw("TO_CHAR(visited_at, 'MM') as month, COUNT(*) as count")
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month');

        $months = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = [$months[$i - 1], $monthlyVisits[str_pad($i, 2, '0', STR_PAD_LEFT)] ?? 0];
        }

        return $chartData;
    }
}
