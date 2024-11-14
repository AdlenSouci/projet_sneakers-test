<x-app-layout>
    <section class="py-5 custom-section">

        <form id="filterForm" class="d-flex flex-wrap justify-content-center align-items-center">
            <div class="form-group mr-2">
                <label for="marque" class="mr-2 rounded-lg">Marque</label>
                <select id="marque" name="marque" class="form-control" style="width: 180px;">
                    <option value="">Toutes les marques</option>
                    @foreach($marques as $marque)
                    <option value="{{ $marque->nom_marque }}">{{ $marque->nom_marque }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mr-2">
                <label for="couleur" class="mr-2 rounded-lg">Couleur</label>
                <select id="couleur" name="couleur" class="form-control rounded-pill" style="width: 180px;">
                    <option value="">Toutes les couleurs</option>
                    @foreach($couleurs as $couleur)
                    <option value="{{ $couleur->nom_couleur }}">{{ $couleur->nom_couleur }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mr-2 rounded-pill">
                <label for="prix" class="mr-2 rounded">Prix</label>
                <select id="prix" name="prix" class="form-control rounded" style="width: 180px;">
                    <option value="">Prix</option>
                    <option value="asc">Prix croissant</option>
                    <option value="desc">Prix décroissant</option>
                </select>
            </div>

            <!-- Filtre par prix min et max -->
            <div class="form-group mr-2 rounded">
                <label for="prix_min" class="mr-2 rounded-lg">Prix Min</label>
                <input type="number" id="prix_min" name="prix_min" class="form-control rounded-pill" style="width: 180px;" placeholder="Min" min="0">
            </div>

            <div class="form-group mr-2">
                <label for="prix_max" class="mr-2">Prix Max</label>
                <input type="number" id="prix_max" name="prix_max" class="form-control rounded-pill" style="width: 180px;" placeholder="Max" min="0">
            </div>

            <button type="submit" class="btn bg-dark text-white">Filtrer</button>
        </form>


       
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