<?php

use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Program;
use App\Models\Guide;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Define SQLite connection dynamically
config(['database.connections.sqlite_old' => [
    'driver' => 'sqlite',
    'url' => env('DATABASE_URL'),
    'database' => database_path('database.sqlite'),
    'prefix' => '',
    'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
]]);

echo "Migrating data from SQLite to PostgreSQL...\n";

// Disable foreign key checks for PostgreSQL
DB::statement('SET session_replication_role = replica;');

// 1. Users
$oldUsers = DB::connection('sqlite_old')->table('users')->get();
foreach ($oldUsers as $oldUser) {
    if (!DB::table('users')->where('id', $oldUser->id)->exists() && !DB::table('users')->where('email', $oldUser->email)->exists()) {
        DB::table('users')->insert([
            'id' => $oldUser->id,
            'name' => $oldUser->name,
            'first_name' => explode(' ', $oldUser->name)[0] ?? $oldUser->name,
            'last_name' => explode(' ', $oldUser->name)[1] ?? '',
            'email' => $oldUser->email,
            'password' => $oldUser->password,
            'role' => $oldUser->role,
            'created_at' => $oldUser->created_at,
            'updated_at' => $oldUser->updated_at,
            'email_verified_at' => $oldUser->email_verified_at,
        ]);
    }
}
echo "Users migrated.\n";

// 2. Guides
$oldGuides = DB::connection('sqlite_old')->table('guides')->get();
foreach ($oldGuides as $oldGuide) {
    if (!DB::table('guides')->where('id', $oldGuide->id)->exists()) {
        DB::table('guides')->insert((array) $oldGuide);
    }
}
echo "Guides migrated.\n";

// 3. Programs
$oldPrograms = DB::connection('sqlite_old')->table('programs')->get();
foreach ($oldPrograms as $oldProgram) {
    if (!DB::table('programs')->where('id', $oldProgram->id)->exists()) {
        DB::table('programs')->insert((array) $oldProgram);
    }
}
echo "Programs migrated.\n";

// Re-enable foreign key checks
DB::statement('SET session_replication_role = DEFAULT;');

// Update sequences in Postgres so we can insert new records later
$maxUserId = DB::table('users')->max('id');
if ($maxUserId) DB::statement("SELECT setval('users_id_seq', $maxUserId)");

$maxGuideId = DB::table('guides')->max('id');
if ($maxGuideId) DB::statement("SELECT setval('guides_id_seq', $maxGuideId)");

$maxProgId = DB::table('programs')->max('id');
if ($maxProgId) DB::statement("SELECT setval('programs_id_seq', $maxProgId)");

echo "Migration Complete!\n";
