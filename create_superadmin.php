<?php
use App\Models\User;
use Illuminate\Support\Facades\Hash;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$password = env('SUPERADMIN_INITIAL_PASSWORD');

if (empty($password) || strlen($password) < 12) {
    echo "Erreur : La variable d'environnement SUPERADMIN_INITIAL_PASSWORD n'est pas définie ou fait moins de 12 caractères.\n";
    exit(1);
}

$user = User::firstOrCreate(
    ['email' => 'ryadbenyakoub@gmail.com'],
    [
        'name' => 'Mohammed Ryad Benyakoub',
        'first_name' => 'Mohammed Ryad',
        'last_name' => 'Benyakoub',
        'password' => Hash::make($password),
        'role' => 'superadmin'
    ]
);

echo "Superadmin created: " . $user->email . "\n";
