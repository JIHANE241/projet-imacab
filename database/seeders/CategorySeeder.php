<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    $categories = ['Développement', 'Finance', 'Maintenance', 'Production', 'Ressources humaines', 'Commercial', 'Qualité', 'Logistique', 'Informatique', 'Administration'];
    foreach ($categories as $nom) {
        \App\Models\Category::create(['nom' => $nom]);
    }
}
}
