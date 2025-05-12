<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaillesArticle extends Model
{
    use HasFactory;
    protected $fillable = ["article_id", "taille", "stock"];
}
