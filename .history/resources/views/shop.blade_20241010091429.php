<x-app-layout>
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <?php foreach ($articlesData as $article) : ?>
                    <?php $stock_article = array_sum(array_column($article->tailles->toArray(), 'stock')); ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="single-product">
                            <!-- Image du produit -->
                            <img class="img-fluid" src="{{ asset('img/' . $article['img']) }}" alt="Product Image">

                            <!-- Détails du produit -->
                            <div class="product-details">
                                <!-- Modèle de l'article -->
                                <h6><?= $article['modele'] ?></h6>

                                <!-- Prix -->
                                <div class="price">
                                    <h6><?= $article['prix_public'] ?> €</h6>
                                    <!-- Si tu veux afficher un prix barré pour une promotion, tu peux activer la ligne suivante -->
                                    <!-- <h6 class="l-through">€210.00</h6> -->
                                </div>

                                <!-- Actions (Ajouter au panier, Wishlist, Comparer, Voir plus) -->
                                <div class="prd-bottom">
                                    <!-- Voir plus -->
                                    <a href="{{ route('article', $article['id']) }}" class="social-info">
                                        <span class="lnr lnr-move"></span>
                                        <p class="hover-text">Voir plus</p>
                                    </a>

                                    <!-- Stock et Sélection de la taille et quantité -->
                                    <div class="d-flex align-items-center justify-content-center mt-3">
                                        <div class="me-3">
                                            Pointure:
                                            <select id="pointure" name="pointure" class="custom-select rounded" style="width: 80px">
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
                                            <input type="number" name="quantite" class="rounded" style="width: 80px" value="1" min="1" max="20">
                                        </div>
                                    </div>

                                    <br>
                                    <!-- Stock et Disponibilité -->
                                    <p><?= $stock_article ?> exemplaires en stock</p>
                                    <?= $stock_article > 0 ? '<span class="badge bg-success">En stock</span>' : '<span class="badge bg-danger">Rupture de stock</span>' ?>

                                    <br><br>

                                    <!-- Ajouter au panier -->
                                    @if($stock_article > 0)
                                    <a href="#" class="social-info ajouter_au_panier" data-article-id="{{ $article['id'] }}">
                                        <span class="ti-bag"></span>
                                        <p class="hover-text">Ajouter au panier</p>
                                    </a>
                                    @endif

                                    <!-- Wishlist -->
                                    <a href="#" class="social-info">
                                        <span class="lnr lnr-heart"></span>
                                        <p class="hover-text">Wishlist</p>
                                    </a>

                                    <!-- Comparer -->
                                    <a href="#" class="social-info">
                                        <span class="lnr lnr-sync"></span>
                                        <p class="hover-text">Comparer</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('ajouter_au_panier')) {
                var articleId = event.target.getAttribute('data-article-id');
                var pointure = event.target.parentElement.querySelector('#pointure').value;
                if (pointure) {
                    $.ajax({
                        url: '{{ route("ajouter_au_panier") }}',
                        type: 'POST',
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'article_id': articleId,
                            pointure,
                            'quantite': event.target.parentElement.querySelector('[name="quantite"]').value
                        },
                        success: function(response) {
                            alert(response.message);
                            document.querySelector('#nbitems').textContent = "panier(" + response.nbitems + ")";
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                } else {
                    alert('Veuillez choisir une pointure');
                }
            }
        });
    </script>

    @vite(['resources/css/themify-icons.css, resources/css/main.css])
</x-app-layout>
