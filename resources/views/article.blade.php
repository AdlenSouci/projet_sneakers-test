<x-app-layout>




    <section class="py-5">
        <div class="container px-4 px-lg-5 my-5">
            <?php $stock_article = array_sum(array_column($article->tailles->toArray(), 'stock')); ?>
            <div class="row gx-4 gx-lg-5 align-items-center">
                <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="{{ asset('img/' . $article['img']) }}" alt="..." /></div>
                <div class="col-md-6">

                    <h1 class="display-5 fw-bolder">
                        <?= $article['modele'] ?>
                    </h1>
                    <div class="fs-5 mb-5">
                        <h5 class="fw-bolder">
                            <?= $article['prix_public'] ?>
                        </h5>
                        <span>
                            <?= $article['prix'] ?>
                        </span>
                    </div>
                    <p class="lead">
                        <?= $article['description'] ?>
                    </p>

                    <br> <br>
                    <div class="d-flex align-items-center">
                        <?= $stock_article > 0 ? '<span class="badge bg-success me-3   btn-lg stock-badge ">En stock</span>' : '<span class="badge bg-danger me-3  btn-lg stock-badge">Rupture de stock</span>' ?>
                        <div class="d-flex align-items-center me-3">

                            <label for="pointure" class="me-3  rounded ">Pointure:</label>
                            <select id="pointure" name="pointure" class="custom-select-2 rounded">
                                <option value=""></option>
                                @foreach($article->tailles as $taille)
                                @if ($taille->stock > 0)
                                <option value="{{ $taille->taille }}">{{ $taille->taille }}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="d-flex align-items-center me-3">
                            <label for="quantite" class="me-1">Qté:</label>
                            <input type="number" name="quantite" class="form-control-2 rounded" value="1" min="1" max="20">
                        </div>
                        @if($stock_article > 0)
                        <button id="ajouter_au_panier" class="btn btn-outline-dark ajouter_au_panier rounded" data-article-id="{{ $article->id }}">Ajouter au panier</button>
                        @endif
                    </div>


                </div>
            </div>
        </div>
        <div class="container px-4 px-lg-5 mt-5">
            <h2 class="fw-bolder mb-4">Ajouter un avis</h2>

            @auth

            @if(auth()->user()->avis()->where('article_id', $article->id)->exists())
            <p>Vous avez déjà donné un avis pour cet article.</p>
            @elseif(auth()->user()->aDejaCommande($article->id))
            <form action="{{ route('avis.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="contenu" class="form-label">Votre avis</label>
                    <textarea id="contenu" name="contenu" class="form-control" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="note" class="form-label">Note</label>
                    <select id="note" name="note" class="form-select" required>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
                <input type="hidden" name="article_id" value="{{ $article->id }}">
                <button type="submit" class="btn btn-primary">Soumettre</button>
            </form>
            @else
            <p>Vous devez avoir commandé cet article pour laisser un avis.</p>
            @endif
            @endauth
        </div>

        <div class="container px-4 px-lg-5 mt-5">
            <h2 class="fw-bolder mb-4">Avis des clients</h2>
            <ul class="list-unstyled">
                @forelse ($article->avis as $avis)
                <li class="mb-2">
                    <div class="p-3 border border-light rounded" style="background-color: #f9f9f9;">
                        <strong>{{ $avis->user->name }} :</strong> {{ $avis->contenu }}
                        <span class="text-warning">{{ str_repeat('★', $avis->note) }}{{ str_repeat('☆', 5 - $avis->note) }}</span>
                    </div>
                </li>
                @empty
                <p>Aucun avis pour cet article.</p>
                @endforelse
            </ul>
        </div>
    </section>

    <section class="py-5 popular">
    <div class="container px-4 px-lg-5 mt-5">
        <h2 class="fw-bolder mb-4">Produits populaires</h2>
        <div class="row gx-4 gx-lg-5 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 g-4 justify-content-center">
            @foreach($articlesPopulaires as $populaire)
            <?php $stock_article = array_sum(array_column($populaire->tailles->toArray(), 'stock')); ?>
            <div class="col mb-5">
                <div class="card h-100">
                    <img class="card-img-top" src="{{ asset('img/' . $populaire->img) }}" alt="{{ $populaire->modele }}" />
                    <div class="card-body p-4">
                        <div class="text-center">
                            <h5 class="fw-bolder">{{ $populaire->modele }}</h5>
                            <div class="fs-5 mb-3">
                                <h6 class="text-muted mb-0">{{ $populaire->prix_public }}€</h6>
                                <span class="fw-bold">{{ $populaire->prix }}€</span>
                            </div>
                            <ul class="list-unstyled d-flex justify-content-center mt-2 mb-1">
                                <li>
                                    @php
                                    $moyenne = (float) $populaire->moyenne_note;
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
                        </div>
                    </div>
                    <div class="card-footer px-3 pt-0 border-top-0 bg-transparent">
                        <div class="d-flex flex-column align-items-center">
                            <div class="mb-2">
                                {!! $stock_article > 0
                                    ? '<span class="badge bg-success btn-lg stock-badge">En stock</span>'
                                    : '<span class="badge bg-danger btn-lg stock-badge">Rupture de stock</span>' !!}
                            </div>
                            @if($stock_article > 0)
                            <div class="d-flex flex-wrap justify-content-center gap-2 mb-2">
                                <div class="d-flex align-items-center">
                                    <label for="pointure" class="me-2">Pointure:</label>
                                    <select id="pointure" name="pointure" class="form-select form-select-sm rounded" style="width: 80px">
                                        <option value=""></option>
                                        @foreach($populaire->tailles as $taille)
                                            @if($taille->stock > 0)
                                                <option value="{{ $taille->taille }}">{{ $taille->taille }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="d-flex align-items-center">
                                    <label for="quantite" class="me-2">Qté:</label>
                                    <input type="number" name="quantite" class="form-control form-control-sm rounded" value="1" min="1" max="20" style="width: 80px">
                                </div>
                            </div>
                            <button class="btn btn-outline-dark btn-sm ajouter_au_panier rounded" data-article-id="{{ $populaire->id }}">
                                Ajouter au panier
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>





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
                            document.querySelector('#countArticle').textContent = response.nbitems;
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

    @vite(['resources/css/accueil.css'])
</x-app-layout>