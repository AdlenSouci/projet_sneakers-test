<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\TaillesArticle;




class ArticleController extends Controller
{
    public function show($id)
    {
 
        $article = Article::find($id);

       
        $tailles = $article->tailles->pluck('taille');

       
        return view('article', ['article' => $article, 'tailles' => $tailles]);
    }

    


}

    



