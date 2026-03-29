<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NiveauExperience extends Model
{
    use HasFactory;

    protected $fillable = ['nom'];

    public function offres()
    {
        return $this->hasMany(Offre::class);
    }
}