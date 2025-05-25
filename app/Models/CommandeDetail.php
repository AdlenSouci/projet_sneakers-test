<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CommandeDetail extends Model
{
    protected $table = 'commandes_details';

    protected $fillable = [
    
        'id_commande',
        'id_article',
        'taille',
        'quantite',
        'prix_ht',
        'prix_ttc',
        'montant_tva',
        // 'remise',
    
    ];

    // Relation avec la table des entêtes de commande
    public function entete()
    {
        return $this->belongsTo(CommandeEntete::class, 'id_commande', 'id');
    }

    // Relation avec le modèle Article si vous stockez les informations de l'article commandé
    public function article()
    {
        return $this->belongsTo(Article::class, 'id_article', 'id');
    }
}
