<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    public function index()
    {
        // Get all unique locations that have active programs
        $locations = Program::where('is_active', true)
                            ->select('location')
                            ->distinct()
                            ->pluck('location');

        $destinations = [];

        // Descriptions array
        $descriptions = [
            'Alger' => 'La capitale blanche, vibrante et chargée d\'histoire, célèbre pour sa Casbah classée à l\'UNESCO et sa baie magnifique.',
            'Oran' => 'La radieuse, berceau du Raï, offrant un mélange unique d\'architecture hispano-mauresque et de plages somptueuses.',
            'Tlemcen' => 'La perle du Maghreb, riche de son héritage andalou, avec ses palais zianides et ses paysages verdoyants.',
            'Béjaïa' => 'La capitale des Hammadites, un joyau méditerranéen où les montagnes boisées plongent dans la mer, célèbre pour le Cap Carbon.',
            'Adrar' => 'Une plongée dans le Sahara authentique, avec ses palmeraies verdoyantes, son système de foggaras et sa culture ancestrale.',
            'Béchar' => 'Porte d\'entrée vers l\'immensité saharienne, réputée pour l\'hospitalité de ses habitants et sa proximité avec Taghit la sublime.',
            'Timimoun' => 'L\'oasis rouge, un chef-d\'œuvre architectural au milieu des dunes de sable, où le temps semble s\'être arrêté.',
            'Taghit' => 'L\'enchanteresse du désert, adossée à d\'immenses dunes dorées, offrant des paysages à couper le souffle et des gravures rupestres millénaires.'
        ];

        foreach ($locations as $location) {
            // Find a representative program for this location to get an image
            $program = Program::where('location', $location)->where('is_active', true)->whereNotNull('image')->first();
            
            // Clean the location name for matching
            $cleanLocation = trim($location);
            
            $desc = $descriptions[$cleanLocation] ?? 'Découvrez les merveilles de ' . $cleanLocation . ', une destination inoubliable avec Dawn & Sea.';
            
            $image = $program ? $program->image : null;

            $destinations[] = [
                'name' => $cleanLocation,
                'description' => $desc,
                'image' => $image,
                'count' => Program::where('location', $location)->where('is_active', true)->count()
            ];
        }

        // Sort alphabetically by name
        usort($destinations, function($a, $b) {
            return strcmp($a['name'], $b['name']);
        });

        return view('destinations.index', compact('destinations'));
    }
}
