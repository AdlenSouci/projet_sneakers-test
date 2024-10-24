<x-app-layout>
    <section class="h-100 h-custom" style="background-color: #eee;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col">
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-lg-7">
                                    <h5 class="mb-3">
                                        <a href="/shop" class="text-body">
                                            <i class="fas fa-long-arrow-alt-left me-2"></i> Continue shopping
                                        </a>
                                    </h5>
                                    <hr>

                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div>
                                            <p class="mb-1">Shopping cart</p>
                                            <p class="mb-0">{{ count($cartItems) }} items in your cart</p>
                                        </div>
                                        <div>
                                            <p class="mb-0">
                                                <span class="text-muted">Sort by:</span>
                                                <a href="#!" class="text-body">price <i class="fas fa-angle-down mt-1"></i></a>
                                            </p>
                                        </div>
                                    </div>

                                    @foreach ($cartItems as $item)
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex flex-row align-items-center">
                                                    <div>
                                                        <img src="{{ asset('/img/' . $item['image']) }}" class="img-fluid rounded-3" alt="{{ $item['name'] }}" style="width: 65px;">
                                                    </div>
                                                    <div class="ms-3">
                                                        <h5>{{ $item['name'] }}</h5>
                                                        <p class="small mb-0">Reference: {{ $item['id'] }}</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-row align-items-center">
                                                    <div style="width: 50px;">
                                                        <input type="number" value="{{ $item['quantity'] }}" class="form-control rounded" min="1" onchange="changerQuantiter(this)" data-item-price="{{ $item['price'] }}" data-item-id="{{ $item['id'] }}">
                                                    </div>
                                                    <div style="width: 80px;">
                                                        <h5 class="mb-0 item-price" data-item-price="{{ $item['price'] }}">
                                                            € {{ number_format($item['price'] * $item['quantity'], 2) }}
                                                        </h5>
                                                    </div>
                                                    <a href="#!" class="text-muted" onclick="viderArticlePanier(this)" data-article-id="{{ $item['id'] }}">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach

                                    <div class="pt-5">
                                        <button class="btn btn-danger" onclick="viderPanier()">Vider le panier</button>
                                    </div>
                                </div>

                                <div class="col-lg-5 bg-grey">
                                    <div class="p-5">
                                        <h3 class="fw-bold mb-5 mt-2 pt-1">Résumé</h3>
                                        <hr class="my-4">
                                        <div class="d-flex justify-content-between mb-5">
                                            <h5 class="text-uppercase">Total price</h5>
                                            <h5 id="totalPrice">€ {{ number_format($totalPrice, 2) }}</h5>
                                        </div>

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
                </div>
            </div>
        </div>
    </section>

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
                var itemPriceElement = input.closest('.d-flex').querySelector(".item-price");

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

    @vite(['resources/css/panier.css'])

</x-app-layout>
