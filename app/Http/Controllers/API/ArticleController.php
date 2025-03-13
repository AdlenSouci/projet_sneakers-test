<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    //
    public function index()
    {
        return response()->json(\App\Models\Article::all());
    }

    public function show()
    {

    }

    public function destroy()
    {

    }
}
