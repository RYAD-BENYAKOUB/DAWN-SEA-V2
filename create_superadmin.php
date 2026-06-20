<?php
use App\Models\User;
use Illuminate\Support\Facades\Hash;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = User::firstOrCreate(
    ['email' => 'ryadbenyakoub@gmail.com'],
    [
        'name' => 'Mohammed Ryad Benyakoub',
        'first_name' => 'Mohammed Ryad',
        'last_name' => 'Benyakoub',
        'password' => Hash::make('password123'),
        'role' => 'superadmin'
    ]
);

echo "Superadmin created: " . $user->email . "\n";
