

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Famille;
use App\Models\Marque;
use App\Models\Couleur;

class ShopController extends Controller
{
    public function index(Request $request): View
    {
        // Initialiser la requête pour obtenir les articles
        $query = Article::query();

        // Appliquer les filtres en fonction des paramètres fournis
        if ($request->has('marque') && !empty($request->input('marque'))) {
            $query->where('nom_marque', 'like', '%' . $request->input('marque') . '%');
        }

        if ($request->has('famille') && !empty($request->input('famille'))) {
            $query->where('nom_famille', 'like', '%' . $request->input('famille') . '%');
        }

        if ($request->has('couleur') && !empty($request->input('couleur'))) {
            $query->where('nom_couleur', 'like', '%' . $request->input('couleur') . '%');
        }

        if ($request->has('prix') && !empty($request->input('prix'))) {
            $priceRange = explode('-', $request->input('prix'));
            if (count($priceRange) == 2) {
                $query->whereBetween('prix_public', [$priceRange[0], $priceRange[1]]);
            } elseif ($request->input('prix') == '500') {
                $query->where('prix_public', '>=', 500);
            }
        }

        // Récupérer les articles filtrés
        $articles = $query->with('avis')->get();

        // Récupérer les valeurs uniques pour les filtres
        $marques = Article::distinct()->pluck('nom_marque');
        $familles = Article::distinct()->pluck('nom_famille');
        $couleurs = Article::distinct()->pluck('nom_couleur');

        // Retourner la vue avec les données
        return view('shop', compact('articles', 'marques', 'familles', 'couleurs'));
    }

    public function search(Request $request): View
    {
        $query = $request->input('query');
        $articles = Article::where('modele', 'like', $query . '%')->with('avis')->get();

        return view('shop', compact('articles'));
    }
}
