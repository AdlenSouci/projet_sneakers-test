<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class expedition_detail extends Model
{
    use HasFactory;
    protected $fillable = [
        'montant_ht', 'id_num_commande', 'remise', ' adresse', 'prix_ht', 'prix_ttc', 'id_article', 'quantite_livraison', 'id_num_bon_livraison', 'id_num_ligne_bon_livraison'
    ];

    public function entete()
    {
        return $this->belongsTo(expedition_entete::class, 'id_commande', 'id');
    }

    public function article()
    {
        return $this->belongsTo(Article::class, 'id_article', 'id');
    }
}
