<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entretien extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidature_id', 'date', 'heure', 'lieu', 'statut'
    ];

    protected $casts = [
        'date' => 'date',
        'heure' => 'datetime:H:i',
    ];

    public function candidature()
    {
        return $this->belongsTo(Candidature::class);
    }

    public function candidat()
    {
        return $this->hasOneThrough(
            User::class,
            Candidature::class,
            'id', 
            'id', 
            'candidature_id', 
            'candidat_id'     
        );
       
    }
}