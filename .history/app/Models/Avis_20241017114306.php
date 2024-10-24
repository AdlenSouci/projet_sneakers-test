<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avis extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'article_id', 'contenu', 'note'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class); // Assurez-vous que vous avez un modèle Article
    }

    public function aDejaCommande($articleId)
    {
        return $this->commandes()->whereHas('details', function ($query) use ($articleId) {
            $query->where('id_article', $articleId);
        })->exists();
    }
    public function commandes()
    {
        return $this->hasMany(CommandeEntete::class, 'id_user');
    }
}
