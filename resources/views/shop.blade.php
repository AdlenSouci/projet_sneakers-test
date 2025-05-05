<x-app-layout>

    <section class="py-5 custom-section">

        <form id="filterForm" class="d-flex flex-wrap justify-content-center align-items-center">
            <div class="form-group mr-2">
                <label for="marque" class="mr-2 rounded-lg">Marque</label>
                <select id="marque" name="marque" class="form-control" style="width: 180px;"
                    onchange="filterArticles()">
                    <option value="">Toutes les marques</option>
                    @foreach($marques as $marque)
                    <option value="{{ $marque->nom_marque }}">{{ $marque->nom_marque }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mr-2">
                <label for="couleur" class="mr-2 rounded-lg">Couleur</label>
                <select id="couleur" name="couleur" class="form-control rounded-pill" style="width: 180px;"
                    onchange="filterArticles()">
                    <option value="">Toutes les couleurs</option>
                    @foreach($couleurs as $couleur)
                    <option value="{{ $couleur->nom_couleur }}">{{ $couleur->nom_couleur }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mr-2 rounded-pill">
                <label for="prix" class="mr-2 rounded">Prix</label>
                <select id="prix" name="prix" class="form-control rounded" style="width: 180px;"
                    onchange="filterArticles()">
                    <option value="">Prix</option>
                    <option value="asc">Prix croissant</option>
                    <option value="desc">Prix décroissant</option>
                </select>
            </div>

            <div class="form-group mr-2 rounded">
                <label for="prix_min" class="mr-2 rounded-lg">Prix Min</label>
                <input type="number" id="prix_min" name="prix_min" class="form-control rounded-pill"
                    style="width: 180px;" placeholder="Min" min="0" oninput="filterArticles()">
            </div>

            <div class="form-group mr-2">
                <label for="prix_max" class="mr-2">Prix Max</label>
                <input type="number" id="prix_max" name="prix_max" class="form-control rounded-pill"
                    style="width: 180px;" placeholder="Max" min="0" oninput="filterArticles()">
            </div>

            <!-- <button type="submit" class="btn bg-dark text-white">Filtrer</button> -->
        </form>




        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-1 row-cols-md-2 row-cols-xl-4 justify-content-center g-3">
                <?php foreach ($articlesData as $article): ?>
                    <?php $stock_article = array_sum(array_column($article->tailles->toArray(), 'stock')); ?>
                    <div class="col mb-5" data-marque="{{ $article->nom_marque }}"
                        data-couleur="{{ $article->nom_couleur }}" data-prix="{{ $article->prix_public }}">

                        <div class="card mb-4 product-wap rounded-lg">
                            <div class="card rounded-sm">
                                <div class="image-container">
                                    <img class="img-fluid" src="{{ asset('img/' . $article['img']) }}"
                                        alt="Product Image" />

                                </div>
                                <div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                    <ul class="list-unstyled">
                                        <li><a class="btn btn-success text-white mt-2"
                                                href="{{ route('article', $article['id']) }}"><i class="far fa-eye"></i></a>
                                        </li>
                                    </ul>
                                </div>

                            </div>

                            <div class="card-body">
                                <div class="d-flex justify-content-center align-items-center">
                                    <a href="{{ route('article', $article['id']) }}" class="h3">{{ $article['nom_marque'] }} {{ $article['modele'] }}</a>

                                </div>

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
                                            <span class="text-warning"><i class="fas fa-star-half-alt"></i></span>
                                            <!-- Étoile demi -->
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

                                    @if($article->tailles->where('stock', '>', 0)->count() > 0)
                                    <div class="d-flex align-items-center justify-content-center mt-3">
                                        <div class="me-3">
                                            <i class="fas fa-shoe-prints me-1"></i>
                                            <select id="pointure" name="pointure" class="custom-label custom-select rounded"
                                                style="width: 80px">
                                                <option value=""></option>
                                                @foreach($article->tailles as $taille)
                                                @if ($taille->stock > 0 )
                                                <option value="{{ $taille->taille }}">{{ $taille->taille }}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            Qté:
                                            <input type="number" name="quantite" class="custom-label rounded"
                                                style="width: 80px" value="1" min="1" max="20">
                                        </div>
                                    </div>
                                    <br>
                                    <button class="btn btn-outline-dark mt-auto ajouter_au_panier custom-button"
                                        data-article-id="{{ $article['id'] }}" style="margin-left: 10px">Ajouter au panier</button>
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
    <section class="py-5 custom-section-avis">
        <div class="container px-4 px-lg-5 mt-5">
            <h5 class="text-center mb-4" style="color: #de7105;">Avis des clients</h5>
            <ul class="list-unstyled">
                @foreach ($articlesData as $article)
                @if ($article->avis && $article->avis->count() > 0)
                @foreach ($article->avis as $avis)
                <li class="mb-2">
                    <div class="p-3 border border-light rounded" style="background-color: #f9f9f9;">
                        <strong>{{ $avis->user?->name ?? 'Utilisateur inconnu' }} :</strong>
                        {{ $avis->contenu }}
                        <span class="text-warning">
                            {{ str_repeat('★', $avis->note) }}{{ str_repeat('☆', 5 - $avis->note) }}
                        </span>
                        <div>Article évalué : {{ $article->modele }}</div>

                        @if (!empty($avis->reponse))
                        <div class="mt-2 p-2 border-left" style="color: #007bff; font-style: italic;">
                            <strong>Réponse de l'administrateur :</strong> {{ $avis->reponse }}
                        </div>
                        @endif
                    </div>
                </li>
                @endforeach
                @endif
                @endforeach
            </ul>
        </div>
    </section>

    <!-- mettre un espace-->
    <br>
    <br>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('ajouter_au_panier')) {
                var articleId = event.target.getAttribute('data-article-id');
                var pointure = event.target.parentElement.querySelector('#pointure').value;
                var quantite = event.target.parentElement.querySelector('[name="quantite"]').value;

                if (pointure) {
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
                            alert(response.message);
                            // Mettre à jour le compteur d'articles
                            document.querySelector('#countArticle').textContent = response.nbitems; // Met à jour le compteur
                        },
                        error: function(error) {
                            console.log(error);
                            alert('Une erreur est survenue lors de l\'ajout de l\'article au panier.');
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

        function filterArticles() {
            const selectedMarque = $('#marque').val();
            const selectedCouleur = $('#couleur').val();
            const selectedPrix = $('#prix').val();
            const prixMin = parseFloat($('#prix_min').val()) || 0;
            const prixMax = parseFloat($('#prix_max').val()) || Infinity;

            let articles = $('.row-cols-xl-4 .col');

            // Filtrer les articles
            articles.each(function() {
                const articleMarque = $(this).data('marque');
                const articleCouleur = $(this).data('couleur');
                const articlePrix = parseFloat($(this).data('prix'));

                const matchesMarque = selectedMarque === "" || articleMarque === selectedMarque;
                const matchesCouleur = selectedCouleur === "" || articleCouleur === selectedCouleur;
                const matchesPrix = articlePrix >= prixMin && articlePrix <= prixMax;

                if (matchesMarque && matchesCouleur && matchesPrix) {
                    $(this).removeClass('hidden');
                } else {
                    $(this).addClass('hidden');
                }
            });

            // Trier les articles
            if (selectedPrix === "asc") {
                articles.sort(function(a, b) {
                    return $(a).data('prix') - $(b).data('prix');
                });
            } else if (selectedPrix === "desc") {
                articles.sort(function(a, b) {
                    return $(b).data('prix') - $(a).data('prix');
                });
            }

            // Afficher les articles triés et filtrés
            articles.each(function() {
                $(this).appendTo('.row-cols-xl-4');
            });
        }
    </script>

    @vite(['resources/css/templatemo.css', 'resources/js/templatemo.js', 'resources/css/slick-theme.css', 'resources/css/slick-theme.min.css', 'resources/css/slick.min.css'])
</x-app-layout>