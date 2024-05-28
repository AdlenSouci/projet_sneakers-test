<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_marque', ' marque', 'nom_famille', 'modele', 'description', 'prix_achat', 'img', 'couleur', 'prix_public', 'id_famille'
        
    ];
  
    public function tailles(): HasMany
    {
        return $this->hasMany(TaillesArticle::class);
    }   
}
