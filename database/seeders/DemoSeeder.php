<?php

namespace Database\Seeders;

use App\Models\Guide;
use App\Models\Program;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    /**
     * Seed the database with demo data.
     */
    public function run(): void
    {
        // Create regular users
        $user1 = User::create([
            'name' => 'Sara Mansouri',
            'email' => 'sara@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        $user2 = User::create([
            'name' => 'Karim Belkacem',
            'email' => 'karim@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // Create guide users
        $guideUser1 = User::create([
            'name' => 'Yacine Touati',
            'email' => 'yacine@example.com',
            'password' => Hash::make('password'),
            'role' => 'guide',
        ]);

        $guideUser2 = User::create([
            'name' => 'Amina Khelif',
            'email' => 'amina@example.com',
            'password' => Hash::make('password'),
            'role' => 'guide',
        ]);

        // Create guide profiles
        $guide1 = Guide::create([
            'user_id' => $guideUser1->id,
            'bio' => 'Guide saharien passionné avec 10 ans d\'expérience. Spécialiste du Grand Erg Oriental et du Tassili n\'Ajjer.',
            'phone' => '+213 555 123 456',
            'location' => 'Djanet',
            'speciality' => 'Sahara & Désert',
            'rating' => 4.90,
            'is_verified' => true,
        ]);

        $guide2 = Guide::create([
            'user_id' => $guideUser2->id,
            'bio' => 'Guide culturelle spécialisée dans le patrimoine ottoman et les sites historiques d\'Alger et Constantine.',
            'phone' => '+213 555 789 012',
            'location' => 'Alger',
            'speciality' => 'Culture & Patrimoine',
            'rating' => 4.75,
            'is_verified' => true,
        ]);

        // Create programs
        $programs = [
            [
                'guide_id' => $guide1->id,
                'title' => 'Sahara Doré',
                'slug' => 'sahara-dore',
                'description' => 'Circuit inoubliable dans les dunes du Grand Erg Oriental. Nuits sous les étoiles, randonnée chamelière, couchers de soleil spectaculaires sur les dunes dorées. Une immersion totale dans le désert algérien.',
                'location' => 'Djanet',
                'duration' => '5 jours',
                'price' => 45000,
                'max_participants' => 12,
                'difficulty' => 'modéré',
                'is_active' => true,
            ],
            [
                'guide_id' => $guide1->id,
                'title' => 'Tassili Mystique',
                'slug' => 'tassili-mystique',
                'description' => 'Exploration du plateau du Tassili n\'Ajjer, site UNESCO. Découverte des peintures rupestres millénaires, formations rocheuses spectaculaires et oasis cachées.',
                'location' => 'Tassili n\'Ajjer',
                'duration' => '7 jours',
                'price' => 65000,
                'max_participants' => 8,
                'difficulty' => 'difficile',
                'is_active' => true,
            ],
            [
                'guide_id' => $guide1->id,
                'title' => 'Oasis Mystique',
                'slug' => 'oasis-mystique',
                'description' => 'Parcours entre les oasis du M\'Zab. Architecture mozabite unique, jardins luxuriants et traditions ancestrales. Visite de Ghardaïa, Beni Isguen et El Atteuf.',
                'location' => 'Ghardaïa',
                'duration' => '3 jours',
                'price' => 30000,
                'max_participants' => 15,
                'difficulty' => 'facile',
                'is_active' => true,
            ],
            [
                'guide_id' => $guide2->id,
                'title' => 'Héritage Ottoman',
                'slug' => 'heritage-ottoman',
                'description' => 'Voyage culturel à travers les palais ottomans, mosquées séculaires et médinas d\'Alger et Constantine. Une plongée dans l\'histoire architecturale de l\'Algérie.',
                'location' => 'Alger — Constantine',
                'duration' => '4 jours',
                'price' => 35000,
                'max_participants' => 20,
                'difficulty' => 'facile',
                'is_active' => true,
            ],
            [
                'guide_id' => $guide2->id,
                'title' => 'Côte Turquoise',
                'slug' => 'cote-turquoise',
                'description' => 'Découverte des plages secrètes de la côte algéroise et jijélienne. Criques paradisiaques, grottes marines et villages de pêcheurs authentiques.',
                'location' => 'Jijel',
                'duration' => '3 jours',
                'price' => 25000,
                'max_participants' => 15,
                'difficulty' => 'facile',
                'is_active' => true,
            ],
            [
                'guide_id' => $guide2->id,
                'title' => 'Ruines Romaines',
                'slug' => 'ruines-romaines',
                'description' => 'Circuit archéologique de Tipaza à Djemila. Sites classés UNESCO, théâtres antiques et mosaïques exceptionnelles. L\'Algérie romaine comme vous ne l\'avez jamais vue.',
                'location' => 'Tipaza — Djemila',
                'duration' => '4 jours',
                'price' => 38000,
                'max_participants' => 18,
                'difficulty' => 'modéré',
                'is_active' => false,
            ],
        ];

        foreach ($programs as $programData) {
            Program::create($programData);
        }

        // Add favorites
        $user1->favoritePrograms()->attach([1, 2, 4]);
        $user2->favoritePrograms()->attach([1, 3, 5]);

        // Add some demo visits
        $programIds = Program::pluck('id')->toArray();
        for ($i = 0; $i < 50; $i++) {
            Visit::create([
                'program_id' => $programIds[array_rand($programIds)],
                'user_id' => rand(0, 1) ? $user1->id : null,
                'ip_address' => '192.168.1.' . rand(1, 255),
                'visited_at' => now()->subDays(rand(0, 365)),
            ]);
        }
    }
}
