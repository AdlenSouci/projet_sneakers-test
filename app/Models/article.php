<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_famille',
        'id_marque',
        'modele',
        'description',
        'id_couleur',
        'prix_public',
        'prix_achat',
        'img'
    ];

    protected $appends = ['nom_marque','nom_famille','nom_couleur'];
    
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

    // Relation avec la table marques
    public function marque()
    {
        return $this->belongsTo(Marque::class, 'id_marque', 'id');
    }

    // Relation avec la table familles
    public function famille()
    {
        return $this->belongsTo(Famille::class, 'id_famille', 'id');
    }

    // Relation avec la table couleurs
    public function couleur()
    {
        return $this->belongsTo(Couleur::class, 'id_couleur', 'id');
    }

    // Getter pour récupérer seulement le nom de la famille
    public function getNomFamilleAttribute()
    {
        return $this->famille ? $this->famille->nom_famille : null;
    }

    // Getter pour récupérer seulement le nom de la marque
    public function getNomMarqueAttribute()
    {
        return $this->marque ? $this->marque->nom_marque : null;
    }   
    
    // Getter pour récupérer seulement le nom de la couleur
    public function getNomCouleurAttribute()
    {
        return $this->couleur ? $this->couleur->nom_couleur : null;
    }


}
