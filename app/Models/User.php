<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Formation;
use App\Models\Experience;
use App\Models\Competence;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
    'name',
    'prenom',
    'email',
    'password',
    'telephone',
    'photo',
    'role',
    'direction_id',
    'email_verified_at'
];


    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

   
    public function direction()
    {
        return $this->belongsTo(Direction::class);
    }

    public function candidatures()
    {
        return $this->hasMany(Candidature::class, 'candidat_id');
    }

    public function entretiens()
    {
        return $this->hasManyThrough(Entretien::class, Candidature::class, 'candidat_id', 'candidature_id');
    }
    public function niveauEtude()
{
    return $this->belongsTo(NiveauEtude::class);
}

public function langues()
{
    return $this->belongsToMany(Langue::class)->withPivot('niveau')->withTimestamps();
}

public function formations()
{
    return $this->hasMany(Formation::class);
}

public function experiences()
{
    return $this->hasMany(Experience::class);
}

public function competences()
{
    return $this->belongsToMany(Competence::class);
}


}