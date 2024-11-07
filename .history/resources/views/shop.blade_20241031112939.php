<x-app-layout>
    <section class="py-5 custom-section">
        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#panierModal">
                Panier (<span id="nbitems">{{ $nbItems ?? 0 }}</span>)
            </button>
        </div>

        <form id="filter-form">
            <div class="row">
                <div class="col-md-3">
                    <label for="marque">Marque</label>
                    <select id="marque" name="marque" class="form-control">
                        @foreach ($marques as $marque)
                        <option value="{{ $marque->id }}">{{ $marque->nom_marque }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="prix_min">Prix min</label>
                    <input type="number" id="prix_min" name="prix_min" class="form-control" min="0" max="1000">
                </div>
                <div class="col-md-3">
                    <label for="prix_max">Prix max</label>
                    <input type="number" id="prix_max" name="prix_max" class="form-control" min="0" max="1000">
                </div>
                <div class="col-md-3">
                    <label for="famille">Famille</label>
                    <select id="famille" name="famille" class="form-control">
                        @foreach ($familles as $famille)
                        <option value="{{ $famille->id }}">{{ $famille->nom_famille }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="couleur">Couleur</label>
                    <select id="couleur" name="couleur" class="form-control">
                        @foreach ($couleurs as $couleur)
                        <option value="{{ $couleur->nom_couleur }}">{{ $couleur->nom_couleur }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Filtrer</button>
        </form>

        <div class="container px-4 px-lg-5 mt-5">
            <div id="article-list" class="row gx-4 gx-lg-5 row-cols-1 row-cols-md-2 row-cols-xl-4 justify-content-center g-3">
                @foreach ($articlesData as $article)
                @php $stock_article = array_sum(array_column($article->tailles->toArray(), 'stock')); @endphp
                <div class="col mb-5">
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
                            <ul class="list-unstyled d-flex justify-content-center mb-1">
                                <li>
                                    @php
                                    $moyenne = (float) $article->moyenneNote;
                                    $fullStars = floor($moyenne);
                                    $halfStar = ($moyenne - $fullStars) >= 0.5;
                                    @endphp

                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <=$fullStars)
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
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-5 custom-section bg-light">
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
            $('#filter-form').submit(function(event) {
                event.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    type: 'GET',
                    url: '{{ route("shop.filter") }}',
                    data: formData,
                    success: function(response) {
                        $('#article-list').html('');
                        $.each(response.articles, function(index, article) {
                            var stock_article = article.taille.reduce((sum, taille) => sum + taille.stock, 0);
                            $('#article-list').append(`
                            <div class="col mb-5">
                                <div class="card mb-4 product-wap rounded-0">
                                    <div class="card rounded-0">
                                        <img class="card-img rounded-0 img-fluid" src="{{ asset('img/') }}/${article.img}" alt="Product Image" />
                                        <div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                            <ul class="list-unstyled">
                                                <li><a class="btn btn-success text-white mt-2" href="{{ route('article', '') }}/${article.id}"><i class="far fa-eye"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <a href="{{ route('article', '') }}/${article.id}" class="h3 text-decoration-none">${article.modele}</a>
                                        <ul class="list-unstyled d-flex justify-content-center mb-1">
                                            <li>
                                                ${Array.from({length: 5}).map((_, i) => i < Math.floor(article.moyenneNote) ? '<span class="text-warning"><i class="fas fa-star"></i></span>' : i === Math.floor(article.moyenneNote) + 1 && (article.moyenneNote % 1 >= 0.5) ? '<span class="text-warning"><i class="fas fa-star-half-alt"></i></span>' : '<span class="text-warning"><i class="far fa-star"></i></span>').join('')}
                                            </li>
                                        </ul>
                                        <p class="text-center mb-0">$${article.prix_public}</p>
                                        <div class="text-center custom-text-center mt-3">
                                            ${stock_article} exemplaires en stock
                                            <span class="badge ${stock_article > 0 ? 'bg-success' : 'bg-danger'}">${stock_article > 0 ? 'En stock' : 'Rupture de stock'}</span>
                                            <div class="d-flex align-items-center justify-content-center mt-3">
                                                <div class="me-3">
                                                    Pointure:
                                                    <select id="pointure" name="pointure" class="custom-label custom-select rounded" style="width: 80px">
                                                        <option value=""></option>
                                                        ${article.taille.map(taille => taille.stock > 0 ? `<option value="${taille.taille}">${taille.taille}</option>` : '').join('')}
                                                    </select>
                                                </div>
                                                <div>
                                                    Qté:
                                                    <input type="number" name="quantite" class="custom-label rounded" style="width: 80px" value="1" min="1" max="20">
                                                </div>
                                            </div>
                                            <br>
                                            ${stock_article > 0 ? `<button class="btn btn-outline-dark mt-auto ajouter_au_panier custom-button" data-article-id="${article.id}" style="margin-left: 10px">Ajouter au panier</button>` : ''}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            `);
                        });
                    }
                });
            });
        });
    </script>
    @vite(['resources/css/templatemo.css', 'resources/js/templatemo.js', 'resources/css/slick-theme.css', 'resources/css/slick-theme.min.css', 'resources/css/slick.min.css'])

</x-app-layout>