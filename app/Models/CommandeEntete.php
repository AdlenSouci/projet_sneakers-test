<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CommandeDetail;
use App\Models\User;

class CommandeEntete extends Model
{
    //model commande entete 
    protected $table = 'commandes_entetes';

    protected $fillable = [
        'date',
        'id_user',
        'id_num_commande',
        'total_ht',
        'total_ttc',
        'total_tva',
        'total_remise',
        'telephone',
        'ville',
        'code_postal',
        'adresse_livraison'
    ];
    

    // Relation avec la table des détails de commande
    public function Details()
    {
        return $this->hasMany(CommandeDetail::class, 'id_commande', 'id');
    }

    // Relation avec le modèle User si vous stockez les informations du client
    public function client()
    {
        return $this->belongsTo(User::class, 'id_clients');
    }
}
