<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Famille extends Model
{
    use HasFactory;
    protected $fillable = ['nom_famille', 'id_parent'];

    // Relation inverse avec articles
    public function articles()
    {
        return $this->hasMany(Article::class, 'id_famille', 'id');
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
