<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Candidature extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'candidat_id', 'offre_id', 'experience', 'adresse', 'formation',
        'commentaire_rd', 'statut', 'entretien_planifie', 'cv_path', 'comment_updated_at',
        'evaluation', 'evaluation_comment', 'evaluated_at'
    ];

    protected $casts = [
        'comment_updated_at' => 'datetime',
        'evaluated_at' => 'datetime',
    ];

    public function candidat()
    {
        return $this->belongsTo(User::class, 'candidat_id');
    }

    public function offre()
    {
        return $this->belongsTo(Offre::class);
    }

    public function entretien()
    {
        return $this->hasOne(Entretien::class);
    }

    
    public function scopeForDepartment($query, $directionId)
    {
        return $query->whereHas('offre', fn($q) => $q->where('direction_id', $directionId));
    }
}