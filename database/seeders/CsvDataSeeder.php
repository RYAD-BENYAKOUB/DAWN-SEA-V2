<?php

namespace Database\Seeders;

use App\Models\Guide;
use App\Models\Program;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CsvDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Clear existing programs, visits, and favorites to avoid duplicates
        \Illuminate\Support\Facades\DB::statement('PRAGMA foreign_keys = OFF;');
        Program::truncate();
        Visit::truncate();
        \Illuminate\Support\Facades\DB::table('favorites')->truncate();
        \Illuminate\Support\Facades\DB::statement('PRAGMA foreign_keys = ON;');

        // 2. Ensure our Guides exist
        // Guide 1: Yacine Touati (Sud)
        $userYacine = User::firstOrCreate(
            ['email' => 'yacine@example.com'],
            [
                'name' => 'Yacine Touati',
                'password' => Hash::make('password'),
                'role' => 'guide',
            ]
        );
        $guideYacine = Guide::firstOrCreate(
            ['user_id' => $userYacine->id],
            [
                'bio' => 'Guide saharien certifié, spécialiste du Tassili et des oasis du Grand Sud.',
                'phone' => '+213 555 123 456',
                'location' => 'Adrar',
                'speciality' => 'Sahara & Désert',
                'rating' => 4.90,
                'is_verified' => true,
            ]
        );

        // Guide 2: Amina Khelif (Alger & Kabylie)
        $userAmina = User::firstOrCreate(
            ['email' => 'amina@example.com'],
            [
                'name' => 'Amina Khelif',
                'password' => Hash::make('password'),
                'role' => 'guide',
            ]
        );
        $guideAmina = Guide::firstOrCreate(
            ['user_id' => $userAmina->id],
            [
                'bio' => 'Guide culturelle, historienne de formation, passionnée par le patrimoine ottoman.',
                'phone' => '+213 555 789 012',
                'location' => 'Alger',
                'speciality' => 'Culture & Histoire',
                'rating' => 4.75,
                'is_verified' => true,
            ]
        );

        // Guide 3: Mourad Orani (Oranie & Ouest)
        $userMourad = User::firstOrCreate(
            ['email' => 'mourad@example.com'],
            [
                'name' => 'Mourad Orani',
                'password' => Hash::make('password'),
                'role' => 'guide',
            ]
        );
        $guideMourad = Guide::firstOrCreate(
            ['user_id' => $userMourad->id],
            [
                'bio' => 'Guide touristique de l\'Ouest algérien, spécialiste des forts espagnols et des plages côtières.',
                'phone' => '+213 555 456 789',
                'location' => 'Oran',
                'speciality' => 'Randonnée & Littoral',
                'rating' => 4.80,
                'is_verified' => true,
            ]
        );

        // Guide 4: Yasmine Fellahi (Discover Ed & Events)
        $userYasmine = User::firstOrCreate(
            ['email' => 'yasmine@example.com'],
            [
                'name' => 'Yasmine Fellahi',
                'password' => Hash::make('password'),
                'role' => 'guide',
            ]
        );
        $guideYasmine = Guide::firstOrCreate(
            ['user_id' => $userYasmine->id],
            [
                'bio' => 'Fondatrice de la startup Discover Ed & Events, spécialiste en tourisme éducatif et thérapeutique. Passionnée par l\'apprentissage expérientiel et le bien-être par le voyage. Découvrez mon portfolio : https://beacons.ai/discover_ed_events',
                'phone' => '+213 555 987 654',
                'location' => 'Alger',
                'speciality' => 'Tourisme Éducatif & Thérapeutique',
                'rating' => 4.95,
                'avatar' => 'storage/guides/discover_ed_event.png',
                'is_verified' => true,
            ]
        );

        // Copy Yasmine's avatar image to storage
        $guideStorageDir = public_path('storage/guides');
        if (!is_dir($guideStorageDir)) {
            mkdir($guideStorageDir, 0777, true);
        }
        if (file_exists(base_path('DATA/discover_ed_event.png'))) {
            copy(base_path('DATA/discover_ed_event.png'), $guideStorageDir . '/discover_ed_event.png');
        }

        // Ensure we have some regular travelers for favorites
        $traveler1 = User::firstOrCreate(
            ['email' => 'sara@example.com'],
            ['name' => 'Sara Mansouri', 'password' => Hash::make('password'), 'role' => 'user']
        );
        $traveler2 = User::firstOrCreate(
            ['email' => 'karim@example.com'],
            ['name' => 'Karim Belkacem', 'password' => Hash::make('password'), 'role' => 'user']
        );

        // 3. Read and Parse Recommendations CSV
        $recomPath = base_path('DATA/recommandation.csv');
        $recommendations = [];
        if (($handle = fopen($recomPath, 'r')) !== false) {
            $header = fgetcsv($handle); // skip header
            while (($row = fgetcsv($handle)) !== false) {
                if (count($row) >= 5) {
                    $recommendations[$row[1]] = [
                        'title' => $row[2],
                        'description' => $row[3],
                        'rating' => (float)$row[4]
                    ];
                }
            }
            fclose($handle);
        }

        // 4. Parse Lieu CSV with the custom chunk offset parser
        $lieuPath = base_path('DATA/lieu.csv');
        $content = file_get_contents($lieuPath);
        if ($content === false) {
            $this->command->error("Impossible de lire lieu.csv");
            return;
        }

        // Ensure local storage folder exists
        $storageDir = public_path('storage/programs');
        if (!is_dir($storageDir)) {
            mkdir($storageDir, 0777, true);
        }

        preg_match_all('/(?:^|\r?\n)"(\d+)","/', $content, $matches, PREG_OFFSET_CAPTURE);
        $rowsCount = count($matches[0]);
        $this->command->info("Traitement de $rowsCount lieux de lieu.csv...");

        for ($i = 0; $i < $rowsCount; $i++) {
            $id = $matches[1][$i][0];
            $startOffset = $matches[0][$i][1];
            $endOffset = ($i < $rowsCount - 1) ? $matches[0][$i+1][1] : strlen($content);
            $chunk = substr($content, $startOffset, $endOffset - $startOffset);
            
            $chunk = ltrim($chunk, "\r\n");
            
            $pos1 = strpos($chunk, '","');
            $pos2 = strpos($chunk, '","', $pos1 + 3);
            $pos3 = strpos($chunk, '","', $pos2 + 3);
            $pos4 = strpos($chunk, '","', $pos3 + 3);
            
            if ($pos1 === false || $pos2 === false || $pos3 === false || $pos4 === false) {
                continue;
            }
            
            $name = substr($chunk, $pos1 + 3, $pos2 - $pos1 - 3);
            $descLieu = substr($chunk, $pos2 + 3, $pos3 - $pos2 - 3);
            $address = substr($chunk, $pos3 + 3, $pos4 - $pos3 - 3);
            
            $imageBinary = substr($chunk, $pos4 + 3);
            $imageBinary = rtrim($imageBinary, "\r\n");
            if (substr($imageBinary, -1) === '"') {
                $imageBinary = substr($imageBinary, 0, -1);
            }

            // Save image physically in storage
            $imagePath = null;
            if (strlen($imageBinary) > 0) {
                $filename = "program_" . $id . ".jpg";
                file_put_contents($storageDir . '/' . $filename, $imageBinary);
                $imagePath = "storage/programs/" . $filename;
            }

            // Match recommendation
            $recom = $recommendations[$id] ?? [
                'title' => 'Découverte ' . $name,
                'description' => $descLieu,
                'rating' => 4.5
            ];

            // Decide Guide based on address and specific educational/therapeutic IDs
            if (in_array((int)$id, [2, 6, 11, 14])) {
                $guideId = $guideYasmine->id;
            } elseif (Str::contains(strtolower($address), ['oran', 'tlemcen'])) {
                $guideId = $guideMourad->id;
            } elseif (Str::contains(strtolower($address), ['adrar', 'béchar', 'béni abbès', 'timimoun', 'taghit'])) {
                $guideId = $guideYacine->id;
            } else {
                $guideId = $guideAmina->id;
            }

            // Create program
            $program = Program::create([
                'guide_id' => $guideId,
                'title' => $name . ' : ' . $recom['title'],
                'description' => $descLieu . "\n\n" . $recom['description'],
                'location' => $address,
                'duration' => $id % 2 === 0 ? '1 jour' : '2 jours',
                'price' => rand(15, 35) * 1000,
                'max_participants' => rand(8, 15),
                'difficulty' => $id % 3 === 0 ? 'facile' : ($id % 3 === 1 ? 'modéré' : 'difficile'),
                'image' => $imagePath,
                'is_active' => true,
            ]);

            // Add some mock stats (visits and favorites) for visual charts
            $visitCount = rand(5, 25);
            for ($k = 0; $k < $visitCount; $k++) {
                Visit::create([
                    'program_id' => $program->id,
                    'user_id' => rand(0, 1) ? $traveler1->id : null,
                    'ip_address' => '192.168.1.' . rand(1, 254),
                    'visited_at' => now()->subDays(rand(0, 365)),
                ]);
            }

            if (rand(0, 1)) {
                $traveler1->favoritePrograms()->attach($program->id);
            }
            if (rand(0, 2) === 1) {
                $traveler2->favoritePrograms()->attach($program->id);
            }
        }

        $this->command->info("Base de données remplie avec succès depuis les fichiers CSV !");
    }
}
