<x-app-layout>
    <section class="py-5 custom-section">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-1 row-cols-md-2 row-cols-xl-4 justify-content-center g-3">
                <?php foreach ($articlesData as $article) : ?>
                    <?php $stock_article = array_sum(array_column($article->tailles->toArray(), 'stock')); ?>
                    <div class="col mb-5">
                        <div class="card mb-4 product-wap rounded-0">
                            <div class="card rounded-0">

                                <img class="card-img rounded-0 img-fluid" src="{{ asset('img/' . $article['img']) }}" alt="Product Image" />


                                <div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                    <ul class="list-unstyled">

                                        <li><a class="btn btn-success text-white mt-2" href="{{ route('article', $article['id']) }}"><i class="far fa-eye"></i></a></li>
                                        <li>
                                            @if($stock_article > 0)
                                            <button class="btn btn-success text-white mt-2 ajouter_au_panier" data-article-id="{{ $article['id'] }}">
                                                <i class="fas fa-cart-plus"></i>
                                            </button>

                                            @else
                                            <a class="btn btn-danger text-white mt-2 disabled"><i class="fas fa-cart-plus"></i></a>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="card-body">

                                <a href="{{ route('article', $article['id']) }}" class="h3 text-decoration-none">{{ $article['modele'] }}</a>


                                <ul class="w-100 list-unstyled d-flex justify-content-between mb-0">

                                    <li class="pt-2">
                                        <span class="product-color-dot color-dot-red float-left rounded-circle ml-1"></span>
                                        <span class="product-color-dot color-dot-blue float-left rounded-circle ml-1"></span>
                                        <span class="product-color-dot color-dot-black float-left rounded-circle ml-1"></span>
                                        <span class="product-color-dot color-dot-light float-left rounded-circle ml-1"></span>
                                        <span class="product-color-dot color-dot-green float-left rounded-circle ml-1"></span>
                                    </li>
                                </ul>
                                <ul class="list-unstyled d-flex justify-content-center mb-1">
                                    <li>
                                        <i class="text-warning fa fa-star"></i>
                                        <i class="text-warning fa fa-star"></i>
                                        <i class="text-warning fa fa-star"></i>
                                        <i class="text-muted fa fa-star"></i>
                                        <i class="text-muted fa fa-star"></i>
                                    </li>
                                </ul>


                                <p class="text-center mb-0">${{ $article['prix_public'] }}</p>


                                <div class="text-center custom-text-center mt-3">
                                    <br>
                                    <?= $stock_article ?> exemplaires en stock
                                    <?= $stock_article > 0 ? '<span class="badge bg-success">En stock</span>' : '<span class="badge bg-danger">Rupture de stock</span>' ?>

                                    <div class="d-flex align-items-center justify-content-center mt-3">
                                        <div class="me-3">
                                            Pointure:
                                            <select id="pointure" name="pointure" class="custom-label custom-select rounded" style="width: 80px">
                                                <option value=""></option>
                                                @foreach($article->tailles as $taille)
                                                @if ($taille->stock > 0)
                                                <option value="{{ $taille->taille }}">{{ $taille->taille }}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            Qté:
                                            <input type="number" name="quantite" class="custom-label rounded" style="width: 80px" value="1" min="1" max="20">
                                        </div>
                                    </div>
                                    <br>
                                    @if($stock_article > 0)
                                    <button class="btn btn-outline-dark mt-auto ajouter_au_panier custom-button" data-article-id="{{ $article['id'] }}" style="margin-left: 10px">Ajouter au panier</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        document.addEventListener('click', function(event) {
            // Rechercher l'élément avec la classe 'ajouter_au_panier' ou un parent proche qui en a
            let target = event.target.closest('.ajouter_au_panier');

            if (target) {
                // Récupérer les données de l'article
                var articleId = target.getAttribute('data-article-id');
                var cardBody = target.closest('.card-body');
                var pointure = cardBody.querySelector('#pointure').value;
                var quantite = cardBody.querySelector('[name="quantite"]').value;

                // Vérifier si une pointure est sélectionnée
                if (pointure) {
                    // Envoyer la requête AJAX pour ajouter l'article au panier
                    $.ajax({
                        url: '{{ route("ajouter_au_panier") }}',
                        type: 'POST',
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'article_id': articleId,
                            'pointure': pointure,
                            'quantite': quantite
                        },
                        success: function(response) {
                            // Afficher un message de succès
                            alert(response.message);

                            // Mettre à jour le nombre d'articles dans le panier
                            document.querySelector('#nbitems').textContent = "panier(" + response.nbitems + ")";
                        },
                        error: function(error) {
                            // Gérer les erreurs
                            console.log(error);
                        }
                    });
                } else {
                    // Si aucune pointure n'est sélectionnée, afficher un message d'alerte
                    alert('Veuillez choisir une pointure');
                }
            }
        });
    </script>
    @vite(['resources/css/templatemo.css', 'resources/js/templatemo.js', 'resources/css/slick-theme.css', 'resources/css/slick-theme.min.css', 'resources/css/slick.min.css', ''resources/css/fontawesome.min.css','])
</x-app-layout>