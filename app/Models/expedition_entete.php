<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class expedition_entete extends Model
{
    use HasFactory;
    protected $fillable = [
        'date', 'id_clients'
    ];

    public function details()
    {
        return $this->hasMany(expedition_detail::class, 'id_commande', 'id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'id_clients');
    }
}
