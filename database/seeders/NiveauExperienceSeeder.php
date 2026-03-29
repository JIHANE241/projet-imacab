<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NiveauExperienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    $niveaux = ['Junior', 'Confirmé', 'Senior', 'Expert'];
    foreach ($niveaux as $nom) {
        \App\Models\NiveauExperience::create(['nom' => $nom]);
    }
}
}
