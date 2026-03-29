<?php

namespace App\Console\Commands;

use App\Models\Offre;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateOffreSlugs extends Command
{
    protected $signature = 'offres:generate-slugs';
    protected $description = 'Génère les slugs pour toutes les offres';

    public function handle()
    {
        $offres = Offre::all();
        $count = 0;

        foreach ($offres as $offre) {
            $slug = Str::slug($offre->titre) . '-' . $offre->id;
            $offre->slug = $slug;
            $offre->save();
            $count++;
        }

        $this->info("Slugs générés pour {$count} offres.");
    }
}