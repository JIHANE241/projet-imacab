<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Entretien;
use Carbon\Carbon;

class UpdateEntretienStatus extends Command
{
    protected $signature = 'entretien:update-status';
    protected $description = 'Mettre à jour les entretiens passés';

    public function handle()
    {
        
        $updated = Entretien::where('date', '<', Carbon::today())
            ->where('statut', 'planifie')      
            ->update(['statut' => 'passe']);  

        $this->info("{$updated} entretiens ont été marqués comme passés.");
        return 0;
    }
}