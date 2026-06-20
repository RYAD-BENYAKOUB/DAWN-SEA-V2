<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Program;
use App\Models\Guide;
use Illuminate\Http\Request;

class SuperAdminDashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalGuides = User::where('role', 'guide')->count();
        $totalAdmins = User::whereIn('role', ['admin', 'superadmin'])->count();
        $totalRegularUsers = User::where('role', 'user')->count();
        $totalPrograms = Program::count();

        // Data for Role Pie Chart
        $roleData = [
            ['Rôle', 'Nombre'],
            ['Voyageurs', $totalRegularUsers],
            ['Guides', $totalGuides],
            ['Admins', $totalAdmins]
        ];

        // Data for Programs per Location Bar Chart
        $programsPerLocation = Program::select('location', \DB::raw('count(*) as total'))
                                      ->groupBy('location')
                                      ->get();
        
        $locationData = [['Destination', 'Programmes']];
        if ($programsPerLocation->isEmpty()) {
            // Add a dummy row to prevent Google Charts error when empty
            $locationData[] = ['Aucun', 0];
        } else {
            foreach ($programsPerLocation as $loc) {
                $locationData[] = [$loc->location, $loc->total];
            }
        }

        // Recent users
        $recentUsers = User::orderBy('created_at', 'desc')->take(5)->get();

        return view('dashboard.superadmin.index', compact(
            'totalUsers', 'totalGuides', 'totalPrograms', 
            'roleData', 'locationData', 'recentUsers'
        ));
    }
}
