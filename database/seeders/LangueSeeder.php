<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LangueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    $langues = ['Arabe', 'Français', 'Anglais', 'Espagnol', 'Allemand', 'Italien'];
    foreach ($langues as $l) {
        \App\Models\Langue::create(['nom' => $l]);
    }
}
}
