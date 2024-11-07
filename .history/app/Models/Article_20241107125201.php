<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_marque',
        'nom_marque',
        'id_marque',
        'nom_famille',
        'modele',
        'description',
        'prix_achat',
        'img',
        'nom_couleur',
        'prix_public',
        'id_famille',
        'id_article',

    ];

    public function tailles(): HasMany
    {
        return $this->hasMany(TaillesArticle::class);
    }

  

    public function getMoyenneNoteAttribute()
    {
        // Vérifiez si l'article a des avis
        if ($this->avis->count() > 0) {
            // Calcule la moyenne et arrondit à une décimale pour plus de précision
            return round($this->avis->avg('note'), 1);
        }
        return 0;
    }

    // Relation avec les avis
    public function avis()
    {
        return $this->hasMany(Avis::class);
    }

    public function marque()
    {
        return $this->belongsTo(Marque::class);
    }

    public function famille()
    {
        return $this->belongsTo(Famille::class);
    }



    // public function couleur()
    // {
    //     return $this->belongsTo(Couleur::class);
    // }


}
