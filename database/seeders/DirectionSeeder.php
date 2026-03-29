<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DirectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    $directions = [
        'Direction financière', 'Direction achat', 'Direction commerciale', 'Direction générale',
        'Direction industrielle', 'Direction maintenance', 'Direction production qualité',
        'Direction RH et organisation', 'Direction SI', 'Direction usinage'
    ];
    foreach ($directions as $nom) {
        \App\Models\Direction::create(['nom' => $nom]);
    }
}
}
