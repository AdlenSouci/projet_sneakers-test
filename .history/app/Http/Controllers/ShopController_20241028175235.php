namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShopController extends Controller
{
    public function index(): View
    {
        // Récupérer les articles avec leurs avis
        $articlesData = Article::with('avis')->get();

        // Calcul de la moyenne des notes pour chaque article
        $articlesData->each(function ($article) {
            $article->moyenneNote = $article->avis->count() > 0
                ? $article->avis->avg('note')
                : 0; // Moyenne à 0 si aucun avis
        });

        return view('shop', compact('articlesData'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $articlesData = Article::where('modele', 'like', $query . '%')->with('avis')->get();

        // Calcul de la moyenne des notes pour chaque article lors de la recherche
        $articlesData->each(function ($article) {
            $article->moyenneNote = $article->avis->count() > 0
                ? $article->avis->avg('note')
                : 0;
        });

        return view('shop', compact('articlesData'));
    }
}
