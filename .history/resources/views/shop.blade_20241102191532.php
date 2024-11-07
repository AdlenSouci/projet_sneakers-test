<section class="py-5 custom-section">
        <div class="container px-4 px-lg-5 mt-5">
            <!-- Formulaire de filtre -->
            <form id="filterForm" class="mb-4">
                <fieldset>
                    <legend>Filtrer par :</legend>

                    <!-- Filtrer par Marque -->
                    <div class="form-group">
                        <label for="marque">Marque</label>
                        <select name="marque" id="marque" class="form-control">
                            <option value="">-- Sélectionner une marque --</option>
                            @foreach($availableMarques as $marque)
                                <option value="{{ $marque }}">{{ $marque }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filtrer par Famille -->
                    <div class="form-group">
                        <label for="famille">Famille</label>
                        <select name="famille" id="famille" class="form-control">
                            <option value="">-- Sélectionner une famille --</option>
                            @foreach($availableFamilles as $famille)
                                <option value="{{ $famille }}">{{ $famille }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filtrer par Couleur -->
                    <div class="form-group">
                        <label for="couleur">Couleur</label>
                        <select name="couleur" id="couleur" class="form-control">
                            <option value="">-- Sélectionner une couleur --</option>
                            @foreach($availableCouleurs as $couleur)
                                <option value="{{ $couleur }}">{{ $couleur }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filtrer par Prix -->
                    <div class="form-group">
                        <label for="prix">Prix</label>
                        <select name="prix" id="prix" class="form-control">
                            <option value="">-- Sélectionner une gamme de prix --</option>
                            <option value="0-50">0 - 50 €</option>
                            <option value="50-100">50 - 100 €</option>
                            <option value="100-200">100 - 200 €</option>
                            <option value="200-500">200 - 500 €</option>
                            <option value="500">500+ €</option>
                        </select>
                    </div>
                </fieldset>
            </form>
            
            <!-- Affichage des articles -->
            <div id="articlesContainer" class="row gx-4 gx-lg-5 row-cols-1 row-cols-md-2 row-cols-xl-4 justify-content-center g-3">
                @foreach ($articlesData as $article)
                    <?php $stock_article = array_sum(array_column($article->tailles->toArray(), 'stock')); ?>
                    <div class="col mb-5 article-item" 
                         data-marque="{{ $article->marque }}" 
                         data-famille="{{ $article->famille }}" 
                         data-couleur="{{ $article->couleur }}" 
                         data-prix="{{ $article->prix_public }}">

                        <div class="card mb-4 product-wap rounded-0">
                            <div class="card rounded-0">
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
                                    <li class="pt-2"></li>
                                </ul>

                                <ul class="list-unstyled d-flex justify-content-center mb-1">
                                    <li>
                                        @php
                                            $moyenne = (float) $article->moyenneNote;
                                            $fullStars = floor($moyenne);
                                            $halfStar = ($moyenne - $fullStars) >= 0.5;
                                        @endphp

                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $fullStars)
                                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                            @elseif ($i == $fullStars + 1 && $halfStar)
                                                <span class="text-warning"><i class="fas fa-star-half-alt"></i></span>
                                            @else
                                                <span class="text-warning"><i class="far fa-star"></i></span>
                                            @endif
                                        @endfor
                                    </li>
                                </ul>

                                <p class="text-center mb-0">${{ $article['prix_public'] }}</p>

                                <div class="text-center custom-text-center mt-3">
                                    <br>
                                    {{ $stock_article }} exemplaires en stock
                                    {!! $stock_article > 0 ? '<span class="badge bg-success">En stock</span>' : '<span class="badge bg-danger">Rupture de stock</span>' !!}

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
                @endforeach
            </div>
        </div>
    </section>
    
    <!-- JavaScript pour le filtrage dynamique -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const filterForm = document.getElementById('filterForm');
            const articleItems = document.querySelectorAll('.article-item');

            filterForm.addEventListener('change', function () {
                const selectedMarque = document.getElementById('marque').value;
                const selectedFamille = document.getElementById('famille').value;
                const selectedCouleur = document.getElementById('couleur').value;
                const selectedPrix = document.getElementById('prix').value.split('-');

                articleItems.forEach(item => {
                    const itemMarque = item.getAttribute('data-marque');
                    const itemFamille = item.getAttribute('data-famille');
                    const itemCouleur = item.getAttribute('data-couleur');
                    const itemPrix = parseFloat(item.getAttribute('data-prix'));

                    // Vérifier chaque filtre et masquer si ça ne correspond pas
                    const marqueMatch = !selectedMarque || itemMarque === selectedMarque;
                    const familleMatch = !selectedFamille || itemFamille === selectedFamille;
                    const couleurMatch = !selectedCouleur || itemCouleur === selectedCouleur;
                    const prixMatch = !selectedPrix[0] || 
                        (itemPrix >= parseFloat(selectedPrix[0]) && 
                         (selectedPrix[1] ? itemPrix <= parseFloat(selectedPrix[1]) : true));

                    if (marqueMatch && familleMatch && couleurMatch && prixMatch) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
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

        
    </script>





    @vite(['resources/css/templatemo.css', 'resources/js/templatemo.js', 'resources/css/slick-theme.css', 'resources/css/slick-theme.min.css', 'resources/css/slick.min.css'])
</x-app-layout>