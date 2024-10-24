<x-app-layout>
    <div class="container py-5">
        <section class="h-100 gradient-custom">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-md-8">
                        <div class="card mb-4">
                            <div class="card-header py-3">
                                <h5 class="mb-0">Panier - {{ count($cartItems) }} articles</h5>
                            </div>

                            <div class="card-body">
                                @if(empty($cartItems))
                                <div class="text-center" style="margin: 50px 0;">
                                    <h5 class="mb-0">Votre panier est vide</h5>
                                    <a href="/shop" class="btn btn-primary mt-3">
                                        <i class="fas fa-long-arrow-alt-left me-2"></i>Retour à la boutique
                                    </a>
                                </div>
                                @else
                                @foreach($cartItems as $item)
                                <!-- Single item -->
                                <div class="row mb-4">
                                    <div class="col-lg-3 col-md-12 mb-4 mb-lg-0">
                                        <!-- Image -->
                                        <div class="bg-image hover-overlay hover-zoom ripple rounded" data-mdb-ripple-color="light">
                                            <img src="{{ asset('/img/' . $item['image']) }}" class="w-100" alt="{{ $item['name'] }}">
                                            <a href="#!">
                                                <div class="mask" style="background-color: rgba(251, 251, 251, 0.2)"></div>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="col-lg-5 col-md-6 mb-4 mb-lg-0">
                                        <p><strong>{{ $item['name'] }}</strong></p>
                                        <p class="mb-0">Prix: € {{ number_format($item['price'], 2) }}</p>
                                        <button type="button" class="btn btn-danger btn-sm me-1 mb-2" onclick="viderArticlePanier(this)" data-article-id="{{ $item['id'] }}">
                                            <i class="fas fa-trash"></i> Supprimer
                                        </button>
                                    </div>

                                    <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                                        <!-- Quantity -->
                                        <div class="d-flex mb-4" style="max-width: 200px;">
                                            <button class="btn btn-primary px-3 me-2" onclick="this.parentNode.querySelector('input[type=number]').stepDown(); changerQuantiter(this.parentNode.querySelector('input[type=number]'));">
                                                <i class="fas fa-minus"></i>
                                            </button>

                                            <input id="form1" min="1" name="quantity" value="{{ $item['quantity'] }}" type="number" class="form-control" onchange="changerQuantiter(this)" data-item-price="{{ $item['price'] }}" data-item-id="{{ $item['id'] }}">

                                            <button class="btn btn-primary px-3 ms-2" onclick="this.parentNode.querySelector('input[type=number]').stepUp(); changerQuantiter(this.parentNode.querySelector('input[type=number]'));">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                        <p class="text-start text-md-center">
                                            <strong>€ {{ number_format($item['price'] * $item['quantity'], 2) }}</strong>
                                        </p>
                                    </div>
                                </div>
                                <hr class="my-4" />
                                @endforeach

                                <!-- Résumé -->
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="fw-bold mb-5 mt-2 pt-1">Résumé</h5>
                                                <hr class="my-4">
                                                <div class="d-flex justify-content-between">
                                                    <h6 class="text-uppercase">Total</h6>
                                                    <h6 id="totalPrice">€ {{ number_format($totalPrice, 2) }}</h6>
                                                </div>
                                                <hr class="my-4">

                                                @if(auth()->check())
                                                <form action="{{ route('passer-commande') }}" method="post" onsubmit="event.preventDefault(); passerCommande();">
                                                    @csrf
                                                    <input type="text" class="form-control" name="adresse_livraison" id="adresse_livraison" placeholder="Adresse de livraison" required>
                                                    <br>
                                                    <button type="submit" class="btn btn-dark btn-block btn-lg">Passer la commande</button>
                                                </form>
                                                @else
                                                <p>Connectez-vous pour passer une commande.</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div id="successMessage" class="alert alert-success" style="display: none;">
            La commande a été passée avec succès !
        </div>
    </div>

    <script>
        // Fonctions JavaScript restent les mêmes (viderPanier, changerQuantiter, passerCommande, etc.)
    </script>
</x-app-layout>
