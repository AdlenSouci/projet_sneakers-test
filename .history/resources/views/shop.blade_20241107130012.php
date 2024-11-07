<x-app-layout>
    <section class="py-5 custom-section">

        <!-- Section du filtre (encore plus petit à gauche) -->
        <div class="col-lg-2 col-md-3 mb-4">
            <form id="filterForm" class="p-3 rounded shadow-sm">
                <h4 class="mb-3 fs-6">Filtres</h4>
                <div class="form-group mb-3">
                    <label for="marque" class="form-label fs-7">Marque</label>
                    <select id="marque" name="marque" class="form-select form-select-sm">
                        <option value="">Toutes les marques</option>
                        @foreach($marques as $marque)
                        <option value="{{ $marque->nom_marque }}">{{ $marque->nom_marque }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="couleur" class="form-label fs-7">Couleur</label>
                    <select id="couleur" name="couleur" class="form-select form-select-sm">
                        <option value="">Toutes les couleurs</option>
                        @foreach($couleurs as $couleur)
                        <option value="{{ $couleur->nom_couleur }}">{{ $couleur->nom_couleur }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="prix" class="form-label fs-7">Prix</label>
                    <select id="prix" name="prix" class="form-select form-select-sm">
                        <option value="">Tous les prix</option>
                        <option value="asc">Prix croissant</option>
                        <option value="desc">Prix décroissant</option>
                    </select>
                </div>


            </form>
        </div>
        <div class="container px-4 px-lg-5 mt-5  ">
            <div class="row gx-4 gx-lg-5 row-cols-1 row-cols-md-2 row-cols-xl-4 justify-content-center g-3  ">
                <?php foreach ($articlesData as $article) : ?>
                    <?php $stock_article = array_sum(array_column($article->tailles->toArray(), 'stock')); ?>


                    <div class="col-md-4 rounded-1 " data-marque="{{ $article->nom_marque }}" data-couleur="{{ $article->nom_couleur }} data-prix="{{ $article->prix_public }}" ">
                        <!-- Contenu de l'article -->
                        <div class="card mb-4 product-wap rounded-2">
                            <div class="card rounded-3">
                                <img class="card-img rounded-0 img-fluid" src="{{ asset('img/' . $article['img']) }}" alt="Product Image" />
                                <div class="card-img-overlay rounded-3 product-overlay  justify-content-center">
                                    <ul class="list-unstyled">
                                        <li><a class="btn btn-success text-white mt-2" href="{{ route('article', $article['id']) }}"><i class="far fa-eye"></i></a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="card-body">
                                <a href="{{ route('article', $article['id']) }}" class="h3 text-decoration-none">{{ $article['modele'] }}</a>
                                <ul class="w-100 list-unstyled d-flex justify-content-between mb-0">
                                    <li class="pt-2">

                                        <!-- Couleurs de produit -->
                                    </li>
                                </ul>

                                <ul class="list-unstyled d-flex justify-content-center mb-1">
                                    <li>
                                        @php
                                        $moyenne = (float) $article->moyenneNote; // Convertir en float
                                        $fullStars = floor($moyenne); // Nombre d'étoiles pleines
                                        $halfStar = ($moyenne - $fullStars) >= 0.5; // Vérifie s'il y a une demi-étoile
                                        @endphp

                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <=$fullStars)
                                            <span class="text-warning"><i class="fas fa-star"></i></span> <!-- Étoile pleine -->
                                            @elseif ($i == $fullStars + 1 && $halfStar)
                                            <span class="text-warning"><i class="fas fa-star-half-alt"></i></span> <!-- Étoile demi -->
                                            @else
                                            <span class="text-warning"><i class="far fa-star"></i></span> <!-- Étoile vide -->
                                            @endif
                                            @endfor
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

    <!-- Section des avis des clients -->
    <section class="py-5 custom-section-avis mb-0">

        <div class="container ">
            <h5 class="text-center mb-4" style="color: #de7105;">Avis des clients</h5>
            <ul class="list-unstyled">
                @foreach ($articlesData as $article)
                @if ($article->avis && $article->avis->count() > 0)
                @foreach ($article->avis as $avis)
                <li class="mb-2">
                    <div class="p-3 border border-light rounded" style="background-color: #f9f9f9;">
                        <strong>{{ $avis->user->name }} :</strong> {{ $avis->contenu }}
                        <span class="text-warning">{{ str_repeat('★', $avis->note) }} {{ str_repeat('☆', 5 - $avis->note) }}</span>
                        <div>Article évalué : {{ $article->modele }}</div>
                    </div>
                </li>
                @endforeach
                @else
                @endif
                @endforeach
            </ul>
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

        $(document).ready(function() {
            $('.rating').raty({
                score: function() {
                    return $(this).data('score');
                },
                half: true,
                readOnly: true
            });
        });
        $(document).ready(function() {
            $('#filterForm').on('submit', function(e) {
                e.preventDefault();

                const selectedMarque = $('#marque').val();
                const selectedCouleur = $('#couleur').val();
                const selectedPrix = $('#prix').val();


                $('.row-cols-xl-4 .col').each(function() {
                    const articleMarque = $(this).data('marque');
                    const articleCouleur = $(this).data('couleur');
                    const articlePrix = $(this).data('prix');

                    const matchesMarque = selectedMarque === "" || articleMarque === selectedMarque;
                    const matchesCouleur = selectedCouleur === "" || articleCouleur === selectedCouleur;
                    const matchesPrix = selectedPrix === "" || articlePrix === selectedPrix;

                    if (selectedPrix === "asc") {
                        const articlePrixNum = parseFloat(articlePrix);
                        const selectedPrixNum = parseFloat(selectedPrix);
                        if (articlePrixNum < selectedPrixNum) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    } else if (selectedPrix === "desc") {
                        const articlePrixNum = parseFloat(articlePrix);
                        const selectedPrixNum = parseFloat(selectedPrix);
                        if (articlePrixNum > selectedPrixNum) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    }

                    if (matchesMarque && matchesCouleur && matchesPrix) {
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