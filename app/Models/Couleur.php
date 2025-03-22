<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Couleur extends Model
{
    use HasFactory;

    protected $fillable = ['nom_couleur'];

    // Relation inverse avec articles
    public function articles()
    {
        return $this->hasMany(Article::class, 'id_couleur', 'id');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->toDateTimeString(); // Convertir en instance Carbon
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->toDateTimeString(); // Convertir en instance Carbon
    }

}
