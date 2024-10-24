<x-app-layout>
    <div class="container mt-4">
        <section class="h-100 gradient-custom">
            <div class="container py-5">
                <div class="row d-flex justify-content-center my-4">
                    <div class="col-md-8">
                        <div class="card mb-4">
                            <div class="card-header py-3">
                                <h5 class="mb-0">Panier - {{ count($cartItems) }} items</h5>
                            </div>
                            <div class="card-body">
                                @if (empty($cartItems))
                                <div class="text-center" style="margin: 50px 0;">
                                    Votre panier est vide
                                </div>
                                <a href="/shop" class="btn btn-primary">Retour à la boutique</a>
                                @else
                                @foreach ($cartItems as $item)
                                <div class="row mb-4">
                                    <div class="col-lg-3 col-md-12 mb-4 mb-lg-0">
                                        <div class="bg-image hover-overlay hover-zoom ripple rounded">
                                            <img src="{{ asset('/img/' . $item['image']) }}" class="w-100" alt="{{ $item['name'] }}" />
                                        </div>
                                    </div>

                                    <div class="col-lg-5 col-md-6 mb-4 mb-lg-0">
                                        <p><strong>{{ $item['name'] }}</strong></p>
                                        <p>Référence: {{ $item['reference'] }}</p>
                                        <button class="btn btn-primary btn-sm me-1 mb-2" onclick="viderArticlePanier(this)" data-article-id="{{ $item['id'] }}">
                                            <i class="fas fa-trash"></i> Retirer
                                        </button>
                                        <button class="btn btn-danger btn-sm mb-2">
                                            <i class="fas fa-heart"></i> Ajouter à la wishlist
                                        </button>
                                    </div>

                                    <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                                        <div class="d-flex mb-4" style="max-width: 300px">
                                            <button class="btn btn-primary px-3 me-2" onclick="changerQuantite(this, 'minus', {{ $item['id'] }})">
                                                <i class="fas fa-minus"></i>
                                            </button>

                                            <input type="number" value="{{ $item['quantity'] }}" class="form-control text-center" min="1" onchange="changerQuantiter(this)" data-item-price="{{ $item['price'] }}" data-item-id="{{ $item['id'] }}" />

                                            <button class="btn btn-primary px-3 ms-2" onclick="changerQuantite(this, 'plus', {{ $item['id'] }})">
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

                                <div class="d-flex justify-content-between">
                                    <h5 class="text-uppercase">Prix Total</h5>
                                    <h5 id="totalPrice">€ {{ number_format($totalPrice, 2) }}</h5>
                                </div>
                                <a href="/vider-panier" class="btn btn-danger mt-4">Vider le panier</a>

                                @if(auth()->check())
                                <form action="{{ route('passer-commande') }}" method="post" class="mt-4">
                                    @csrf
                                    <input type="text" class="form-control" name="adresse_livraison" id="adresse_livraison" placeholder="Adresse de livraison" required>
                                    <button type="submit" class="btn btn-dark btn-lg btn-block mt-3">Passer la commande</button>
                                </form>
                                @else
                                <p class="mt-4">Connectez-vous pour passer une commande.</p>
                                @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <script>
            function changerQuantite(button, action, itemId) {
                var input = button.closest('.d-flex').querySelector('input');
                var currentValue = parseInt(input.value);

                if (action === 'minus' && currentValue > 1) {
                    input.value = currentValue - 1;
                } else if (action === 'plus') {
                    input.value = currentValue + 1;
                }

                changerQuantiter(input);
            }

            function viderArticlePanier(button) {
                var articleId = button.getAttribute('data-article-id');
                // Votre logique pour retirer un article du panier
            }

            function changerQuantiter(input) {
                var newQuantity = parseInt(input.value);
                var pricePerItem = parseFloat(input.getAttribute("data-item-price"));
                var itemPriceElement = input.closest('.row').querySelector(".text-md-center strong");

                var newTotal = newQuantity * pricePerItem;
                itemPriceElement.textContent = "€ " + newTotal.toFixed(2);
                calculerPrixTotal();
            }

            function calculerPrixTotal() {
                var itemPrices = document.querySelectorAll('.text-md-center strong');
                var totalPrice = Array.from(itemPrices).reduce((sum, itemPrice) => sum + parseFloat(itemPrice.textContent.replace('€ ', '')), 0);
                document.querySelector('#totalPrice').textContent = "€ " + totalPrice.toFixed(2);
            }
        </script>

@vite(['resources/css/panier.css'])
</x-app-layout>