<?php


namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offre extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'titre', 'description', 'direction_id', 'category_id',
        'type_contrat_id', 'niveau_experience_id', 'ville_id',
        'statut', 'date_publication', 'date_limite',
        'salaire_min', 'salaire_max', 'missions', 'profil', 'niveau_etude_id',
        'validated_at', 'validated_by', 
    ];

    protected $casts = [
        'date_publication' => 'date',
        'date_limite' => 'date',
        'validated_at' => 'datetime',
    ];

    public function direction()
    {
        return $this->belongsTo(Direction::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function typeContrat()
    {
        return $this->belongsTo(TypeContrat::class);
    }

    public function niveauExperience()
    {
        return $this->belongsTo(NiveauExperience::class);
    }

    public function ville()
    {
        return $this->belongsTo(Ville::class);
    }

    public function candidatures()
    {
        return $this->hasMany(Candidature::class);
    }

    public function niveauEtude()
    {
        return $this->belongsTo(NiveauEtude::class);
    }

    
    public function validatedBy()
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

protected static function boot()
{
    parent::boot();

    static::creating(function ($offre) {
        $offre->slug = static::generateUniqueSlug($offre->titre);
    });

    static::updating(function ($offre) {
        if ($offre->isDirty('titre')) {
            $offre->slug = static::generateUniqueSlug($offre->titre);
        }
    });
}

protected static function generateUniqueSlug($titre)
{
    $slug = Str::slug($titre);
    $count = static::where('slug', 'LIKE', "{$slug}%")->count();
    return $count ? "{$slug}-{$count}" : $slug;
}
}