<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Langue extends Model
{
    use HasFactory;

    protected $fillable = ['nom'];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('niveau')->withTimestamps();
    }
}