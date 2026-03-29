<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NiveauEtudeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    $niveaux = [
        'Qualification avant bac',
        'Bac',
        'Bac+1',
        'Bac+2',
        'Bac+3',
        'Bac+4',
        'Bac+5 et plus',
    ];
    foreach ($niveaux as $n) {
        \App\Models\NiveauEtude::create(['nom' => $n]);
    }
}

}
