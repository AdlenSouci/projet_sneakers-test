<x-app-layout>
    <section class="py-5 custom-section">

        <form id="filterForm">
            <div class="form-group">
                <label for="marque">Marque</label>
                <select id="marque" name="marque" class="form-control">
                    <option value="">Toutes les marques</option>
                    @foreach($marques as $marque)
                    <option value="{{ $marque->nom_marque }}">{{ $marque->nom_marque }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="couleur">Couleur</label>
                <select id="couleur" name="couleur" class="form-control">
                    <option value="">Toutes les couleurs</option>
                    @foreach($couleurs as $couleur)
                    <option value="{{ $couleur->nom_couleur }}">{{ $couleur->nom_couleur }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Filtrer</button>
        </form>

        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-1 row-cols-md-2 row-cols-xl-4 justify-content-center g-3">
                <?php foreach ($articlesData as $article) : ?>
                    <?php $stock_article = array_sum(array_column($article->tailles->toArray(), 'stock')); ?>
                    <div class="col mb-5" data-marque="{{ $article->nom_marque }}" data-couleur="{{ $article->nom_couleur }}">
                        <!-- Contenu de l'article -->
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Section des avis des clients -->
    <section class="py-5 custom-section bg-light">
        <!-- Contenu des avis des clients -->
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#filterForm').on('submit', function(e) {
                e.preventDefault();

                const selectedMarque = $('#marque').val();
                const selectedCouleur = $('#couleur').val();

                $('.row-cols-xl-4 .col').each(function() {
                    const articleMarque = $(this).data('marque');
                    const articleCouleur = $(this).data('couleur');

                    const matchesMarque = selectedMarque === "" || articleMarque === selectedMarque;
                    const matchesCouleur = selectedCouleur === "" || articleCouleur === selectedCouleur;

                    if (matchesMarque && matchesCouleur) {
                        $(this).show(); // Affiche l'article
                    } else {
                        $(this).hide(); // Masque l'article
                    }
                });
            });
        });
    </script>

    @vite(['resources/css/templatemo.css', 'resources/js/templatemo.js', 'resources/css/slick-theme.css', 'resources/css/slick-theme.min.css', 'resources/css/slick.min.css'])
</x-app-layout>