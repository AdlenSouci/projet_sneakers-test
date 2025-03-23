<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Marque extends Model
{

    use HasFactory;

    protected $fillable = [
        'nom_marque',
    ];
    
    // Relation inverse avec articles
    public function articles()
    {
        return $this->hasMany(Article::class, 'id_marque', 'id');
    }      
    
    // Utiliser cette méthode pour chaque colonne de type date que tu souhaites manipuler
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->toDateTimeString(); // Convertir en instance Carbon
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->toDateTimeString(); // Convertir en instance Carbon
    }
}
