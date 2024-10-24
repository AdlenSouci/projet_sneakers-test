<x-app-layout>
    <section class="py-5 custom-section">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-1 row-cols-md-2 row-cols-xl-4 justify-content-center g-3">
                <?php foreach ($articlesData as $article) : ?>
                    <?php $stock_article = array_sum(array_column($article->tailles->toArray(), 'stock')); ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="single-product">
                            <img class="img-fluid" src="{{ asset('img/' . $article['img']) }}" alt="Product Image" />
                            <div class="product-details">
                                <h6><?= $article['modele'] ?></h6>
                                <div class="price">
                                    <h6><?= $article['prix_public'] ?> €</h6>
                                    <!-- Example of a discounted price -->
                                    <!-- <h6 class="l-through">$210.00</h6> -->
                                </div>
                                <div class="prd-bottom">
                                    <a href="{{ route('article', $article['id']) }}" class="social-info">
                                        <span class="lnr lnr-move"></span>
                                        <p class="hover-text">Voir plus</p>
                                    </a>
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
                                    <?= $stock_article ?> exemplaires en stock
                                    <?= $stock_article > 0 ? '<span class="badge bg-success">En stock</span>' : '<span class="badge bg-danger">Rupture de stock</span>' ?>
                                    <br><br>
                                    @if($stock_article > 0)
                                    <a href="#" class="social-info ajouter_au_panier" data-article-id="{{ $article['id'] }}">
                                        <span class="ti-bag"></span>
                                        <p class="hover-text">Ajouter au panier</p>
                                    </a>
                                    @endif
                                    <a href="#" class="social-info">
                                        <span class="lnr lnr-heart"></span>
                                        <p class="hover-text">Wishlist</p>
                                    </a>
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

@vite (['resources/css/.css', 'resources/js/shop.js'])
</x-app-layout>
