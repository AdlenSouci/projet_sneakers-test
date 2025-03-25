<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{
    protected $fillable = ['h1', 'h3', 'texte', 'imageURL', 'statut'];

}
