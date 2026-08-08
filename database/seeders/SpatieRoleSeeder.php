<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpatieRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        $superAdmin = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'SuperAdmin']);
        $organisateur = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Organisateur']);
        $participant = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Participant']);
        $prestataire = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Prestataire']);

        // Migrate existing users without breaking them
        $users = \App\Models\User::all();
        foreach ($users as $user) {
            if ($user->role === 'superadmin' || $user->role === 'admin') {
                $user->assignRole($superAdmin);
            } elseif ($user->role === 'guide') {
                $user->assignRole($organisateur);
            } elseif ($user->role === 'user') {
                $user->assignRole($participant);
            }
        }
    }
}
