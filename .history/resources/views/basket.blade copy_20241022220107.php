<x-app-layout>
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
                            <div class="text-center" style="margin: 50px 0;">Votre panier est vide</div>
                            @else
                            @foreach ($cartItems as $item)
                            <div class="row mb-4">
                                <div class="col-lg-3 col-md-12 mb-4 mb-lg-0">
                                    <div class="bg-image hover-overlay hover-zoom ripple rounded" data-mdb-ripple-color="light">
                                        <img src="{{ asset('/img/' . $item['image']) }}" class="w-100" alt="{{ $item['name'] }}" />
                                        <a href="#!">
                                            <div class="mask" style="background-color: rgba(251, 251, 251, 0.2)"></div>
                                        </a>
                                    </div>
                                </div>

                                <div class="col-lg-5 col-md-6 mb-4 mb-lg-0">
                                    <p><strong>{{ $item['name'] }}</strong></p>
                                    <p class="text-muted">Prix unitaire : € {{ number_format($item['price'], 2) }}</p>
                                    <button type="button" class="btn btn-primary btn-sm me-1 mb-2" onclick="viderArticlePanier(this)" data-article-id="{{ $item['id'] }}" title="Retirer l'article">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>

                                <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                                    <div class="d-flex mb-4" style="max-width: 300px">
                                        <button class="btn btn-primary px-3 me-2" onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                                            <i class="fas fa-minus"></i>
                                        </button>

                                        <div class="form-outline">
                                            <input type="number" value="{{ $item['quantity'] }}" class="form-control" min="1" onchange="changerQuantiter(this)" data-item-price="{{ $item['price'] }}" data-item-id="{{ $item['id'] }}" />
                                            <label class="form-label">Quantité</label>
                                        </div>

                                        <button class="btn btn-primary px-3 ms-2" onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>

                                    <p class="text-start text-md-center">
                                        <strong class="item-price" data-item-price="{{ $item['price'] }}">€ {{ number_format($item['price'] * $item['quantity'], 2) }}</strong>
                                    </p>
                                </div>
                            </div>
                            <hr class="my-4" />
                            @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-body">
                            <p><strong>Expédition prévue</strong></p>
                            <p class="mb-0">12.10.2020 - 14.10.2020</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header py-3">
                            <h5 class="mb-0">Résumé</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                                    Produits
                                    <span id="totalPrice">€ {{ number_format($totalPrice, 2) }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    Expédition
                                    <span>Gratuit</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                                    <div class="d-flex justify-content-between mb-5">
                                        <h5 class="text-uppercase">Prix Total</h5>
                                        <h5 id="totalPrice">€ {{ number_format($totalPrice, 2) }}</h5>
                                    </div>
                                </li>
                            </ul>

                            @if(auth()->check())
                            <form action="{{ route('passer-commande') }}" method="post" onsubmit="event.preventDefault(); passerCommande();">
                                @csrf
                                <input type="text" class="form-control" name="adresse_livraison" id="adresse_livraison" placeholder="Adresse de livraison" required>
                                <br>
                                <button type="submit" id="passCommandButton" class="btn btn-dark btn-block btn-lg">Passer la commande</button>
                            </form>
                            @else
                            <p>Connectez-vous pour passer une commande.</p>
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
        function viderPanier() {
            fetch('/vider-panier', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    location.reload();
                })
                .catch(error => {
                    console.error('Erreur lors de la suppression du panier :', error);
                });
        }

        function viderArticlePanier(button) {
            var articleId = button.getAttribute('data-article-id');

            fetch('{{ route("vider-article-panier") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        article_id: articleId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    if (!data.error) {
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Erreur lors de la suppression de l\'article :', error);
                });
        }

        function changerQuantiter(input) {
            var newQuantity = parseInt(input.value);
            var pricePerItem = parseFloat(input.getAttribute("data-item-price"));

            if (!isNaN(newQuantity) && newQuantity > 0) {
                var itemPriceElement = input.closest('.row').querySelector(".item-price");

                if (itemPriceElement) {
                    var newTotal = newQuantity * pricePerItem;
                    itemPriceElement.textContent = "€ " + newTotal.toFixed(2);
                    calculerPrixTotal();
                }
            } else {
                input.value = 1; // Default to 1 if invalid
            }
        }

        function calculerPrixTotal() {
            var itemPrices = document.querySelectorAll('.item-price');
            var totalPrice = Array.from(itemPrices).reduce((sum, itemPrice) => sum + parseFloat(itemPrice.textContent.replace('€ ', '')), 0);
            document.querySelector('#totalPrice').textContent = "€ " + totalPrice.toFixed(2);
        }

        function passerCommande() {
            const adresseLivraison = document.getElementById('adresse_livraison').value;

            fetch('{{ route("passer-commande") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        adresse_livraison: adresseLivraison
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.error) {
                        alert(data.message);
                        viderPanier();
                    } else {
                        alert(data.message || 'Une erreur est survenue.');
                    }
                })
                .catch(error => {
                    console.error('Erreur lors de la commande :', error);
                    alert('Une erreur est survenue lors du passage de la commande.');
                });
        }
    </script>
</x-app-layout>