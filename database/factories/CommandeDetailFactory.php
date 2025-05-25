<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Symfony\Component\Console\Output\ConsoleOutput;
use App\Models\Article;

class CommandeDetailFactory extends Factory
{
    public function definition(): array
    {
        $output = new ConsoleOutput();
        $output->writeln('Génération de la commande détail...');

        // Utiliser Faker pour générer des données aléatoires
        $faker = \Faker\Factory::create('fr_FR');

        // Récupérer un article aléatoire
        $article = Article::inRandomOrder()->first();
        //$article = Article::findOrFail(1);
        if (!$article) {
            throw new \Exception('Aucun article trouvé. Veuillez d\'abord créer des articles.');
        }

        $output->writeln('Génération de la commande détail...');

        $quantite = $faker->numberBetween(1, 5);

        // Prix TTC depuis l'article
        $prix_ttc = round($article->prix_public, 2);

        // Calcul du HT et TVA à partir du TTC
        $prix_ht = round($prix_ttc / 1.20, 2);
        $montant_tva = round($prix_ttc - $prix_ht, 2);

        return [
            'id_article' => $article->id,
            'taille' => $faker->numberBetween(36, 45),
            'quantite' => $quantite,
            'prix_ht' => $prix_ht,
            'prix_ttc' => $prix_ttc,
            'montant_tva' => $montant_tva,
        ];
    }
}
