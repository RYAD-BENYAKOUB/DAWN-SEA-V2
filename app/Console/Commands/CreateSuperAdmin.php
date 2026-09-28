<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateSuperAdmin extends Command
{
    protected $signature = 'app:create-superadmin
                            {--email= : The superadmin email address}
                            {--password= : The superadmin password (min 12 chars)}';

    protected $description = 'Create or update the superadmin user (CLI only)';

    public function handle(): int
    {
        $email = $this->option('email') ?: env('SUPERADMIN_EMAIL');
        $password = $this->option('password') ?: env('SUPERADMIN_INITIAL_PASSWORD');

        if (empty($email) || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('A valid email is required. Use --email= or set SUPERADMIN_EMAIL.');
            return self::FAILURE;
        }

        if (empty($password) || strlen($password) < 12) {
            $this->error('Password must be at least 12 characters. Use --password= or set SUPERADMIN_INITIAL_PASSWORD.');
            return self::FAILURE;
        }

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => 'Super Admin',
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'password' => Hash::make($password),
                'role' => 'superadmin',
            ]
        );

        // Ensure the user has the SuperAdmin Spatie role
        if (! $user->hasRole('SuperAdmin')) {
            $user->assignRole('SuperAdmin');
        }

        $this->info("SuperAdmin ready: {$user->email}");
        return self::SUCCESS;
    }
}
