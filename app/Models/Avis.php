<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avis extends Model
{
    use HasFactory;
    protected $fillable = ['note', 'contenu', 'article_id', 'user_id','reponse'];
    // Relation avec l'article
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    // Relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
