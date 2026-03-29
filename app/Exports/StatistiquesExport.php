<?php

namespace App\Exports;

use App\Models\Direction;
use Maatwebsite\Excel\Concerns\FromCollection;

class StatistiquesExport implements FromCollection
{
    public function collection()
    {
        return Direction::withCount('offres','candidatures')->get();
    }
}