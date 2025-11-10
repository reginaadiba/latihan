<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    function index()
    {
        $articles = Article::with('ratings', 'categories')->paginate(5);
        // return $articles;
        return view('articles', ['articles' => $articles]);
    }
}
