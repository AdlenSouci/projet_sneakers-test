<x-app-layout>
    <section class="py-5 custom-section">

        <form id="filterForm" class="d-flex flex-wrap justify-content-center align-items-center">
            <div class="form-group mr-2">
                <label for="marque" class="mr-2">Marque</label>
                <select id="marque" name="marque" class="form-control" style="width: 180px;">
                    <option value="">Toutes les marques</option>
                    @foreach($marques as $marque)
                    <option value="{{ $marque->nom_marque }}">{{ $marque->nom_marque }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mr-2">
                <label for="couleur" class="mr-2">Couleur</label>
                <select id="couleur" name="couleur" class="form-control" style="width: 180px;">
                    <option value="">Toutes les couleurs</option>
                    @foreach($couleurs as $couleur)
                    <option value="{{ $couleur->nom_couleur }}">{{ $couleur->nom_couleur }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mr-2">
                <label for="prix" class="mr-2">Prix</label>
                <select id="prix" name="prix" class="form-control" style="width: 180px;">
                    <option value="">Prix</option>
                    <option value="asc">Prix croissant</option>
                    <option value="desc">Prix décroissant</option>
                </select>
            </div>

            <!-- Filtre par prix min et max -->
            <div class="form-group mr-2">
                <label for="prix_min" class="mr-2">Prix Min</label>
                <input type="number" id="prix_min" name="prix_min" class="form-control" style="width: 180px;" placeholder="Min" min="0">
            </div>

            <div class="form-group mr-2">
                <label for="prix_max" class="mr-2">Prix Max</label>
                <input type="number" id="prix_max" name="prix_max" class="form-control" style="width: 180px;" placeholder="Max" min="0">
            </div>

            <button type="submit" class="btn bg-dark text-white">Filtrer</button>
        </form>

        <style>
            #filterForm .form-group {
                display: flex;
                align-items: center;
            }

            #filterForm label {
                margin-right: 5px;
                /* Moins d'espacement entre l'étiquette et le champ */
            }

            #filterForm .form-control {
                max-width: 180px;
                /* Largeur ajustée pour éviter les champs trop larges */
            }

            #filterForm button {
                margin-left: 10px;
                /* Espacement entre le bouton et les champs */
            }

            #filterForm {
    display: flex;
    flex-wrap: wrap;
    gap: 10px; /* Espacement entre les champs */
}

#filterForm .form-group {
    flex: 1 1 100%; /* Prend toute la largeur sur petits écrans */
}

@media (min-width: 768px) {
    #filterForm .form-group {
        flex: 1 1 auto; /* Reprend la largeur initiale sur écrans plus larges */
    }
}

        </style>



        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-1 row-cols-md-2 row-cols-xl-4 justify-content-center g-3">
                <?php foreach ($articlesData as $article) : ?>
                    <?php $stock_article = array_sum(array_column($article->tailles->toArray(), 'stock')); ?>
                    <div class="col mb-5" data-marque="{{ $article->nom_marque }}" data-couleur="{{ $article->nom_couleur }}" data-prix="{{ $article->prix_public }}">
                        <div class="card mb-4 product-wap rounded-lg">
                            <div class="card rounded-sm">
                                <img class="card-img rounded-0 img-fluid" src="{{ asset('img/' . $article['img']) }}" alt="Product Image" />
                                <div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
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
    <section class="py-5 custom-section-avis">
        <div class="container px-4 px-lg-5 mt-5">
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
                const selectedPrix = $('#prix option:selected').val();
                const prixMin = parseFloat($('#prix_min').val()) || 0;
                const prixMax = parseFloat($('#prix_max').val()) || Infinity;

                let articles = $('.row-cols-xl-4 .col').toArray();

                // Filtrer les articles
                articles = articles.filter(function(article) {
                    const articleMarque = $(article).data('marque');
                    const articleCouleur = $(article).data('couleur');
                    const articlePrix = parseFloat($(article).data('prix'));

                    const matchesMarque = selectedMarque === "" || articleMarque === selectedMarque;
                    const matchesCouleur = selectedCouleur === "" || articleCouleur === selectedCouleur;
                    const matchesPrix = articlePrix >= prixMin && articlePrix <= prixMax;

                    return matchesMarque && matchesCouleur && matchesPrix;
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
                $('.row-cols-xl-4').empty().append(articles);
            });
        });
    </script>

    @vite(['resources/css/templatemo.css', 'resources/js/templatemo.js', 'resources/css/slick-theme.css', 'resources/css/slick-theme.min.css', 'resources/css/slick.min.css'])
</x-app-layout>