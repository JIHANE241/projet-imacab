<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'debut_mois',
        'debut_annee',
        'fin_mois',
        'fin_annee',
        'encours',
        'titre',
        'etablissement',
        'description',
    ];

   
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}