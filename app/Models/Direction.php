<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direction extends Model
{
    use HasFactory;

    protected $fillable = ['nom'];

    public function offres()
    {
        return $this->hasMany(Offre::class);
    }

    public function candidatures()
    {
        return $this->hasManyThrough(Candidature::class, Offre::class);
    }

    public function responsable()
{
    return $this->hasOne(User::class)->where('role', 'responsable')->whereNotNull('email_verified_at');
}
}