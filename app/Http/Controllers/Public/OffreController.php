<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Offre;
use Illuminate\Http\Request;

class OffreController extends Controller
{
    public function show($slug)
    {
        $offre = Offre::where('slug', $slug)
            ->with(['direction', 'typeContrat', 'ville', 'category', 'niveauExperience', 'niveauEtude'])
            ->firstOrFail();

        return view('public.offres.show', compact('offre'));
    }
}