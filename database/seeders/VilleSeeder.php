<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VilleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    $villes = ['Casablanca', 'Rabat', 'Tanger', 'Fès', 'Marrakech', 'Agadir', 'Meknès', 'Oujda', 'Kénitra', 'Tétouan'];
    foreach ($villes as $nom) {
        \App\Models\Ville::create(['nom' => $nom]);
    }
}
}
