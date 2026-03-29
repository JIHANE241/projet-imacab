<?php

namespace App\Http\Controllers;

use App\Models\Direction;
use App\Models\Offre;
use Illuminate\Http\Request;
 use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
   

public function index()
{
    $directions = Direction::withCount(['offres' => function ($query) {
        $query->where('statut', 'ouverte');
    }])->get();

   
    $extensions = ['jpg', 'jpeg', 'png', 'avif', 'webp'];
    foreach ($directions as $direction) {
        $imagePath = null;
        foreach ($extensions as $ext) {
            $file = public_path("images/directions/{$direction->id}.{$ext}");
            if (File::exists($file)) {
                $imagePath = asset("images/directions/{$direction->id}.{$ext}");
                break;
            }
        }
        $direction->image_url = $imagePath;
    }

    $dernieresOffres = Offre::with(['direction', 'typeContrat', 'ville'])
        ->where('statut', 'ouverte')
        ->latest()
        ->take(6)
        ->get();

    return view('home', compact('directions', 'dernieresOffres'));
}

   
    public function offresParDirection($id)
    {
        $offres = Offre::with(['direction', 'typeContrat', 'ville'])
            ->where('direction_id', $id)
            ->where('statut', 'ouverte')
            ->latest()
            ->get();

        return response()->json($offres);
    }
}