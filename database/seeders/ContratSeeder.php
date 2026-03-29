<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    $contrats = ['CDI', 'CDD', 'Stage', 'Freelance', 'Alternance'];
    foreach ($contrats as $nom) {
        \App\Models\Contrat::create(['nom' => $nom]);
    }
}
}
